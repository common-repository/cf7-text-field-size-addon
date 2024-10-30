<?php
/**
 * Plugin Name: CF7 text field size Addon
 * Plugin URI: #
 * Description: "Contact Form 7 offers a feature that allows you to create custom text fields with specific length limits. You can set both a minimum and maximum character count for these fields. This helps ensure that users provide information within a desired range, making it easier to manage and analyze the collected data. By using this feature, you have more control over the length of the input in your contact forms, allowing you to gather concise and relevant information from your visitors."
 * Version: 1.0.0
 * Author: MageINIC
 * Author URI: https://profiles.wordpress.org/wpteamindianic/#content-plugins
 * Text Domain: cf7-text-field-size
 * Domain Path: languages/
 * Requires at least: 5.8
 * Requires PHP: 7.2
 *
 * @package cf7_ts
 */

if (!defined('ABSPATH')) {
		exit;
}

define('CF7_TS_URL', plugin_dir_url(__FILE__));
define('CF7_TS_PUBLIC_URL', CF7_TS_URL . 'public/');

register_activation_hook( __FILE__, 'cf7_ts_activation' );

/**
 * Activation hook
 *
 * @since    		1.0.0
 * @param      	string    $plugin_name       	Contact form 7 text field size
 * @param      	string    $version    				1.0.0.
 */

function cf7_ts_activation() {
	global $wp_version;

	$php_version = '5.6';
	$wordpress_version  = '5.0';

	if ( version_compare( PHP_VERSION, $php_version, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die(
			'<p>' .
			sprintf(
				__( 'Required version for PHP is %1$s. Please update your PHP version to activate this plugin.', 'cf7_ts' ),
				$php_version
			)
			. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'cf7_ts' ) . '</a>'
		);
	}

	if ( version_compare( $wp_version, $wordpress_version, '<' ) ) {
		deactivate_plugins( basename( __FILE__ ) );
		wp_die(
			'<p>' .
			sprintf(
				__( 'Required version for WordPress is %1$s. Please update your WordPress version to activate this plugin.', 'cf7_ts_plugin' ),
				$wordpress_version
			)
			. '</p> <a href="' . admin_url( 'plugins.php' ) . '">' . __( 'go back', 'cf7_ts' ) . '</a>'
		);
	}
}

/**
 * Deactivation hook
 *
 * @since    		1.0.0
 * @param      	string    $plugin_name       	Contact form 7 text field size
 * @param      	string    $version    				1.0.0.
 */
register_deactivation_hook( __FILE__, 'cf7_ts_deactivation' );
function cf7_ts_deactivation() {
  // Deactivation rules here
}

/**
 * Init hook
 *
 * @since    		1.0.0
 * @param      	string    $plugin_name       	Contact form 7 text field size
 * @param      	string    $version    				1.0.0.
 */
add_action( 'init', 'cf7_ts_init' );
function cf7_ts_init() {
	include_once plugin_dir_path( __FILE__ ).'admin/admin-init.php';
	include_once plugin_dir_path( __FILE__ ).'public/cf7-ts-form-tag.php';
}
