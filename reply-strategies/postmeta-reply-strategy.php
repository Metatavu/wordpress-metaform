<?php

  namespace Metatavu\Metaform\ReplyStrategy;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Metaform\ReplyStrategy\PostMetaReplyStrategy' ) ) {
  
    /**
     * Post meta (anonymous) reply strategy implementation
     */
    class PostMetaReplyStrategy extends AbstractReplyStrategy {

      /**
       * Returns reply strategy's name
       */
      public function getName() {
        return 'wordpress_postmeta';
      }
      
      /**
       * Returns reply strategy's human readable label
       */
      public function getLabel() {
        return __( 'Wordpress Anonymous', 'metaform');
      }
      
      /**
       * Returns reply for metaform and user
       * 
       * This implementation does not support loading and always returns null 
       * 
       * @param \WP_Post $metaform metaform
       * @param \WP_User $user user
       * @return reply for metaform and user
       */
      public function getValue($metaform, $user) {
        return null;
      }

      /**
       * Returns metaform values as user => values associative array
       * 
       * @return array Associative array of user replies with user as key 
       */
      public function getValues($metaform) {
        $postMetas = get_post_meta($metaform->ID);
        $result = [];

        foreach ($postMetas as $metaKey => $metaValue) {
          if (substr($metaKey, 0, 14) === "metaform-anon-") {
            $json = array_shift($metaValue);
            $value = json_decode($json, true);
            if (json_last_error() === JSON_ERROR_NONE) {
              $result[substr($metaKey, 14)] = $value;
            }
          }
        }

        return $result;
      }

      /**
       * Sets reply for metaform and user
       * 
       * This implementation does not care about logged user but instead 
       * always creates new row into Wordpress postmeta.
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