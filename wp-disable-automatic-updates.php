<?php
/**
 * Plugin Name: WP Disable Automatic Updates
 * Plugin URI: www.danielederosa.de
 * Description: This plugin allows you to disable all types of automatic Wordpress Updates very simply with some special features.
 * Version: 1.0
 * Author: Daniele De Rosa
 * Author URI: www.danielederosa.de
 **/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
@include 'admin/options.php';

$dd_wpdau_options = get_option('dd_wpdau_plugin_options');

/**
 * Disable Automatic Updates
 */

if ( isset($dd_wpdau_options['disable_all']) && !has_filter('automatic_updater_disabled', '__return_true') ) {
  // Disable All Updates
  add_filter( 'automatic_updater_disabled', '__return_true');
}
if ( isset($dd_wpdau_options['disable_core_updates']) && !has_filter('auto_update_core', '__return_false') ) {
  // Disable only Core Updates
  add_filter( 'auto_update_core', '__return_false' );
}
if ( isset($dd_wpdau_options['disable_plugin_updates']) && !has_filter('auto_update_plugin', '__return_false') ) {
  // Disable only Plugin Updates
  add_filter( 'auto_update_plugin', '__return_false' );
}
if ( isset($dd_wpdau_options['disable_theme_updates']) && !has_filter('auto_update_theme', '__return_false') ) {
  // Disable only Theme Updates
  add_filter( 'auto_update_theme', '__return_false' );
}
