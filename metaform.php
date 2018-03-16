<?php
/*
 * Created on Feb 28, 2018
 * Plugin Name: Wordpress Metaform integration
 * Description: Wordpress integration for Metaforms
 * Version: 0.0.4
 * Author: Metatavu Oy
 */

  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );
  
  if (!defined('PAKKASMARJA_MANAGEMENT_I18N_DOMAIN')) {
    define('PAKKASMARJA_MANAGEMENT_I18N_DOMAIN', 'pakkasmarja_management');
  }

  require_once( __DIR__ . '/metaform/metaform.php');
  require_once( __DIR__ . '/metaform/metaform-shortcodes.php');
  require_once( __DIR__ . '/metaform/metaform-ajax.php');
 
?>
