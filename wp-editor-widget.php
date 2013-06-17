<?php
/*
Plugin Name: WP Editor Widget
Plugin URI: http://oddalice.com/
Description: WP Editor Widget adds a WYSIWYG widget using the wp_editor().
Author: David M&aring;rtensson, Odd Alice
Version: 0.1.0
Author URI: http://www.feedmeastraycat.net/
*/



// Setup actions
add_action('admin_init', array('WPEditorWidget', 'admin_init'));
add_action('widgets_admin_page', array('WPEditorWidget', 'widgets_admin_page'), 100);
add_action('widgets_init', array('WPEditorWidget', 'widgets_init'));



/** 
 * WP Editor Widget singelton
 */
class WPEditorWidget
{

	const TEXTDOMAIN = "wpeditorwidget";
	
	/**
	 * Action: admin_init
	 */
	public static function admin_init()
	{
		wp_register_script('wp-editor-widget-js', plugins_url('assets/js/admin.js', __FILE__));
		wp_enqueue_script('wp-editor-widget-js');
		
		wp_register_style('wp-editor-widget-css', plugins_url('assets/css/admin.css', __FILE__));
		wp_enqueue_style('wp-editor-widget-css');
	}
	
	/**
	 * Action: widgets_admin_page
	 */
	public static function widgets_admin_page() {
		?>
		<div id="wp-editor-widget-container" style="display: none;">
			<a class="close" href="javascript:WPEditorWidget.hideEditor();" title="<?php esc_attr_e('Close', self::TEXTDOMAIN) ?>"><span class="icon"></span></a>
			<div class="editor">
				<?php
				$settings = array(
					'textarea_rows' => 15
				);
				wp_editor('', 'wp-editor-widget', $settings);
				?>
				<p>
					<a href="javascript:WPEditorWidget.updateWidgetAndCloseEditor();" class="button"><?php _e('Update and close', self::TEXTDOMAIN) ?></a>
				</p>
			</div>
		</div>
		<div id="wp-editor-widget-backdrop" style="display: none;"></div>
		<?php
	}
	
	/**
	 * Action: widgets_init
	 */
	public static function widgets_init()
	{
		register_widget('WP_Editor_Widget');
	}
	
}



/**
 * Adds WP_Editor_Widget widget.
 */
class WP_Editor_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'wp_editor_widget',
			__('WP Editor Widget', WPEditorWidget::TEXTDOMAIN),
			array('description' => __('Adds an WP Editor Widget for WYSIWYG content.', WPEditorWidget::TEXTDOMAIN))
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance) {
		extract( $args );
		
		$title = apply_filters('wp_editor_widget_title', $instance['title']);
		$output_title = apply_filters('wp_editor_widget_output_title', $instance['output_title']);
		$content = apply_filters('wp_editor_widget_content', $instance['content']);
		
		echo $before_widget;
		
		if ($output_title == "1" && !empty($title)) {
			echo $before_title.$title.$after_title;
		}
		
		echo $content;
		
		echo $after_widget;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if (isset( $instance[ 'title' ])) {
			$title = $instance['title'];
		}
		else {
			$title = __('New title', WPEditorWidget::TEXTDOMAIN);
		}
		
		if (isset( $instance['content'])) {
			$content = $instance['content'];
		}
		else {
			$content = "";
		}
		
		$output_title = (isset($instance['output_title']) && $instance['output_title'] == "1" ? true:false);
		?>
		<input type="hidden" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" value="<?php echo esc_attr($content); ?>">
		<p>
			<label for="<?php echo $this->get_field_name('title'); ?>"><?php _e('Title', WPEditorWidget::TEXTDOMAIN); ?>:</label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id('content'); ?>');"><?php _e('Edit content', WPEditorWidget::TEXTDOMAIN) ?></a>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('output_title'); ?>">
				<input type="checkbox" id="<?php echo $this->get_field_id('output_title'); ?>" name="<?php echo $this->get_field_name('output_title'); ?>" value="1" <?php checked($output_title, true) ?>> <?php _e('Output title', WPEditorWidget::TEXTDOMAIN); ?>
			</label> 
		</p>
		<?php 
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		
		$instance['title'] = (!empty($new_instance['title']) ? strip_tags( $new_instance['title']):'');
		$instance['content'] = (!empty($new_instance['content']) ? $new_instance['content']:'');
		$instance['output_title'] = (isset($new_instance['output_title']) && $new_instance['output_title'] == "1" ? 1:0);

		return $instance;
	}

} 