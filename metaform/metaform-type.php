<?php

  namespace Metatavu\Metaform\Type;
  
  defined ( 'ABSPATH' ) || die ( 'No script kiddies please!' );

  require_once( __DIR__ . '/../vendor/autoload.php');
  require_once( __DIR__ . '/../api/api-client.php');
  require_once( __DIR__ . '/../settings/settings.php');
  
  use \Metatavu\Metaform\ReplyStrategy\ReplyStrategyFactory;
  use \Metatavu\Metaform\Api\ApiClient;
  use \Metatavu\Metaform\Settings\Settings;

  if (!class_exists( '\Metatavu\Metaform\Type' ) ) {
  
    class Type {
      
      /**
       * Constructorr
       */
      public function __construct() {
        $this->registerMetaformType();

        add_action('admin_enqueue_scripts', [$this, 'enqueScripts']);
        add_action('admin_init',[$this, "adminInit"]);
        add_action('add_meta_boxes', [$this, "addMetaboxes"], 9999, 2);
        add_action('save_post_metaform', [$this, "saveMetaformPost"]);    
        
        wp_register_style('codemirror', '//cdn.metatavu.io/libs/codemirror/5.35.0/lib/codemirror.css');
        wp_register_style('codemirror-js', plugin_dir_url(dirname(__FILE__)) . 'codemirror-js.css', ['codemirror']);
        wp_register_script('codemirror', "//cdn.metatavu.io/libs/codemirror/5.35.0/lib/codemirror.js");
        wp_register_script('codemirror-init', plugin_dir_url(dirname(__FILE__)) . 'codemirror-init.js', ['codemirror']);
        wp_register_script('codemirror-js', "//cdn.metatavu.io/libs/codemirror/5.35.0/mode/javascript/javascript.js", ['codemirror-init']);
      }

      /**
       * Enque scripts hook
       */
      function enqueScripts() {
        switch(get_post_type()) {
          case 'metaform':
            wp_dequeue_script('autosave');
            break;
        }
      }

      /**
       * Admin init action
       */
      public function adminInit() {
        if (isset($_REQUEST['action']) && 'api-migrate' == $_REQUEST['action'] && $_REQUEST['post']) {
          $this->apiMigrate($_REQUEST['post'], intval($_REQUEST['offset']), $_REQUEST['metaformId']);
        }
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
        global $post;
        wp_enqueue_style('codemirror-js');
        wp_enqueue_script('codemirror-js');
        
        $metaformsApi = ApiClient::getMetaformsApi();
        $realmId = Settings::getValue("realm-id");
        $metaformId = get_post_meta($post->ID, 'metaform-id', true);
        $json = '';

        if ($metaformId) {
          $json = $metaformsApi->findMetaform($realmId, $metaformId);
        }

        if (empty($json)) {
          wp_die("Api form not found", "Not found", [
            "response" => 404
          ]);

          return;
        }

        echo '<textarea class="codemirror" name="metaform-json" style="width:100%" rows="20"> '. $json->__toString() .' </textarea>';
      }

      /**
       * Post save hook
       */
      public function saveMetaformPost($metaformId) {
        if (!isset($_REQUEST['metaform-json'])) {
          return;
        }

        $this->createOrUpdateMetaform($metaformId);
      }

      /**
       * Registers Metaform custom post type
       */
      private function registerMetaformType() {
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
          'show_in_rest' => true,
          'supports' => ['title', 'editor'],
          'capabilities' => [
            'edit_post' => 'metaform_edit', 
            'read_post' => 'metaform_read', 
            'delete_post' => 'metaform_delete', 
            'edit_posts' => 'metaform_edit', 
            'edit_others_posts' => 'metaform_edit_others', 
            'publish_posts' => 'metaform_publish',
            'read_private_posts' => 'metaform_read_private', 
            'create_posts' => 'metaform_edit', 
          ]
        ]);
      }

      /**
       * Create or update metaform
       * 
       * @param String $postId id of wp post
       */
      private function createOrUpdateMetaform($postId) {
        $metaformId = get_post_meta($postId, 'metaform-id', true);

        if (!$metaformId) {
          $this->createMetaform($postId);
        } else {
          $this->updateMetaform($postId, $metaformId);
        }
      }

      /**
       * Create metaform
       * 
       * @param String $postId id of wp post
       */
      private function createMetaform($postId) {
        $metaformsApi = ApiClient::getMetaformsApi();
        $realmId = Settings::getValue("realm-id");

        $metaformJson = $_POST['metaform-json'];
        $viewModel = json_decode(stripslashes($metaformJson), true);
        $metaform = new \Metatavu\Metaform\Api\Model\Metaform($viewModel);

        try {
          $metaformResponse = $metaformsApi->createMetaform($realmId, $metaform);
          $metaformId = $metaformResponse->getId();
          update_post_meta($postId, 'metaform-id', $metaformId);
        } catch (\Metatavu\Metaform\ApiException $e) {
          $message = $e->getMessage();

          if (empty($message)) {
            $message = json_encode($e->getResponseBody());
          }

          wp_die($message, null, [
            response => $e->getCode()
          ]);
        }
      }

      /**
       * Update metaform
       * 
       * @param String $metaformId id of metaform
       */
      private function updateMetaform($postId, $metaformId) {
        $metaformsApi = ApiClient::getMetaformsApi();
        $realmId = Settings::getValue("realm-id");

        $metaformJson = $_POST['metaform-json'];
        $viewModel = json_decode(stripslashes($metaformJson), true);
        
        $metaform = new \Metatavu\Metaform\Api\Model\Metaform($viewModel);
        
        try {
          $metaformResponse = $metaformsApi->updateMetaform($realmId, $metaformId, $metaform);
          $metaformId = $metaformResponse->getId();
          update_post_meta($postId, 'metaform-id', $metaformId);
        } catch (\Metatavu\Metaform\ApiException $e) {
          $message = $e->getMessage();

          if (empty($message)) {
            $message = json_encode($e->getResponseBody());
          }

          wp_die($message, null, [
            response => $e->getCode()
          ]);
        }
      }

    }
  }

  add_action ('init', function () {
    new Type();
  });

?>