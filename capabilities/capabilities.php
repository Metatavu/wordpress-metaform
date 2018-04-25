<?php

  namespace Metatavu\Metaform;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Metaform\Capabilities' ) ) {
  
    class Capabilities {
      
      private static $capabilities = [
        'metaform_rest_create_reply',
        'metaform_read_replies',
        'metaform_migrate'
      ];
      
    }
  }

?>