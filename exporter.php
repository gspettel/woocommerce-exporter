<?php
/*
Plugin Name: WooCommerce - Exporter
Plugin URI: http://www.visser.com.au/woocommerce/plugins/exporter/
Description: Export store details out of WooCommerce into a CSV-formatted file.
Version: 1.0.5
Author: Visser Labs
Author URI: http://www.visser.com.au/about/
License: GPL2
*/

load_plugin_textdomain( 'woo_ce', null, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

include_once( 'includes/functions.php' );

include_once( 'includes/common.php' );

$woo_ce = array(
	'filename' => basename( __FILE__ ),
	'dirname' => basename( dirname( __FILE__ ) ),
	'abspath' => dirname( __FILE__ ),
	'relpath' => basename( dirname( __FILE__ ) ) . '/' . basename( __FILE__ )
);

$woo_ce['prefix'] = 'woo_ce';
$woo_ce['name'] = __( 'WooCommerce Exporter', 'woo_dm' );
$woo_ce['menu'] = __( 'Store Export', 'woo_de' );

if( is_admin() ) {

	/* Start of: WordPress Administration */

	function woo_ce_add_settings_link( $links, $file ) {

		static $this_plugin;
		if( !$this_plugin ) $this_plugin = plugin_basename( __FILE__ );
		if( $file == $this_plugin ) {
			$settings_link = '<a href="' . add_query_arg( array( 'post_type' => 'product', 'page' => 'woo_ce' ), 'edit.php' ) . '">' . __( 'Export', 'woo_ce' ) . '</a>';
			array_unshift( $links, $settings_link );
		}
		return $links;

	}
	add_filter( 'plugin_action_links', 'woo_ce_add_settings_link', 10, 2 );

	function woo_ce_admin_init() {

		global $woo_ce, $export;

		include_once( 'includes/formatting.php' );

		$action = woo_get_action();
		switch( $action ) {

			case 'export':
				$export = new stdClass();
				$export->delimiter = $_POST['delimiter'];
				$export->category_separator = $_POST['category_separator'];
				$dataset = array();
				if( $_POST['dataset'] == 'products' ) {
					$dataset[] = 'products';
					$export->fields = $_POST['product_fields'];
				}
				if( $_POST['dataset'] == 'sales' ) {
					$dataset[] = 'orders';
					$export->fields = $_POST['sale_fields'];
				}
				if( $_POST['dataset'] == 'categories' )
					$dataset[] = 'categories';
				if( $_POST['dataset'] == 'tags' )
					$dataset[] = 'tags';
				if( $_POST['dataset'] == 'customers' )
					$dataset[] = 'customers';
				if( $dataset ) {

					if( isset( $_POST['timeout'] ) )
						$timeout = $_POST['timeout'];
					else
						$timeout = 600;

					if( !ini_get( 'safe_mode' ) )
						set_time_limit( $timeout );

					if( isset( $woo_ce['debug'] ) && $woo_ce['debug'] ) {
						woo_ce_export_dataset( $dataset );
					} else {
						woo_ce_generate_csv_header( $_POST['dataset'] );
						woo_ce_export_dataset( $dataset );
						exit();
					}
				}
				break;

		}
		wp_enqueue_style( 'woo_ce_styles', plugins_url( '/templates/admin/woo-admin_ce-export.css', __FILE__ ) );

	}
	add_action( 'admin_init', 'woo_ce_admin_init' );

	function woo_ce_html_page() {

		global $wpdb, $woo_ce;

		woo_ce_template_header();
		$action = woo_get_action();
		switch( $action ) {

			case 'export':
				$message = __( 'Chosen WooCommerce details have been exported from your store.', 'woo_ce' );
				$output = '<div class="updated settings-error"><p><strong>' . $message . '</strong></p></div>';
				echo $output;

				woo_ce_manage_form();
				break;

			default:
				woo_ce_manage_form();
				break;

		}
		woo_ce_template_footer();

	}

	function woo_ce_manage_form() {

		global $woo_ce;

		$tab = false;
		if( isset( $_GET['tab'] ) )
			$tab = $_GET['tab'];

		$url = add_query_arg( 'page', 'woo_ce' );
		if( function_exists( 'woo_pd_init' ) ) {
			$woo_pd_url = add_query_arg( 'page', 'woo_pd' );
			$woo_pd_target = false;
		} else {
			$woo_pd_url = 'http://www.visser.com.au/woocommerce/plugins/product-importer-deluxe/';
			$woo_pd_target = ' target="_blank"';
		}

		include_once( 'templates/admin/woo-admin_ce-export.php' );

	}

	/* End of: WordPress Administration */

}
?>