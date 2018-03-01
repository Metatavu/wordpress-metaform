<?php
  defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

  add_action('wp_ajax_save_metaform', function () {
    error_log("DuUUR");

    $id = $_POST['id'];
    $values = $_POST['values'];
    $userId = wp_get_current_user()->ID;
    update_user_meta($userId, "metaform-$id-values", $values);
    wp_die();
  });
  
?>