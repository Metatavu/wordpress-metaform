<?php
  defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../settings/settings.php');

  use \Metatavu\Metaform\Api\ApiClient;
  use \Metatavu\Metaform\Settings\Settings;

  add_action('wp_ajax_save_metaform', function () {
    $id = $_POST['id'];
    $values = $_POST['values'];
    $updateExisting = $_POST["updateExisting"];
    if (!$updateExisting) {
      $updateExisting = "true";
    }

    $userId = wp_get_current_user()->ID;
    $metaformApiId = get_post_meta($id, "metaform-api-id", true);
    update_user_meta($userId, "metaform-$id-values", $values);

    if (!empty($metaformApiId)) {
      $replyData = json_decode(stripslashes($values), true);
      $realmId = Settings::getValue("realm-id");
      $repliesApi = ApiClient::getRepliesApi();
      $ssoUserId = get_user_meta($userId, "openid-connect-generic-subject-identity", true);
      $reply = new \Metatavu\Metaform\Api\Model\Reply([
        "userId" => $ssoUserId,
        "data" => $replyData
      ]);
      
      $repliesApi->createReply($realmId, $metaformApiId, $reply, $updateExisting);
    }

    do_action("after_metaform_save_reply", $id);

    wp_die();
  });

  add_action('wp_ajax_save_metaform_revision', function () {
    $id = $_POST['id'];
    $userId = wp_get_current_user()->ID;
    $values = get_user_meta($userId, "metaform-$id-values", true);
    update_user_meta($userId, "metaform-$id-revision-values", $values);
    wp_die();
  });

?>