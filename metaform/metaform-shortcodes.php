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
        $metaformUrl = '//cdn.metatavu.io/libs/metaform-fields/0.6.23';
        
        wp_enqueue_style('font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
        wp_enqueue_style('jquery-ui', '//cdn.metatavu.io/libs/jquery-ui/1.12.1/jquery-ui.min.css');
        wp_enqueue_style('flatpickr', '//cdn.metatavu.io/libs/flatpickr/4.0.6/flatpickr.min.css');
        wp_enqueue_style('hyperform', '//cdn.metatavu.io/libs/hyperform/0.8.15/hyperform.min.css');
        wp_enqueue_style('animate-css', 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css');
        wp_register_style('metaform', "$metaformUrl/css/form.min.css");
  
        wp_register_script('moment', "//cdn.metatavu.io/libs/moment/2.17.1/moment-with-locales.js");
        wp_register_script('jquery-ui_touch-punch', "//cdn.metatavu.io/libs/jquery.ui.touch-punch/0.2.3/jquery.ui.touch-punch.min.js");
        wp_register_script('flatpickr', '//cdn.metatavu.io/libs/flatpickr/4.0.6/flatpickr.min.js');
        wp_register_script('flatpickr-fi', '//cdn.metatavu.io/libs/flatpickr/4.0.6/l10n/fi.js');
        wp_enqueue_script('bootstrap-js', '//cdn.metatavu.io/libs/bootstrap/4.1.0/js/bootstrap.min.js', ['jquery']);
        wp_enqueue_script('hyperform', '//cdn.metatavu.io/libs/hyperform/0.8.15/hyperform.min.js', ['jquery']);
        wp_enqueue_script('jquery-ui', '//cdn.metatavu.io/libs/jquery-ui/1.12.1/jquery-ui.min.js', ['jquery']);
        wp_enqueue_script('fileupload-iframe', '//cdn.metatavu.io/libs/jquery.fileupload/9.14.2/js/jquery.iframe-transport.js', ['jquery-ui']);
        wp_enqueue_script('fileupload', '//cdn.metatavu.io/libs/jquery.fileupload/9.22.0/js/jquery.fileupload.js', ['jquery-ui']);
        wp_register_script('metaform-form', "$metaformUrl/js/form.js");
        wp_register_script('metaform-utils', "$metaformUrl/js/form-utils.js");
        wp_register_script('metaform-modernizr', "$metaformUrl/js/modernizr.js");
        wp_register_script('metaform-client', "$metaformUrl/js/metaform-client.min.js", ['jquery', 'jquery-ui-dialog', 'jquery-ui-tabs', 'flatpickr', 'flatpickr-fi', 'metaform-form', 'metaform-utils', 'metaform-modernizr', 'jquery-ui_touch-punch']);

        add_shortcode('metaform', [$this, 'metaformShortcode']);

        wp_register_script('metaform-init', plugin_dir_url(dirname(__FILE__)) . 'metaform-init.js', ['metaform-client']);
        wp_localize_script('metaform-init', 'metaformwp', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ]);

        wp_register_script('metaform-js', plugin_dir_url(dirname(__FILE__)) . '/metaform/js/metaform.js', ['jquery']);
        wp_localize_script('metaform-js', 'metaformwp', [ 'ajaxurl' => admin_url( 'admin-ajax.php' ) ]);
        wp_enqueue_script('metaform-js');

        if (!is_admin()) {
          wp_enqueue_style('bootstrap-css', '//cdn.metatavu.io/libs/bootstrap/4.1.0/css/bootstrap.min.css');
        }
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
        global $post;

        $attrs = shortcode_atts([
          'default-values' => '',
          'class' => '',
          'id' => '',
          'load-values' => 'true'
        ], $tagAttrs);

        $id = $attrs['id'];
        if (!$id) {
          $id = get_the_ID();
        }

        $metaformsApi = ApiClient::getMetaformsApi();
        $realmId = Settings::getValue("realm-id");
        $metaformId = $id;
        $metaform = null;
        
        if ($_GET['replyId']) {
          $formValues = $this->getFormValues($_GET['replyId'])->reply;
          error_log($formValues);
        }

        if ($metaformId) {
          $metaform = $metaformsApi->findMetaform($realmId, $metaformId);
        }

        if (!isset($metaform)) {
          return;
        }

        $json = $metaform->__toString();
        $allowDrafts = $metaform->getAllowDrafts();

        wp_enqueue_style('metaform');
        wp_enqueue_script('metaform-init');

        return sprintf('<div id="metaform-%s" data-allow-drafts="%s" class="metaform-container %s" data-id="%s" data-view-model="%s" data-form-values="%s"/>', $id, $allowDrafts ? "true" : "false", $attrs['class'], $id, htmlspecialchars($json), htmlspecialchars($formValues));
      }

      /**
       * Get form values
       */
      public function getFormValues($id) {
        $ch = curl_init("http://localhost:3000/formDraft?draftId=$id");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = utf8_decode(curl_exec($ch));
        curl_close ($ch);
        return json_decode($result);
      }
      
    }
  
  }
  
  add_action('init', function () {
    new MetaformShortcodes();
  });
  
?>
