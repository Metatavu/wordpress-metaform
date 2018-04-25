<?php
  namespace Metatavu\Metaform;
  
  if (!defined('ABSPATH')) { 
    exit;
  }

  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../settings/settings.php');

  use \Metatavu\Metaform\Api\ApiClient;
  use \Metatavu\Metaform\Settings\Settings;
  
  if (!class_exists( 'Metatavu\Metaform\MetaformShortcodes' ) ) {
    
    class MetaformShortcodes {
      
      /**
       * Constructor
       */
      public function __construct() {
        $metaformUrl = '//cdn.metatavu.io/libs/metaform-fields/0.6.16';
        
        wp_enqueue_style('font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
        wp_register_style('jquery-ui', '//cdn.metatavu.io/libs/jquery-ui/1.12.1/jquery-ui.min.css');
        wp_register_style('flatpickr', '//cdn.metatavu.io/libs/flatpickr/4.0.6/flatpickr.min.css');
        wp_register_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css');
        wp_register_style('metaform', "$metaformUrl/css/form.min.css", ['animate-css', 'font_awesome', 'jquery-ui', 'flatpickr']);
  
        wp_register_script('moment', "//cdn.metatavu.io/libs/moment/2.17.1/moment-with-locales.js");
        wp_register_script('jquery-ui_touch-punch', "//cdn.metatavu.io/libs/jquery.ui.touch-punch/0.2.3/jquery.ui.touch-punch.min.js");
        wp_register_script('flatpickr', '//cdn.metatavu.io/libs/flatpickr/4.0.6/flatpickr.min.js');
        wp_register_script('flatpickr-fi', '//cdn.metatavu.io/libs/flatpickr/4.0.6/l10n/fi.js');
        wp_register_script('metaform-form', "$metaformUrl/js/form.js");
        wp_register_script('metaform-utils', "$metaformUrl/js/form-utils.js");
        wp_register_script('metaform-modernizr', "$metaformUrl/js/modernizr.js");
        wp_register_script('metaform-client', "$metaformUrl/js/metaform-client.min.js", ['jquery', 'jquery-ui-dialog', 'jquery-ui-tabs', 'flatpickr', 'flatpickr-fi', 'metaform-form', 'metaform-utils', 'metaform-modernizr', 'jquery-ui_touch-punch']);

        add_shortcode('metaform', [$this, 'metaformShortcode']);

        wp_register_script('metaform-init', plugin_dir_url(dirname(__FILE__)) . 'metaform-init.js', ['metaform-client']);
        wp_localize_script('metaform-init', 'metaformwp', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ]);
      }
      
      /**
       * Renders a metaform.
       * 
       * Following attributes can be used to control the component:
       * 
       * <li>
       *   <ul><b>id:</b>id of the metaform</ul>
       * </li>
       * 
       * @param type $tagAttrs tag attributes
       * @return string replaced contents
       */
      public function metaformShortcode($tagAttrs) {
        $attrs = shortcode_atts([
          'default-values' => '',
          'class' => '',
          'id' => ''
        ], $tagAttrs);

        $id = $attrs['id'];
        if (!$id) {
          $id = get_the_ID();
        }

        $userId = wp_get_current_user()->ID;
        $metaformApiId = get_post_meta($id, "metaform-api-id", true);
        $formValues = [];

        if (!empty($metaformApiId)) {
          $realmId = Settings::getValue("realm-id");
          $repliesApi = ApiClient::getRepliesApi();
          $ssoUserId = get_user_meta($userId, "openid-connect-generic-subject-identity", true);
          $replies = $repliesApi->listReplies($realmId, $metaformApiId, $ssoUserId);
          $reply = count($replies) > 0 ? $replies[0] : null;
          $formValues = $reply ? $reply->getData() : [];
        } else {
          $defaultValues = json_decode($attrs['default-values'], true);
          $savedValues = json_decode(get_user_meta($userId, "metaform-$id-values", true), true);
          $formValues = $defaultValues ? $defaultValues : [];

          if ($savedValues) {
            foreach ($savedValues as $key => $value) {
              $formValues[$key] = $value;
            }
          }
        }

        wp_enqueue_style('metaform');
        wp_enqueue_script('metaform-init');

        $viewModel = get_post_meta($id, "metaform-json", true);
        return sprintf('<div id="metaform-%s" class="metaform-container %s" data-id="%s" data-view-model="%s" data-form-values="%s"/>', $id, $attrs['class'], $id, htmlspecialchars($viewModel), htmlspecialchars(json_encode($formValues)));
      }
      
    }
  
  }
  
  add_action('init', function () {
    new MetaformShortcodes();
  });
  
?>
