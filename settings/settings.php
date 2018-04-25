<?php
  namespace Metatavu\Metaform\Settings;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  require_once('settings-ui.php');  
  
  if (!class_exists( '\Metatavu\Metaform\Settings\Settings' ) ) {

    /**
     * Settings class
     */
    class Settings {

      /**
       * Getter for option value
       * 
       * @param string $name option name
       * @return string option value
       */
      public static function getValue($name) {
        $options = get_option('metaform');
        if ($options) {
          return $options[$name];
        }

        return null;
      }
      
    }

  }
  

?>