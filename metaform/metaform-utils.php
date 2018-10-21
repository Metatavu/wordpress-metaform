<?php
  namespace Metatavu\Metaform;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../settings/settings.php');

  if (!class_exists('Metatavu\Metaform\MetaformUtils')) {
    
    /**
     * Metaform REST operations 
     */
    class MetaformUtils {

      /**
       * Returns version of Metaform JSON that is suitable for
       * Wordpress plugin 
       */
      public static function getMetaformJson($metaform) {
        $metaformId = $metaform->getId();
        $uploadUrl = "/wp-json/wp/v2/metaforms/$metaformId/files/upload/";

        foreach($metaform->getSections() as $section) {
          foreach ($section->getFields() as $field) {
            if ($field->getType() == "files") {
              $field->setUploadUrl($uploadUrl);
            }
          }
        }

        return $metaform->__toString();
      }
      
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
       * Get field names by type
       * 
       * @param $metaform Metaform
       * @param $type Type of field
       * 
       * @return $result Array of field names
       */
      public static function getFieldNamesByType($metaform, $type) {
        $result = [];
        foreach (self::getFieldsByType($metaform, $type) as $field) {
          $result[] = $field->getName();
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

      /**
       * Returns API upload URL
       * 
       * @return {String} API upload URL
       */
      public static function getUploadUrl() {
        $apiUrl = \Metatavu\Metaform\Settings\Settings::getValue("api-url");
        return preg_replace("/\/v1.*/", "/fileUpload", $apiUrl);
      }

    }
  }

?>