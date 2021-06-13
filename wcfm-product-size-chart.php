<?php
/**
 * Plugin Name: WCFM Product Size Chart
 * Plugin URI: 
 * Description: Manage product size chart for wcfm
 * Version: 1.0.1
 * Author: Repon
 * Author URI: https://repon.me/
 * Requires at least: 5.2
 * Tested up to: 5.5
 * Requires PHP: 7.0
 * Text Domain: wcfm-product-size-chart
 * Domain Path: /languages/
  *
 * @package wcfm-product-size-chart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Define constants.
define( 'WCFM_PRODUCT_SIZE_CHART_VERSION', '1.0.1' );
define( 'WCFM_PRODUCT_SIZE_CHART_PLUGIN_DIR', untrailingslashit( plugin_dir_path( __FILE__ ) ) );
define( 'WCFM_PRODUCT_SIZE_CHART_PLUGIN_URL', untrailingslashit( plugins_url( basename( plugin_dir_path( __FILE__ ) ), basename( __FILE__ ) ) ) );
define( 'WCFM_PRODUCT_SIZE_CHART_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );

require_once dirname( __FILE__ ) . '/includes/class-wp-job-manager-dependency-checker.php';
if ( ! WP_Job_Manager_Dependency_Checker::check_dependencies() ) {
	return;
}

require_once dirname( __FILE__ ) . '/includes/class-wp-job-manager.php';

/**
 * Main instance of WP Job Manager.
 *
 * Returns the main instance of WP Job Manager to prevent the need to use globals.
 *
 * @since  1.26
 * @return WP_Job_Manager
 */
function WPJM() { // phpcs:ignore WordPress.NamingConventions.ValidFunctionName
	return WP_Job_Manager::instance();
}

$GLOBALS['job_manager'] = WPJM();

// Activation - works with symlinks.
register_activation_hook( basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ ), array( WPJM(), 'activate' ) );

// Cleanup on deactivation.
register_deactivation_hook( __FILE__, array( WPJM(), 'unschedule_cron_jobs' ) );
register_deactivation_hook( __FILE__, array( WPJM(), 'usage_tracking_cleanup' ) );