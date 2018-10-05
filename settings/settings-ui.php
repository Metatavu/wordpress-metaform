<?php
  namespace Metatavu\Metaform\Settings;
  
  if (!defined('ABSPATH')) { 
    exit;
  }
  
  if (!class_exists( '\Metatavu\Metaform\Settings\SettingsUI' ) ) {

    /**
     * UI for settings
     */
    class SettingsUI {

      /**
       * Constructor
       */
      public function __construct() {
        add_action('admin_init', array($this, 'adminInit'));
        add_action('admin_menu', array($this, 'adminMenu'));
      }

      /**
       * Admin menu action. Adds admin menu page
       */
      public function adminMenu() {
        add_options_page (__( "Metaform Settings", 'metaform' ), __( "Metaform Settings", 'metaform' ), 'manage_options', 'metaform', [$this, 'settingsPage']);
      }

      /**
       * Admin init action. Registers settings
       */
      public function adminInit() {
        register_setting('metaform', 'metaform');
        add_settings_section('api', __( "API", 'metaform' ), null, 'metaform');
        $this->addOption('api', 'url', 'api-url', __( "API URL", 'metaform'));
        $this->addOption('api', 'text', 'realm-id', __( "Realm ID", 'metaform'));

        add_settings_section('management', __( "Management", 'metaform' ), null, 'metaform');
        $this->addOption('management', 'url', 'management-url', __( "Management URL", 'metaform'));
      }

      /**
       * Adds new option
       * 
       * @param string $group option group
       * @param string $type option type
       * @param string $name option name
       * @param string $title option title
       */
      private function addOption($group, $type, $name, $title) {
        add_settings_field($name, $title, array($this, 'createFieldUI'), 'metaform', $group, [
          'name' => $name, 
          'type' => $type
        ]);
      }

      /**
       * Prints field UI
       * 
       * @param array $opts options
       */
      public function createFieldUI($opts) {
        $name = $opts['name'];
        $type = $opts['type'];
        $value = Settings::getValue($name);
        echo "<input id='$name' name='" . 'metaform' . "[$name]' size='42' type='$type' value='$value' />";
      }

      /**
       * Prints settings page
       */
      public function settingsPage() {
        if (!current_user_can('manage_options')) {
          wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
        }

        echo '<div class="wrap">';
        echo "<h2>" . __( "Metaform Management", 'metaform') . "</h2>";
        echo '<form action="options.php" method="POST">';
        settings_fields('metaform');
        do_settings_sections('metaform');
        submit_button();
        echo "</form>";
        echo "</div>";
      }
    }

  }
  
  if (is_admin()) {
    $settingsUI = new SettingsUI();
  }

?>