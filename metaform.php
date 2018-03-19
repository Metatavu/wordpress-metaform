<?php
/*
 * Created on Feb 28, 2018
 * Plugin Name: Wordpress Metaform integration
 * Description: Wordpress integration for Metaforms
 * Version: 0.0.5
 * Author: Metatavu Oy
 */

  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );
  
  require_once( __DIR__ . '/capabilities/capabilities.php');
  require_once( __DIR__ . '/reply-strategies/reply-strategies.php');
  require_once( __DIR__ . '/metaform/metaform.php');
  require_once( __DIR__ . '/metaform/metaform-shortcodes.php');
  require_once( __DIR__ . '/metaform/metaform-ajax.php');
 
  add_action('plugins_loaded', function() {
    load_plugin_textdomain('metaform', false, dirname( plugin_basename(__FILE__) ) . '/lang/' );
  });

?>
