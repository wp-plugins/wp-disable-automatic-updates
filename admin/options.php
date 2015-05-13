<?php

/**
 * Load styles and scripts
 */

add_action('admin_enqueue_scripts', 'dd_wpdau_load_styles_scripts');
function dd_wpdau_load_styles_scripts() {
  wp_enqueue_style('admin_css', plugin_dir_url( __FILE__ ) . '/css/admin-style.css' );

  if ( is_admin() ){ // for Admin Dashboard Only
     // Embed the Script on our Plugin's Option Page Only
     if ( isset($_GET['page']) && $_GET['page'] == 'dd_wpdau' ) {
        wp_enqueue_script('jquery');
        wp_enqueue_script( 'jquery-form' );
     }
  }
}

/**
 * Admin menu
 */

add_action('admin_menu', 'dd_wpdau_admin_menu');

function dd_wpdau_admin_menu() {
  add_options_page( 'WP Updates', 'Automatic Updates', 'manage_options', 'dd_wpdau', 'dd_wpdau_options', 'dashicons-admin-network' );
}

add_action('admin_init', 'dd_wpdau_init');
function dd_wpdau_init(){

  // Register settings
  register_setting( 'dd_wpdau_plugin_options', 'dd_wpdau_plugin_options', false );

  // Add Section
  add_settings_section(
    'dd_wpdau_plugin_main_settings1',
    'Disable ALL Automatic Updates',
    'dd_wpdau_plugin_section_1',
    'dd_wpdau_section'
  );
  add_settings_section(
    'dd_wpdau_plugin_main_settings2',
    'Individual Disable',
    'dd_wpdau_plugin_section_2',
    'dd_wpdau_section'
  );
  add_settings_section(
    'dd_wpdau_plugin_main_settings3',
    'Status',
    'dd_wpdau_plugin_section_3',
    'dd_wpdau_section'
  );

  /**
   * Adding fields
   */

  // Checkbox fields
  add_settings_field('dd_wpdau_checkbox_disable_all',
    'Disable ALL automatic updates',
    'dd_wpdau_checkbox_disable_all',
    'dd_wpdau_section',
    'dd_wpdau_plugin_main_settings1'
  );
  add_settings_field('dd_wpdau_checkbox_disable_core_updates',
    'Disable Wordpress Core Updates',
    'dd_wpdau_checkbox_disable_core_updates',
    'dd_wpdau_section',
    'dd_wpdau_plugin_main_settings2'
  );
  add_settings_field('dd_wpdau_checkbox_disable_plugin_updates',
    'Disable Wordpress Plugin Updates',
    'dd_wpdau_checkbox_disable_plugin_updates',
    'dd_wpdau_section',
    'dd_wpdau_plugin_main_settings2'
  );
  add_settings_field('dd_wpdau_checkbox_disable_theme_updates',
    'Disable Wordpress Theme Updates',
    'dd_wpdau_checkbox_disable_theme_updates',
    'dd_wpdau_section',
    'dd_wpdau_plugin_main_settings2'
  );
}


/**
 * Section Description
 */

function dd_wpdau_plugin_section_1() {
  echo '<p>Disable all types of automatic updates <strong>with 1 click.</strong> Easy!</p>';
}
function dd_wpdau_plugin_section_2() {
  echo '<p>You want to disable only some types of automatic updates? For sure!</p>';
}
function dd_wpdau_plugin_section_3() {

  $dd_wpdau_options = get_option('dd_wpdau_plugin_options');

  $status_all_updates = '';
  $status_core_updates = '';
  $status_plugin_updates = '';
  $status_theme_updates = '';
  $status_enabled = '';

  if ( has_filter( 'automatic_updater_disabled', '__return_true') ) {
    $status_all_updates = '<span class="dd_success">Great! All Automatic Updates are disabled. :-)</span>';
  }

  if ( has_filter('auto_update_core', '__return_false') && !has_filter('automatic_updater_disabled', '__return_true') ) {
    $status_core_updates = '<span class="dd_success">Automatic Core Updates are disabled.</span>';
  } else if ( has_filter( 'automatic_updater_disabled', '__return_true') ) {
    $status_core_updates = '';
  } else {
    $status_core_updates = '<span class="dd_error">Automatic Core Updates are enabled.</span>';
  }

  if ( has_filter('auto_update_plugin', '__return_false') && !has_filter('automatic_updater_disabled', '__return_true') ) {
    $status_plugin_updates = '<span class="dd_success">Automatic Plugin Updates are disabled.</span>';
  } else if ( has_filter( 'automatic_updater_disabled', '__return_true') ) {
    $status_plugin_updates = '';
  } else {
    $status_plugin_updates = '<span class="dd_error">Automatic Plugin Updates are enabled.</span>';
  }

  if ( has_filter('auto_update_theme', '__return_false') && !has_filter('automatic_updater_disabled', '__return_true') ) {
    $status_theme_updates = '<span class="dd_success">Automatic Theme Updates are disabled.</span>';
  } else if ( has_filter( 'automatic_updater_disabled', '__return_true') ) {
    $status_theme_updates = '';
  } else {
    $status_theme_updates = '<span class="dd_error">Automatic Theme Updates are enabled.</span>';
  }

  // echo '<a id="dd_wpdau_check_status" href="javascript:void(0)">Reload</a>';
  echo '<div id="dd_wpdau_status">';
  echo '<pre>';
  echo $status_all_updates;
  echo $status_core_updates;
  echo $status_plugin_updates;
  echo $status_theme_updates;
  echo '</pre>';
  echo '</div>';
}

/**
 * Building fields
 */

function dd_wpdau_checkbox_disable_all() {
  $dd_wpdau_options = get_option('dd_wpdau_plugin_options');
  ?>
  <input id='dd_wpdau_checkbox_disable_all' name='dd_wpdau_plugin_options[disable_all]' value="1" type='checkbox' <?php checked( 1, isset($dd_wpdau_options['disable_all']) ); ?> />
  <label for='dd_wpdau_checkbox_disable_all'>(Disabled Wordpress <strong>Core Updates, Theme Updates and Plugin Updates</strong>)</label>
  <?php
}
function dd_wpdau_checkbox_disable_core_updates() {
  $dd_wpdau_options = get_option('dd_wpdau_plugin_options');
  ?>
  <input id='dd_wpdau_checkbox_disable_core_updates' name='dd_wpdau_plugin_options[disable_core_updates]' value="1" type='checkbox' <?php checked( 1, isset($dd_wpdau_options['disable_core_updates']) ); ?> />
  <label for='dd_wpdau_checkbox_disable_core_updates'>(Disabled only Wordpress <strong>Core</strong> Updates)</label>
  <?php
}
function dd_wpdau_checkbox_disable_plugin_updates() {
  $dd_wpdau_options = get_option('dd_wpdau_plugin_options');
  ?>
  <input id='dd_wpdau_checkbox_disable_plugin_updates' name='dd_wpdau_plugin_options[disable_plugin_updates]' value="1" type='checkbox' <?php checked( 1, isset($dd_wpdau_options['disable_plugin_updates']) ); ?> />
  <label for='dd_wpdau_checkbox_disable_plugin_updates'>(Disabled only Wordpress <strong>Plugin</strong> Updates)</label>
  <?php
}
function dd_wpdau_checkbox_disable_theme_updates() {
  $dd_wpdau_options = get_option('dd_wpdau_plugin_options');
  ?>
  <input id='dd_wpdau_checkbox_disable_theme_updates' name='dd_wpdau_plugin_options[disable_theme_updates]' value="1" type='checkbox' <?php checked( 1, isset($dd_wpdau_options['disable_theme_updates']) ); ?> />
  <label for='dd_wpdau_checkbox_disable_theme_updates'>(Disabled only Wordpress <strong>Theme</strong> Updates)</label>
  <?php
}


/**
 * Option Content
 */
function dd_wpdau_options() {
?>

<div id="dd_admin_panel" class="wrap">
<h2><span class="dashicons dashicons-admin-network"></span>WP Disable Automatic Updates</h2>

<form method="post" action="options.php" id="dd_admin_panel_form">
  <?php settings_fields( 'dd_wpdau_plugin_options' ); ?>
  <?php do_settings_sections( 'dd_wpdau_section' ); ?>
<?php submit_button(); ?>
</form>
<div id="dd_save_result"></div>
</div>
<div id="dd_admin_panel_footer">
  Thank you for using this plugin! Get more Wordpress Themes and Plugins on <a href="http://www.danielederosa.de">my website.</a>
</div>

<!-- Ajax Submit -->
<script type="text/javascript">
jQuery(document).ready(function() {
   jQuery('#dd_admin_panel_form').submit(function() {
      jQuery(this).ajaxSubmit({
         success: function(){
            jQuery("#dd_wpdau_status").load('#dd_wpdau_status pre');
            jQuery('#dd_save_result').html("<div id='dd_save_message' class='successModal'></div>");
            jQuery('#dd_save_message').append("<p><?php echo htmlentities(__('Settings Saved Successfully!','wp'),ENT_QUOTES); ?></p>").show();

         },
         timeout: 5000
      });
      setTimeout("jQuery('#dd_save_message').hide('slow');", 5000);
      return false;
   });
});
jQuery('#dd_save_result').ajaxStart(function() {
  jQuery('#dd_save_result').append('<span>Loading...</span>');
})
jQuery('#dd_save_result').ajaxStop(function() {
  jQuery('#dd_save_result span').css('display', 'none');
})
</script>


<?php
}
