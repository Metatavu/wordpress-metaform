<?php

  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );

  require_once( __DIR__ . '/abstract-reply-strategy.php');
  require_once( __DIR__ . '/postmeta-reply-strategy.php');
  require_once( __DIR__ . '/reply-strategy-factory.php');
  require_once( __DIR__ . '/usermeta-reply-strategy.php');

  if (!defined('ABSPATH')) { 
    exit;
  }
  
?>