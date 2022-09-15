<?php
/**
 * Plugin Name:       WooCommerce Log File Search
 * Plugin URI:        https://github.com/billrobbins/log-file-search-woocommerce
 * Description:       Provides a simple interface for searching WooCommerce log files.
 * Version:           0.1
 * Requires at least: 5.2
 * Requires PHP:      7.4
 * Author:            Bill Robbins
 * Author URI:        https://justabill.blog
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

/**
 * Loads an REST API endpoint to search and load files.
 */
require_once plugin_dir_path( __FILE__ ) . '/includes/class-woocommerce-log-search-rest-controller.php';

/**
 * Registers and enqueues JS and CSS
 */
function wc_log_search_load_scripts() {
	if ( isset( $_GET['page'] ) && ! empty( $_GET['page'] ) && 'wc-status' !== $_GET['page'] && 'logs' !== $_GET['tab'] ) {
		return;
	}

	$script_path       = '/build/index.js';
	$script_asset_path = dirname( __FILE__ ) . '/build/index.asset.php';
	$script_asset      = file_exists( $script_asset_path )
		? require $script_asset_path
		: array(
			'dependencies' => array(),
			'version'      => filemtime( $script_path ),
		);
	$script_url        = plugins_url( $script_path, __FILE__ );

	wp_register_script(
		'log-search',
		$script_url,
		$script_asset['dependencies'],
		$script_asset['version'],
		true
	);

	wp_register_style(
		'log-search',
		plugins_url( '/build/index.css', __FILE__ ),
		array(),
		filemtime( dirname( __FILE__ ) . '/build/index.css' )
	);

	wp_enqueue_script( 'log-search' );
	wp_enqueue_style( 'log-search' );
}

add_action( 'admin_enqueue_scripts', 'wc_log_search_load_scripts' );

/**
 * Inserts a div that React can use to add the search component.  The WooCommerce log panel does not have any actions that we can hook into.
 *
 * @return void
 */
function wc_log_search_add_hook_to_mount_react() {
	echo '
	<script>
		const logSearch = document.createElement("div");
		logSearch.setAttribute("id", "log-search");
		const logViewer = document.querySelector("#log-viewer");
		logViewer.before(logSearch);
	</script>
	';
};

add_action( 'admin_footer', 'wc_log_search_add_hook_to_mount_react', 1 );
