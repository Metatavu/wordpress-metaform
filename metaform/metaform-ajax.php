<?php
  defined( 'ABSPATH' ) || die( 'No script kiddies please!' );

  add_action('wp_ajax_save_metaform', function () {
    $id = $_POST['id'];
    $values = $_POST['values'];
    $userId = wp_get_current_user()->ID;
    update_user_meta($userId, "metaform-$id-values", $values);
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