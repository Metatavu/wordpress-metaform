<?php
  namespace Metatavu\Metaform\Api;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../vendor/autoload.php');
  require_once( __DIR__ . '/../settings/settings.php');

  if (!class_exists( '\Metatavu\Metaform\Api\ApiClient' ) ) {
    
    class ApiClient {
      
      /**
       * Returns new instance of MetaformsApi
       *         
       * @return \Metatavu\Metaform\Api\MetaformsApi
       */
      public static function getMetaformsApi() {
        return new \Metatavu\Metaform\Api\MetaformsApi(null, self::getConfiguration());
      }

      /**
       * Returns new instance of RepliesApi
       *         
       * @return \Metatavu\Metaform\Api\RepliesApi
       */
      public static function getRepliesApi() {
        return new \Metatavu\Metaform\Api\RepliesApi(null, self::getConfiguration());
      }
      
      /**
       * Returns client configuration
       * 
       * @returns \Metatavu\Metaform\Configuration
       */
      private static function getConfiguration() {
        $result = \Metatavu\Metaform\Configuration::getDefaultConfiguration();
        $result->setHost(\Metatavu\Metaform\Settings\Settings::getValue("api-url"));
        $result->setApiKey("Authorization", "Bearer " . self::getAccessToken());
        return $result;
      }

      /**
       * Returns access token for logged user. 
       * 
       * Token is retrived from previously stored values from OpenID Connect Generic -plugin.
       * 
       * @return string access token for logged user
       */
      private static function getAccessToken() {
        if (!is_user_logged_in()) {
          return self::getAnonymousToken();
        }

        $userId = wp_get_current_user()->ID;

        self::ensureFreshToken($userId);
        $tokenResponse = get_user_meta($userId, 'openid-connect-generic-last-token-response', true);
        
        if (!!$tokenResponse) {
          return $tokenResponse['access_token'];
        }

        return self::getAnonymousToken();
      }

      /**
       * Returns anonymous access token 
       * 
       * @return {String} anonymous access token
       */
      private static function getAnonymousToken() {
        $settings = self::getOpenIdSettings();

        $tokenEndpoint = $settings["endpoint_token"];
        $clientId = $settings["client_id"];
        $clientSecret = $settings["client_secret"];
        $passwordEncoded = base64_encode("$clientId:$clientSecret");
        $authorization = "Basic $passwordEncoded";

        $request = [
          'headers' => [
            'Authorization' => $authorization
          ],
          'body' => [
            'grant_type' => 'client_credentials'
          ]
        ];

        $response = wp_remote_post($tokenEndpoint, $request);
        if (is_wp_error($response)) {
          error_log("Failed to refresh anonymous token: " . print_r($response, true));
          return null;
        }

        $token = json_decode($response['body'], true);
        return $token["access_token"];
      }

      /**
       * Ensures that user has valid access token 
       */
      private static function ensureFreshToken($userId) {
        $sessionTokens = \WP_Session_Tokens::get_instance($userId);
        $session = $sessionTokens->get(wp_get_session_token());
        $refreshSlack = 60 * 5; // 5 minute slack
        
        if (!isset($session)) {
          error_log("Failed to resolve session, could not refresh token");
          return;
        }

        $refreshInfo = $session["openid-connect-generic-refresh"];
        if (!isset($refreshInfo)) {
          error_log("Failed to resolve session refresh info, could not refresh token");
          return;
        }

        $now = current_time('timestamp', true);
        $refreshTime = $refreshInfo['next_access_token_refresh_time'] - $refreshSlack;
        if ($now < $refreshTime) {
          // Token is still valid, no need to refresh
          return;
        }

        $refreshToken = $refreshInfo['refresh_token'];
        $refreshExpires = $refreshInfo['refresh_expires'];

        if (!$refreshToken || ($refreshExpires && $now > $refreshExpires)) {
          error_log("Failed to resolve refresh token, logout from the Wordpress");
          wp_logout();
          return;
        }

        $tokenResponse = self::refreshAccessToken($refreshToken);
        if (!isset($tokenResponse)) {
          error_log("Failed to refresh access token, logout from the Wordpress");
          wp_logout();
          return;
        }

        self::saveAccessToken($userId, $refreshToken, $tokenResponse);
      }

      /**
       * Saves new access token
       * 
       * @param int $userId user id 
       * @param string $refreshToken previous refresh token
       * @param array $tokenResponse token response
       */
      private static function saveAccessToken($userId, $refreshToken, $tokenResponse) {
        $sessionTokens = \WP_Session_Tokens::get_instance($userId);
        $session = $sessionTokens->get(wp_get_session_token());
        
        $now = current_time('timestamp' , true);
        $session["openid-connect-generic-refresh"] = [
          'next_access_token_refresh_time' => $tokenResponse['expires_in'] + $now,
          'refresh_token' => isset($tokenResponse['refresh_token']) ? $tokenResponse : $refreshToken,
          'refresh_expires' => false
        ];

        $session = $sessionTokens->get($token);
        $sessionTokens->update($sessionToken, $session);

        update_user_meta($userId, 'openid-connect-generic-last-token-response', $tokenResponse);
      }

      /**
       * Refreshes access token
       * 
       * @param String $refreshToken refresh token
       * @return array token response 
       */
      private static function refreshAccessToken($refreshToken) {
        $settings = self::getOpenIdSettings();

        $clientId = $settings["client_id"];
        $clientSecret = $settings["client_secret"];
        $tokenEndpoint = $settings['endpoint_token']; 

        $request = [
          'body' => [
            'refresh_token' => $refreshToken,
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'grant_type' => 'refresh_token'
          ]
        ];

        $response = wp_remote_post($tokenEndpoint, $request);
        if (is_wp_error($response)) {
          error_log("Failed to refresh token: " . print_r($response, true));
          return null;
        }

        return json_decode($response['body'], true);
      }

      /**
       * Returns OpenID Connect Generic -plugin settings
       * 
       * @return array OpenID Connect Generic -plugin settings
       */
      private static function getOpenIdSettings() {
        return get_option('openid_connect_generic_settings');
      }

    }
  }
  
?>