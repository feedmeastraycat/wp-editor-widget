<?php
/*
Plugin Name: WP Editor Widget
Plugin URI: http://oddalice.com/
Description: WP Editor Widget adds a WYSIWYG widget using the wp_editor().
Author: David M&aring;rtensson, Odd Alice
Version: 0.4.1
Author URI: http://www.feedmeastraycat.net/
Text Domain: wp-editor-widget
Domain Path: /langs
*/

//avoid direct calls to this file
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

include 'classes/class-widget.php';

/**
 * WP Editor Widget singelton
 */
class WPEditorWidget {

	/**
	 * @var string
	 */
	const VERSION = "0.4.1";

	/**
	 * Action: init
	 */
	public function __construct() {

		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action( 'load-widgets.php', array( $this, 'load_admin_assets' ) );
		add_action( 'widgets_admin_page', array( $this, 'widgets_admin_page' ), 100 );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );

	} // END __construct()

	/**
	 * Action: load-widgets.php
	 */
	public function load_admin_assets() {

		wp_register_script( 'wp-editor-widget-js', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), self::VERSION );
		wp_enqueue_script( 'wp-editor-widget-js' );

		wp_register_style( 'wp-editor-widget-css', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), self::VERSION );
		wp_enqueue_style( 'wp-editor-widget-css' );

		add_filter( 'wp_editor_widget_content', 'wptexturize' );
		add_filter( 'wp_editor_widget_content', 'convert_smilies' );
		add_filter( 'wp_editor_widget_content', 'convert_chars' );
		add_filter( 'wp_editor_widget_content', 'wpautop' );
		add_filter( 'wp_editor_widget_content', 'shortcode_unautop' );
		add_filter( 'wp_editor_widget_content', 'do_shortcode', 11 );

	} // END load_admin_assets()

	/**
	 * Action: plugins_loaded
	 */
	public function plugins_loaded() {

		// Load translations
		load_plugin_textdomain( 'wp-editor-widget', false, dirname( plugin_basename( __FILE__ ) ) . '/langs/' );

	} // END plugins_loaded()

	/**
	 * Action: widgets_admin_page
	 */
	public function widgets_admin_page() {
		?>
		<div id="wp-editor-widget-container" style="display: none;">
			<a class="close" href="javascript:WPEditorWidget.hideEditor();" title="<?php esc_attr_e( 'Close', 'wp-editor-widget' ); ?>"><span class="icon"></span></a>
			<div class="editor">
				<?php
				$settings = array(
					'textarea_rows' => 15,
				);
				wp_editor( '', 'wp-editor-widget', $settings );
				?>
				<p>
					<a href="javascript:WPEditorWidget.updateWidgetAndCloseEditor(true);" class="button button-primary"><?php _e( 'Save and close', 'wp-editor-widget' ); ?></a>
				</p>
			</div>
		</div>
		<div id="wp-editor-widget-backdrop" style="display: none;"></div>
		<?php

	} // END widgets_admin_page()

	/**
	 * Action: widgets_init
	 */
	public function widgets_init() {

		if ( true == apply_filters( 'wp_editor_widget_remove_core_widget', false ) ) {
			unregister_widget( 'WP_Widget_Text' );
		}

		register_widget( 'WP_Editor_Widget' );

	} // END widgets_init()

} // END class WPEditorWidget

global $wp_editor_widget;
$wp_editor_widget = new WPEditorWidget;
