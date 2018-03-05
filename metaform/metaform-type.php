<?php

  namespace Metatavu\Metaform\Type;
  
  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );

  if (!class_exists( '\Metatavu\Metaform\Type' ) ) {
  
    class Type {
      
      /**
       * Constructorr
       */
      public function __construct() {
        register_post_type ('metaform', [
          'labels' => [
              'name'               => __( 'Metaforms', 'metaform' ),
              'singular_name'      => __( 'Metaform', 'metaform' ),
              'add_new'            => __( 'Add Metaform', 'metaform' ),
              'add_new_item'       => __( 'Add New Metaform', 'metaform' ),
              'edit_item'          => __( 'Edit Metaform', 'metaform' ),
              'new_item'           => __( 'New Metaform', 'metaform' ),
              'view_item'          => __( 'View Metaform', 'metaform' ),
              'search_items'       => __( 'Search Metaforms', 'metaform' ),
              'not_found'          => __( 'No Metaforms found', 'metaform' ),
              'not_found_in_trash' => __( 'No Metaforms in trash', 'metaform' ),
              'menu_name'          => __( 'Metaforms', 'metaform' ),
              'all_items'          => __( 'Metaforms', 'metaform' )
          ],
          'taxonomies' => ['category'],
          'public' => true,
          'has_archive' => true,
          'supports' => ['title']
        ]);

        add_action ('add_meta_boxes', [$this, "addMetaboxes"], 9999, 2);
        add_action ('save_post', [$this, "savePost"]);    
        
        wp_register_style('codemirror', '//cdn.metatavu.io/libs/codemirror/5.35.0/lib/codemirror.css');
        wp_register_style('codemirror-js', plugin_dir_url(dirname(__FILE__)) . 'codemirror-js.css', ['codemirror']);
        wp_register_script('codemirror', "//cdn.metatavu.io/libs/codemirror/5.35.0/lib/codemirror.js");
        wp_register_script('codemirror-init', plugin_dir_url(dirname(__FILE__)) . 'codemirror-init.js', ['codemirror']);
        wp_register_script('codemirror-js', "//cdn.metatavu.io/libs/codemirror/5.35.0/mode/javascript/javascript.js", ['codemirror-init']);
      }

      /**
       * Adds metaboxes
       */
      public function addMetaboxes() {
        add_meta_box('metaform-json-meta-box', __( 'Metaform JSON', 'metaform' ), [$this, 'renderJsonMetaBox'], 'metaform', 'normal', 'default');
      }

      /**
       * Renders metaform-json metabox
       * 
       * @param \WP_Post $metaform metaform post objects
       */
      public function renderJsonMetaBox($metaform) {
        wp_enqueue_style('codemirror-js');
        wp_enqueue_script('codemirror-js');
        $json = get_post_meta($metaform->ID, "metaform-json", true);
        echo sprintf('<textarea class="codemirror" name="metaform-json" style="%s" rows="20">%s</textarea>', 'width: 100%', htmlspecialchars($json));
      }

      /**
       * Post save hook
       */
      public function savePost($metaformId) {
        if (array_key_exists('metaform-json', $_POST)) {
          update_post_meta($metaformId, 'metaform-json', $_POST['metaform-json']);
        }
      }

    }
  }

  add_action ('init', function () {
    new Type();
  });

?>