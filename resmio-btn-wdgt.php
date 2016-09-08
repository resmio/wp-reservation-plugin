<?php
/*
Plugin Name: resmio button & widget
Plugin URI: https://www.resmio.com/
Description: Add a resmio button or widget to your website.
Version: 1.2
Date: 20th January 2015
Author: Philipp Sahner
Author URI: http://www.psahner.de/
License: GPL2
Text Domain: resmio_btn_wdgt_i18n
Domain Path: /languages/

Copyright 2015 resmio GmbH / Philipp Sahner  (email : support@resmio.com / philipp@resmio.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
$plugin_header_translate = array( __('Add a resmio button or widget to your website.', 'resmio_btn_wdgt_i18n') );

// Register the plugin class
if(!class_exists('resmio_btn_wdgt_plugin')) {
  class resmio_btn_wdgt_plugin {
    const PLUGINDIRNAME = 'resmio-button-and-widget';
    /**
    * Construct the plugin object
    */
    public function __construct() {
      // Set Plugin Path
      $this->pluginPath = dirname(__FILE__);
      // Set Plugin URL
      $this->pluginUrl = WP_PLUGIN_URL . '/' . self::PLUGINDIRNAME;
      add_action('admin_init', array(&$this, 'resmio_admin_init'));
      add_action('admin_menu', array(&$this, 'resmio_add_menu'));
      add_shortcode('resmio-button', array($this, 'resmio_shortcode'));
      add_shortcode('resmio-widget', array($this, 'resmio_shortcode'));
      // Add shortcode support for widgets
      add_filter('widget_text', 'do_shortcode');
      add_action( 'admin_enqueue_scripts', array( &$this, 'resmio_load_admin_cssjs' ) );
      add_action( 'wp_enqueue_scripts', array( &$this, 'resmio_load_cssjs' ) );
    } // END public function __construct

    /**
    * Activate the plugin
    */
    public static function resmio_activate() {
      // Do nothing
    } // END public static function resmio_activate

    /**
    * Deactivate the plugin
    */
    public static function resmio_deactivate() {
      // Do nothing
    } // END public static function resmio_deactivate

    /**
    * Hook into WP's admin_init action hook
    */
    public function resmio_admin_init() {
      load_plugin_textdomain( 'resmio_btn_wdgt_i18n', false, dirname( plugin_basename( __FILE__ ) ).'/languages/' );
      // Set up the settings for this plugin
      $this->resmio_init_settings();
      // Possibly do additional admin_init tasks
    } // END public static function resmio_activate

    /**
    * Initialize some custom settings
    */
    public function resmio_init_settings() {
      // register the settings for this plugin
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_id');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_extended');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_btn_text');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_btn_bg');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_btn_bg_light');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_btn_bg_dark');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_wdgt_text');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_wdgt_bg');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_wdgt_width');
      register_setting('resmio_btn_wdgt_plugin_group', 'resmio_wdgt_height');
    } // END public function init_custom_settings()

    /**
    * Add a menu
    */
    public function resmio_add_menu() {
      //add_options_page('WP Plugin Template Settings', 'WP Plugin Template', 'manage_options', 'wp_plugin_template', array(&$this, 'resmio_plugin_settings_page'));
      add_options_page(__('resmio button and widget settings', 'resmio_btn_wdgt_i18n'), __('resmio button and widget', 'resmio_btn_wdgt_i18n'), 'manage_options', 'resmio_btn_wdgt_page', array(&$this, 'resmio_plugin_settings_page'));
    } // END public function resmio_add_menu()

    /**
    * Menu callback
    */
    public function resmio_plugin_settings_page() {
      if(!current_user_can('manage_options')) {
        wp_die(__('You do not have permission to access this site.', 'resmio_btn_wdgt_i18n'));
      }

      // Render the settings template
      include(sprintf("%s/templates/settings.php", $this->pluginPath));
    } // END public function resmio_plugin_settings_page()

    /**
    * Shortcode callbacks
    */
    public function resmio_shortcode($atts, $content = null, $tag) {
      // Render the shortcode
      include(sprintf("%s/templates/shortcodes.php", $this->pluginPath));
      return $shortcode;
    } // END public function shortcode_button()

    /**
    * Enqueue css and js files for backend
    */
    public function resmio_load_admin_cssjs() {
      wp_enqueue_style('resmiocss', sprintf("%s/css/resmio_backend.css", $this->pluginUrl));
      wp_enqueue_script('validatejs', sprintf("%s/js/jquery.validate.min.js", $this->pluginUrl),'1.13.0', false );
      wp_enqueue_script('validateaddjs', sprintf("%s/js/additional-methods.min.js", $this->pluginUrl),'1.13.0', false );
      wp_enqueue_script('xcolorjs', sprintf("%s/js/jquery.xcolor.min.js", $this->pluginUrl), array('jquery'),'1.0', false );
      wp_enqueue_style( 'wp-color-picker' );
      wp_enqueue_script( 'wp-color-picker');
    } // END public function resmio_load_admin_cssjs()

    /**
    * Enqueue css and js files for frontend
    */
    public function resmio_load_cssjs() {
      // stuff goes here
    } // END public function resmio_load_admin_cssjs()

  } // END class resmio_btn_wdgt_plugin
} // END if(!class_exists('resmio_btn_wdgt_plugin'))

if(class_exists('resmio_btn_wdgt_plugin')) {
  // Installation and uninstallation hooks
  register_activation_hook(__FILE__, array('resmio_btn_wdgt_plugin', 'resmio_activate'));
  register_deactivation_hook(__FILE__, array('resmio_btn_wdgt_plugin', 'resmio_deactivate'));

  // instantiate the plugin class
  $resmio_btn_wdgt_plugin = new resmio_btn_wdgt_plugin();

  // Add a link to the settings page onto the plugin page
  if(isset($resmio_btn_wdgt_plugin)) {
    // Add the settings link to the plugins page
    function resmio_plugin_settings_link($links) {
      $settings_link = '<a href="options-general.php?page=resmio_btn_wdgt_page">'.__('settings', 'resmio_btn_wdgt_i18n').'</a>';
      array_unshift($links, $settings_link);
      return $links;
    }
    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_$plugin", 'resmio_plugin_settings_link');
  }
}


// Function to alter the TinyMCE interface
function resmio_custom_mce_button() {
  // Check if user have permission
  if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
    return;
  }
  // Check if WYSIWYG is enabled
  /*if ( 'true' == get_user_option( 'rich_editing' ) ) {*/
  add_filter( 'mce_external_plugins', 'custom_tinymce_plugin' );
  add_filter( 'mce_buttons', 'register_mce_button' );
  /*}*/
}
add_action('admin_head', 'resmio_custom_mce_button');
// Function for new button
function custom_tinymce_plugin( $plugin_array ) {
  $plugin_array['resmio_custom_mce_button'] = WP_PLUGIN_URL . '/resmio-button-and-widget/js/shortcode_btns.js';
  return $plugin_array;
}
// Register new button in the editor
function register_mce_button( $buttons ) {
  array_push( $buttons, 'resmio_custom_mce_button' );
  return $buttons;
}

// Function to lighten or darken hex colors
function resmio_adjustColorLightenDarken($color_code,$percentage_adjuster = 0) {
  $percentage_adjuster = round($percentage_adjuster/100,2);
  if(is_array($color_code)) {
    $r = $color_code["r"] - (round($color_code["r"])*$percentage_adjuster);
    $g = $color_code["g"] - (round($color_code["g"])*$percentage_adjuster);
    $b = $color_code["b"] - (round($color_code["b"])*$percentage_adjuster);

    return array("r"=> round(max(0,min(255,$r))),
    "g"=> round(max(0,min(255,$g))),
    "b"=> round(max(0,min(255,$b))));
  }
  else if(preg_match("/#/",$color_code)) {
    $hex = str_replace("#","",$color_code);
    $r = (strlen($hex) == 3)? hexdec(substr($hex,0,1).substr($hex,0,1)):hexdec(substr($hex,0,2));
    $g = (strlen($hex) == 3)? hexdec(substr($hex,1,1).substr($hex,1,1)):hexdec(substr($hex,2,2));
    $b = (strlen($hex) == 3)? hexdec(substr($hex,2,1).substr($hex,2,1)):hexdec(substr($hex,4,2));
    $r = round($r - ($r*$percentage_adjuster));
    $g = round($g - ($g*$percentage_adjuster));
    $b = round($b - ($b*$percentage_adjuster));

    return "#".str_pad(dechex( max(0,min(255,$r)) ),2,"0",STR_PAD_LEFT)
    .str_pad(dechex( max(0,min(255,$g)) ),2,"0",STR_PAD_LEFT)
    .str_pad(dechex( max(0,min(255,$b)) ),2,"0",STR_PAD_LEFT);

  }
}
?>
