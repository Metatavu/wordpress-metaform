<?php

  namespace Metatavu\Metaform\ReplyStrategy;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  if (!class_exists( '\Metatavu\Metaform\ReplyStrategy\ReplyStrategyFactory' ) ) {
  
    /**
     * Factory class for reply strategies
     */
    class ReplyStrategyFactory {

      /**
       * Returns array of supported strategy names
       */
      public static function getSupportedStrategies() {
        return ['wordpress_postmeta', 'wordpress_usermeta'];
      }

      /**
       * Creates an instance of given strategy or null if the stategy is not supported
       * 
       * @return \Metatavu\Metaform\ReplyStrategy\AbstractReplyStrategy instance
       */
      public static function createStrategy($name) {
        if (!$name) {
          return null;
        }

        switch ($name) {
          case 'wordpress_postmeta':
            return new PostMetaReplyStrategy();
          case 'wordpress_usermeta':
           return new UserMetaReplyStrategy();
        }

        return null;
      }
      
    }
  }

?>