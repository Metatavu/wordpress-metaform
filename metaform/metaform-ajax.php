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
      add_action('wp_ajax_nopriv_metaform_save_reply', [$this, "saveReply"]);
      add_action('wp_ajax_nopriv_metaform_save_draft', [$this, "saveDraft"]);
      add_action('wp_ajax_nopriv_metaform_email_draft', [$this, "sendDraftEmail"]);
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
  
      $realmId = Settings::getValue("realm-id");
      if (empty($realmId)) {
        return wp_send_json_error([
          "message" => "Invalid configuration for Metaforms"
        ]);
      }

      $repliesApi = ApiClient::getRepliesApi();
      $metaformsApi = ApiClient::getMetaformsApi();
      $metaformJson = $metaformsApi->findMetaform($realmId, $id);
  
      $replyData = MetaformUtils::getFormData($metaformJson, $values);
  
      $reply = new \Metatavu\Metaform\Api\Model\Reply([
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
        return wp_send_json_error([
          "message" => "Invalid configuration for drafts"
        ]);
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

      $response = wp_remote_post("$managementUrl/formDraft", [
        "headers" => [
          'Content-Type' => 'application/json'
        ],
        "body" => json_encode([
          "formData" => $formData
        ])
      ]);

      $body = $response["body"];

      if (!$this->isRemoteSuccess($response)) {
        wp_send_json_error([
          "message" => !empty($body) ? $body : "Drafting failed"
        ]);
      }

      $draft = json_decode($body);
      if ($draft && $draft->id) {
        wp_send_json_success([
          "draftId" => $draft->id
        ]);  
      } else {
        wp_send_json_error([
          "message" => !empty($body) ? $body : "Drafting failed"
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

      $response = wp_remote_post("$managementUrl/formDraft/$draftId/email", [
        "headers" => [
          'Content-Type' => 'application/json'
        ],
        "body" => json_encode([
          "email" => $email,
          "draftUrl" => $draftUrl
        ])
      ]);

      $body = $response["body"];
      if (!$this->isRemoteSuccess($response)) {
        wp_send_json_error([
          "message" => !empty($body) ? $body : "Email sending failed"
        ]);
      }

      wp_send_json_success([
        "message" => "Email sent"
      ]); 
    }

    /**
     * Returns whether request mady by wp_remote_xxx function is a success
     * 
     * @param {Object} $response response object
     * @return {Boolean} whether the response is a success
     */
    private function isRemoteSuccess($response) {
      if (is_wp_error($response)) {
        return false;
      }

      $code = $response["response"]["code"];

      return $code >= 200 && $code <= 299;
    }
  }

  new MetaformAjax();
  
?>