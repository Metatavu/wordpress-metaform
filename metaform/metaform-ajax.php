<?php
  defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../settings/settings.php');

  use \Metatavu\Metaform\Api\ApiClient;
  use \Metatavu\Metaform\Settings\Settings;

  add_action('rest_api_init', function() {
    register_rest_route('files', '/upload', [
      'methods' => 'POST',
      'callback' => 'uploadFile',
    ]);

    register_rest_route('files', '/upload/(?P<id>\S+)', [
      'methods' => 'GET',
      'callback' => 'getFile',
    ]);

    register_rest_route('files', '/upload/(?P<id>\S+)', [
      'methods' => 'DELETE',
      'callback' => 'deleteFile',
    ]);
  });

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

  function getFile($data) {
    $id = $data['id'];
    $ext = '';
    $fh = fopen(__DIR__ . '/../tmp/' . $id . '.txt','r');

    while ($line = fgets($fh)) {
      $ext = $line;
      break;
    }

    wp_redirect(plugin_dir_url( __FILE__ ) . '../tmp/' . $id . '.' . $ext);
    die;
  }

  function uploadImage($id) {
    $uploadUrl = __DIR__ . '/../tmp/';
    $fileWithOriginalName = $uploadUrl . basename($_FILES["file"]["name"]);
    $imageFileType = strtolower(pathinfo($fileWithOriginalName,PATHINFO_EXTENSION));
    $file = $uploadUrl . basename($id . '.' . $imageFileType);

    $metaFile = fopen($uploadUrl . $id . '.txt', "w");
    fwrite($metaFile, $imageFileType);
    fclose($metaFile);
    
    move_uploaded_file($_FILES["file"]["tmp_name"], $file);
  }

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

  add_action('wp_ajax_save_metaform', function () {
    $id = $_POST['id'];
    $values = $_POST['values'];
    $updateExisting = $_POST["updateExisting"];
    if (!$updateExisting) {
      $updateExisting = "true";
    }

    $userId = wp_get_current_user()->ID;
    $replyData = json_decode(stripslashes($values), true);
    $realmId = Settings::getValue("realm-id");
    $repliesApi = ApiClient::getRepliesApi();
    $ssoUserId = get_user_meta($userId, "openid-connect-generic-subject-identity", true);

    $reply = new \Metatavu\Metaform\Api\Model\Reply([
      "userId" => $ssoUserId,
      "data" => $replyData
    ]);
    
    $repliesApi->createReply($realmId, $id, $reply, $updateExisting);
    error_log("hasd");
    $response= array(
      'message'   => 'Saved',
      'ID'        => 1
  );
  wp_send_json_success($response);
  });
?>