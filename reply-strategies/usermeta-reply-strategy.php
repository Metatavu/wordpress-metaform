<?php

  namespace Metatavu\Metaform\ReplyStrategy;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Metaform\ReplyStrategy\UserMetaReplyStrategy' ) ) {
  
    /**
     * User meta (Wordpress user) reply strategy implementation
     */
    class UserMetaReplyStrategy extends AbstractReplyStrategy {
      
      /**
       * Returns reply strategy's name
       */
      public function getName() {
        return 'wordpress_usermeta';
      }
      
      /**
       * Returns reply strategy's human readable label
       */
      public function getLabel() {
        return __( 'Wordpress User', 'metaform');
      }
      
      /**
       * Returns reply for metaform and user
       * 
       * This implementation returns value for $user
       * 
       * @param \WP_Post $metaform metaform
       * @param \WP_User $user user
       * @return reply for metaform and user
       */
      public function getValue($metaform, $user) {
        $id = $metaform->ID;
        $value = get_user_meta($user->ID, "metaform-$id-values", true);
        if (!$value) {
          return null;
        }

        return json_decode($value, true);
      }

      /**
       * Returns metaform values as user => values associative array
       * 
       * @return array Associative array of user replies with user as key 
       */
      public function getValues($metaform) {
        $result = [];
        $id = $metaform->ID;
        $users = get_users(['fields' => ['ID']]);

        foreach ($users as $user) {
          $json = get_user_meta($user->ID, "metaform-$id-values", true);
          if ($json) {
            $value = json_decode($json, true);
            $result[$userId] = $value;
          }
        }
        
        return $result;
      }

      /**
       * Sets reply for metaform and user.
       * 
       * This implementation sets a value into Wordpress usermeta and requires that $user is 
       * a valid Wordpress user
       * 
       * @param \WP_Post $metaform metaform
       * @param \WP_User $user user
       * @param Array $values associative array of values
       */
      public function setValue($metaform, $user, $values) {
        $key = uniqid();
        $value = json_encode($values);
        $id = $metaform->ID;
        update_user_meta($user->ID, "metaform-$id-values", $values);
      }

    }
  }

?>