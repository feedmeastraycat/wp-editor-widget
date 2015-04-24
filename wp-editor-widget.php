<?php
/*
Plugin Name: WP Editor Widget
Plugin URI: https://github.com/feedmeastraycat/wp-editor-widget
Description: WP Editor Widget adds a WYSIWYG widget using the wp_editor().
Author: David M&aring;rtensson, Odd Alice
Version: 0.5.5
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
	const VERSION = "0.5.5";

	/**
	 * Action: init
	 */
	public function __construct() {

		add_action( 'widgets_init', array( $this, 'widgets_init' ) );
		add_action( 'load-widgets.php', array( $this, 'load_admin_assets' ) );
		add_action( 'load-customize.php', array( $this, 'load_admin_assets' ) );
		add_action( 'widgets_admin_page', array( $this, 'output_wp_editor_widget_html' ), 100 );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'output_wp_editor_widget_html' ), 1 );
		add_action( 'customize_controls_print_footer_scripts', array( $this, 'customize_controls_print_footer_scripts' ), 2 );
		add_action( 'plugins_loaded', array( $this, 'plugins_loaded' ) );
		
		add_filter( 'wp_editor_widget_content', 'wptexturize' );
		add_filter( 'wp_editor_widget_content', 'convert_smilies' );
		add_filter( 'wp_editor_widget_content', 'convert_chars' );
		add_filter( 'wp_editor_widget_content', 'wpautop' );
		add_filter( 'wp_editor_widget_content', 'shortcode_unautop' );
		add_filter( 'wp_editor_widget_content', 'do_shortcode', 11 );

	} // END __construct()

	/**
	 * Action: load-widgets.php
	 * Action: load-customize.php
	 */
	public function load_admin_assets() {

		wp_register_script( 'wp-editor-widget-js', plugins_url( 'assets/js/admin.js', __FILE__ ), array( 'jquery' ), self::VERSION );
		wp_enqueue_script( 'wp-editor-widget-js' );

		wp_register_style( 'wp-editor-widget-css', plugins_url( 'assets/css/admin.css', __FILE__ ), array(), self::VERSION );
		wp_enqueue_style( 'wp-editor-widget-css' );

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
	 * Action: customize_controls_print_footer_scripts
	 */
	public function output_wp_editor_widget_html() {
		
		?>
		<div id="wp-editor-widget-container" style="display: none;">
			<a class="close" href="javascript:WPEditorWidget.hideEditor();" title="<?php esc_attr_e( 'Close', 'wp-editor-widget' ); ?>"><span class="icon"></span></a>
			<div class="editor">
				<?php
				$settings = array(
					'textarea_rows' => 20,
				);
				wp_editor( '', 'wpeditorwidget', $settings );
				?>
				<p>
					<a href="javascript:WPEditorWidget.updateWidgetAndCloseEditor(true);" class="button button-primary"><?php _e( 'Save and close', 'wp-editor-widget' ); ?></a>
				</p>
			</div>
		</div>
		<div id="wp-editor-widget-backdrop" style="display: none;"></div>
		<?php
		
	} // END output_wp_editor_widget_html
	
	/**
	 * Action: customize_controls_print_footer_scripts
	 */
	public function customize_controls_print_footer_scripts() {
	
		// Because of https://core.trac.wordpress.org/ticket/27853
		// Which was fixed in 3.9.1 so we only need this on earlier versions
		$wp_version = get_bloginfo( 'version' );
		if ( version_compare( $wp_version, '3.9.1', '<' ) && class_exists( '_WP_Editors' ) ) {
			_WP_Editors::enqueue_scripts();
		}
		
	} // END customize_controls_print_footer_scripts

	/**
	 * Action: widgets_init
	 */
	public function widgets_init() {

		register_widget( 'WP_Editor_Widget' );

	} // END widgets_init()

} // END class WPEditorWidget

global $wp_editor_widget;
$wp_editor_widget = new WPEditorWidget;
