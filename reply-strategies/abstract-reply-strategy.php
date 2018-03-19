<?php

  namespace Metatavu\Metaform\ReplyStrategy;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Metaform\ReplyStrategy\AbstractReplyStrategy' ) ) {
  
    /**
     * Abstract base class for reply strategies
     */
    class AbstractReplyStrategy {

      /**
       * Returns reply strategy's name
       */
      public function getName() {
      }
      
      /**
       * Returns reply strategy's human readable label
       */
      public function getLabel() {
      }

      /**
       * Returns reply for metaform and user
       * 
       * @param \WP_Post $metaform metaform
       * @param \WP_User $user user
       * @return reply for metaform and user
       */
      public function getValue($metaform, $user) {
      }

      /**
       * Sets reply for metaform and user
       * 
       * @param \WP_Post $metaform metaform
       * @param \WP_User $user user
       * @param Array $values associative array of values
       */
      public function setValue($metaform, $user, $values) {
        $key = uniqid();
        $value = json_encode($values);
        add_post_meta($metaform->ID, "metaform-anon-$key", $value, true);
      }

    }
  }

?>