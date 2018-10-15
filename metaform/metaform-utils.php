<?php
  namespace Metatavu\Metaform;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  if (!class_exists('Metatavu\Metaform\MetaformUtils')) {
    
    /**
     * Metaform REST operations 
     */
    class MetaformUtils {
      
      /**
       * Get fields from metaform
       * 
       * @param $metaform Metaform
       * 
       * @return $fields Metaform fields
       */
      public static function getFields($metaform) {
        $fields = [];
      
        foreach($metaform->getSections() as $section) {
          foreach ($section->getFields() as $field) {
            $fields[] = $field;
          }
        }
        
        return $fields;
      }

      /**
       * Get fields by type
       * 
       * @param $metaform Metaform
       * @param $type Type of field
       * 
       * @return $result Array of fields
       */
      public static function getFieldsByType($metaform, $type) {
        $result = [];
        foreach (self::getFields($metaform) as $field) {
          if ($type == $field->getType()) {
            $result[] = $field;
          }
        }

        return $result;
      }

      /**
       * Get form data
       * 
       * @param $metaform Metaform
       * @param $values Metaform values
       * 
       * @return $replyData replydata
       */
      public static function getFormData($metaform, $values) {
        $replyData = json_decode(stripslashes($values), true);
        $tableFields = self::getFieldsByType($metaform, "table");

        foreach ($tableFields as $tableField) {
          $tableValue = $replyData[$tableField->getName()];

          if (!empty($tableValue) && is_string($tableValue)) {
            $replyData[$tableField->getName()] = json_decode($tableValue, true);
          }
        }

        return $replyData;
      }

    }
  }

?>