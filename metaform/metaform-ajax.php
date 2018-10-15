<?php
  defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../settings/settings.php');
  require_once( __DIR__ . '/metaform-utils.php');

  use \Metatavu\Metaform\MetaformUtils;
  use \Metatavu\Metaform\Api\ApiClient;
  use \Metatavu\Metaform\Settings\Settings;

  add_action('rest_api_init', function() {
    register_rest_route('metaform', 'files/upload', [
      'methods' => 'POST',
      'callback' => 'uploadFile',
    ]);

    register_rest_route('metaform', 'files/upload/(?P<id>\S+)', [
      'methods' => 'GET',
      'callback' => 'getFile',
    ]);

    register_rest_route('metaform', 'files/upload/(?P<id>\S+)', [
      'methods' => 'DELETE',
      'callback' => 'deleteFile',
    ]);

    register_rest_route('metaform', '/formDraft', [
      'methods' => 'POST',
      'callback' => 'saveDraft',
    ]);

    register_rest_route('metaform', '/formDraft/email', [
      'methods' => 'POST',
      'callback' => 'sendEmail',
    ]);
  });

  /**
   * Send email
   */
  function sendEmail () {
    $data = ['email' => $_POST['email'], 'draftUrl' => $_POST['draftUrl']];
    $payload = json_encode($data);
    $ch = curl_init("http://localhost:3000/formDraft/email");

    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
      'Content-Type: application/json'                                                                
    ));
    $result = utf8_decode(curl_exec($ch));
    curl_close ($ch);

    return $result;
  }

  /**
   * Save draft
   */
  function saveDraft() {
    $formData = $_POST['reply'];

    $ch = curl_init(Settings::getValue("management-url") . "/formDraft");

    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = utf8_decode(curl_exec($ch));
    curl_close ($ch);

    return $result;
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

  /**
   * Upload image
   */
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
   * Save Metaform
   */
  add_action('wp_ajax_save_metaform', function () {
    $id = $_POST['id'];
    $values = $_POST['values'];
    $updateExisting = $_POST["updateExisting"];
    
    if (!$updateExisting) {
      $updateExisting = "true";
    }

    $userId = wp_get_current_user()->ID;
    $ssoUserId = get_user_meta($userId, "openid-connect-generic-subject-identity", true);
    $realmId = Settings::getValue("realm-id");

    $repliesApi = ApiClient::getRepliesApi();
    $metaformsApi = ApiClient::getMetaformsApi();
    $metaformJson = $metaformsApi->findMetaform($realmId, $id);

    $replyData = MetaformUtils::getFormData($metaformJson, $values);

    $reply = new \Metatavu\Metaform\Api\Model\Reply([
      "userId" => $ssoUserId,
      "data" => $replyData
    ]);

    $repliesApi->createReply($realmId, $id, $reply, $updateExisting);

    $response= array(
      'message'   => 'Saved'
    );
    wp_send_json_success($response);
  });
?>