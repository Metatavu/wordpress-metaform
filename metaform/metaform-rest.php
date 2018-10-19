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
        register_rest_route('wp/v2', '/metaforms/(?P<id>\d+)/replies', [
          'methods' => 'POST',
          'callback' => [$this, "replyPostCallback"],
          'permission_callback' => [$this, "replyPostPermissionCallback"]
        ]);

        register_rest_route('metaform', 'files/upload', [
          'methods' => 'POST',
          'callback' => [$this, 'uploadFile']
        ]);

        register_rest_route('metaform', 'files/upload/(?P<id>\S+)', [
          'methods' => 'GET',
          'callback' => [$this, 'getFile']
        ]);

        register_rest_route('metaform', 'files/upload/(?P<id>\S+)', [
          'methods' => 'DELETE',
          'callback' => [$this, 'deleteFile']
        ]);
      }

      /**
       * Returns single file
       */
      function getFile($data) {
        $id = $data['id'];
        $ext = '';
        $extPath = tmpnam(sys_get_temp_dir(), $id . '.txt');
        $fh = fopen($extPath,'r');

        while ($line = fgets($fh)) {
          $ext = $line;
          break;
        }

        // TODO: Näytä file käyttäjälle
        $filePath = tmpnam(sys_get_temp_dir(), $id . $ext);
        wp_redirect();

        die;
      }

      /**
       * Upload image
       */
      function uploadImage($id) {
        $uploadUrl = sys_get_temp_dir();
        $fileWithOriginalName = $uploadUrl . basename($_FILES["file"]["name"]);
        $imageFileType = strtolower(pathinfo($fileWithOriginalName,PATHINFO_EXTENSION));
        $file = $uploadUrl . basename($id . '.' . $imageFileType);

        $metaFile = fopen($uploadUrl . $id . '.txt', "w");
        fwrite($metaFile, $imageFileType);
        fclose($metaFile);
        
        move_uploaded_file($_FILES["file"]["tmp_name"], $file);
      }

      /**
       * Upload file
       */
      function uploadFile () {
        $apiUrl = \Metatavu\Metaform\Settings\Settings::getValue("api-url");
        $uploadUrl = preg_replace("/\/v1.*/", "/fileUpload", $apiUrl);

        if (function_exists('curl_file_create')) {
          $cFile = curl_file_create($_FILES['file']['tmp_name'], $_FILES['file']['type'], $_FILES['file']['name']);
        } else {
          $cFile = new \CURLFile(($_FILES['file']['tmp_name']));
        }

        $post = array('file'=> $cFile);
        $ch = curl_init($uploadUrl);

        curl_setopt($ch, CURLOPT_POST,1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        curl_setopt($ch, CURLOPT_SAFE_UPLOAD, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = utf8_decode(curl_exec($ch));
        curl_close ($ch);

        $array = [];
        $array['result'] = json_decode($result, true);
        $array['result']['filename'] = $array['result']['fileName'];
        $array['result']['originalname'] = $array['result']['fileName'];
        $array['result']['_id'] = $array['result']['fileRef'];
      
        uploadImage($array['result']['fileRef']);
        wp_send_json($array);
      }

      /**
       * Delete file
       */
      function deleteFile($data) {
        $apiUrl = \Metatavu\Metaform\Settings\Settings::getValue("api-url");
        $uploadUrl = preg_replace("/\/v1.*/", "/fileUpload", $apiUrl);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $uploadUrl . '?fileRef=' . $data['id']);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
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
          return new \WP_Error('not_found', __('Metaform could not be found'), [ 'status' => 404 ] );
          exit;
        }

        $body = $data->get_body();
        if (!body) {
          return new \WP_Error('body_missing', __('Body is required'), [ 'status' => 400 ] );
          exit;
        }

        $user = wp_get_current_user();
        $strategyName = get_post_meta($id, "metaform-reply-strategy", true);
        $strategy = ReplyStrategyFactory::createStrategy($strategyName);

        if (!$strategy) {
          return new \WP_Error('unsupported_strategy', __('Metaform is using reply strategy that is not supported by the REST'), [ 'status' => 501 ] );
          exit;
        } else {
          $strategy->setValue($metaform, $user, json_decode($body, true));
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