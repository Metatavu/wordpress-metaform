<?php
  namespace Metatavu\Metaform;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  use \Metatavu\Metaform\ReplyStrategy\ReplyStrategyFactory;

  if (!class_exists('Metatavu\Metaform\Rest')) {
    
    /**
     * Metaform REST operations 
     */
    class Rest {
      
      /**
       * Constructor
       */
      public function __construct() {
        register_rest_route('wp/v2', '/metaform/(?P<id>\d+)/reply', [
          'methods' => 'POST',
          'callback' => [$this, "replyPostCallback"],
          'permission_callback' => [$this, "replyPostPermissionCallback"]
        ]);
      }

      /**
       * Handles a reply post call
       * 
       * @param Object $data request data
       * @return String response body
       */
      public function replyPostCallback($data) {
        $id = $data['id'];
        $metaform = get_post($id);
        if (!$metaform || $metaform->post_type !== 'metaform') {
          return new WP_Error('not_found', __('Metaform could not be found'), [ 'status' => 404 ] );
          exit;
        }

        $body = $data->get_body();
        if (!body) {
          return new WP_Error('body_missing', __('Body is required'), [ 'status' => 400 ] );
          exit;
        }

        $user = wp_get_current_user();
        $strategyName = get_post_meta($id, "metaform-reply-strategy", true);
        $strategy = ReplyStrategyFactory::createStrategy($strategyName);

        if (!$strategy) {
          return new WP_Error('unsupported_strategy', __('Metaform is using reply strategy that is not supported by the REST'), [ 'status' => 501 ] );
          exit;
        } else {
          $strategy->setValue($metaform, $user, $body);
          return "OK";
        }
      }

      /**
       * Returns whether logged use may post a reply to a metaform
       * 
       * @return boolean whether logged use may post a reply to a metaform
       */
      public function replyPostPermissionCallback() {
        return current_user_can('metaform_rest_create_reply');
      }

      /**
       * Returns whether string is valid JSON
       * 
       * @param String $string string
       * @return boolean whether string is valid JSON
       */
      private function isValidJson($string) {
        json_decode($string);
        return json_last_error() == JSON_ERROR_NONE;
      }

    }
  
  }
  
  add_action('rest_api_init', function () {
    new Rest();
  });
  
?>