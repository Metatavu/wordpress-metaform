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

  });

  

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
   * Save Metaform
   */
  add_action('wp_ajax_metaform_save_reply', function () {
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
  
  /**
   * Save Metaform
   */
  add_action('wp_ajax_metaform_save_draft', function () {
    $managementUrl = \Metatavu\Metaform\Settings\Settings::getValue("management-url");
    $realmId = Settings::getValue("realm-id");

    if (empty($managementUrl) || empty($realmId)) {
      wp_send_json_error([
        "message" => "Invalid configuration for drafts"
      ]);

      return;
    }
    
    $id = $_POST['id'];
    $values = $_POST['values'];
    $metaformsApi = ApiClient::getMetaformsApi();
    $metaform = $metaformsApi->findMetaform($realmId, $id);
    
    if (!$metaform) {
      return wp_send_json_error([
        "message" => "Form not found"
      ]);
    }

    $formData = MetaformUtils::getFormData($metaform, $values);

    $ch = curl_init("$managementUrl/formDraft");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
      "formData" => $formData
    ]));

    $result = utf8_decode(curl_exec($ch));
    curl_close ($ch);

    $draft = json_decode($result);
    if ($draft && $draft->id) {
      wp_send_json_success([
        "draftId" => $draft->id
      ]);  
    } else {
      wp_send_json_error([
        "message" => "Drafting failed"
      ]);
    }
  });
  
  /**
   * Email Metaform draft
   */
  add_action('wp_ajax_metaform_email_draft', function () {
    $managementUrl = \Metatavu\Metaform\Settings\Settings::getValue("management-url");
    $realmId = Settings::getValue("realm-id");

    if (empty($managementUrl) || empty($realmId)) {
      return wp_send_json_error([
        "message" => "Invalid configuration for drafts"
      ]);
    }

    $email = $_POST['email'];
    $draftId = $_POST['draft-id'];
    $draftUrl = $_POST['draft-url'];

    if (empty($email) || empty($draftId) || empty($draftUrl)) {
      return wp_send_json_error([
        "message" => "Missing parameters"
      ]);
    }

    $ch = curl_init("$managementUrl/formDraft/$draftId/email");
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST,1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
      "email" => $email,
      "draftUrl" => $draftUrl
    ]));

    $result = utf8_decode(curl_exec($ch));
    curl_close ($ch);
    
    wp_send_json_success([
      "message" => "Email sent"
    ]);  
  });
?>