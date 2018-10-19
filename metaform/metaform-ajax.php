<?php
  defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../settings/settings.php');
  require_once( __DIR__ . '/metaform-utils.php');

  use \Metatavu\Metaform\MetaformUtils;
  use \Metatavu\Metaform\Api\ApiClient;
  use \Metatavu\Metaform\Settings\Settings;

  class MetaformAjax {
    
    /**
     * Constructor
     */
    public function __construct() {
      add_action('wp_ajax_metaform_save_reply', [$this, "saveReply"]);
      add_action('wp_ajax_metaform_save_draft', [$this, "saveDraft"]);
      add_action('wp_ajax_metaform_email_draft', [$this, "sendDraftEmail"]);
    }

    /**
     * Save Metaform
     */
    public function saveReply() {
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
  
      wp_send_json_success([
        "message" => "Saved"
      ]);
    }

    /**
     * Save draft
     */
    public function saveDraft() {
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
    }

    /**
     * Email Metaform draft
     */
    public function sendDraftEmail() {
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
    }
  }

  new MetaformAjax();
  
?>