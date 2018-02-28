<?php
  namespace Metatavu\Metaform;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( 'Metatavu\Metaform\MetaformShortcodes' ) ) {
    
    class MetaformShortcodes {
      
      /**
       * Constructor
       */
      public function __construct() {
        $metaformUrl = '//cdn.metatavu.io/libs/metaform-fields/0.6.12';
      
        wp_enqueue_style('font_awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' );
        wp_register_style('jquery-ui', '//cdn.metatavu.io/libs/jquery-ui/1.12.1/jquery-ui.min.css');
        wp_register_style('flatpickr', '//cdn.metatavu.io/libs/flatpickr/4.0.6/flatpickr.min.css');
        wp_register_style('metaform', '//cdn.metatavu.io/libs/metaform-fields/0.6.6/css/form.min.css', ['font_awesome', 'jquery-ui', 'flatpickr']);
  
        wp_register_script('moment', "//cdn.metatavu.io/libs/moment/2.17.1/moment-with-locales.js");
        wp_register_script('flatpickr', '//cdn.metatavu.io/libs/flatpickr/4.0.6/flatpickr.min.js');
        wp_register_script('flatpickr-fi', '//cdn.metatavu.io/libs/flatpickr/4.0.6/l10n/fi.js');
        wp_register_script('metaform-form', "$metaformUrl/js/form.js");
        wp_register_script('metaform-utils', "$metaformUrl/js/form-utils.js");
        wp_register_script('metaform-modernizr', "$metaformUrl/js/modernizr.js");
        wp_register_script('metaform-client', "$metaformUrl/js/metaform-client.min.js", ['jquery', 'jquery-ui-dialog', 'jquery-ui-tabs', 'flatpickr', 'flatpickr-fi', 'metaform-form', 'metaform-utils', 'metaform-modernizr']);

        add_shortcode('metaform', [$this, 'metaformShortcode']);

        wp_register_script('metaform-init', plugin_dir_url(dirname(__FILE__)) . 'metaform-init.js', ['metaform-client']);
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
          'id' => 0
        ], $tagAttrs);

        wp_enqueue_style('metaform');
        wp_enqueue_script('metaform-init');

        $json = get_post_meta($attrs['id'], "metaform-json", true);
        echo sprintf('<div id="metaform-%s" class="metaform" data-json="%s"/>', $attrs['id'], htmlspecialchars($json));
      }
      
    }
  
  }
  
  add_action('init', function () {
    new MetaformShortcodes();
  });
  
?>