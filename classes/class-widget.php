<?php
//avoid direct calls to this file
if ( !defined( 'ABSPATH' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

/**
 * Adds WP_Editor_Widget widget.
 */
class WP_Editor_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {

		$widget_ops = apply_filters(
			'wp_editor_widget_ops',
			array(
				'classname' 	=> 'WP_Editor_Widget',
				'description' 	=> __( 'Arbitrary text, HTML or rich text through the standard WordPress visual editor.', 'wp-editor-widget' ),
			)
		);

		parent::__construct(
			'WP_Editor_Widget',
			__( 'Rich text', 'wp-editor-widget' ),
			$widget_ops
		);

	} // END __construct()

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {

		extract( $args );

		$title			= apply_filters( 'wp_editor_widget_title', $instance['title'] );
		$output_title	= apply_filters( 'wp_editor_widget_output_title', $instance['output_title'] );
		$content		= apply_filters( 'wp_editor_widget_content', $instance['content'] );

		echo $before_widget;

		if ( $output_title == "1" && !empty($title) ) {
			echo $before_title . $title . $after_title;
		}

		echo $content;

		echo $after_widget;

	} // END widget()

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		if ( isset($instance['title']) ) {
			$title = $instance['title'];
		}
		else {
			$title = __( 'New title', 'wp-editor-widget' );
		}

		if ( isset($instance['content']) ) {
			$content = $instance['content'];
		}
		else {
			$content = "";
		}

		$output_title = ( isset($instance['output_title']) && $instance['output_title'] == "1" ? true : false );
		?>
		<input type="hidden" id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name( 'content' ); ?>" value="<?php echo esc_attr($content); ?>">
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title', 'wp-editor-widget' ); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
		</p>
		<p>
			<a href="javascript:WPEditorWidget.showEditor('<?php echo $this->get_field_id( 'content' ); ?>');" class="button"><?php _e( 'Edit content', 'wp-editor-widget' ) ?></a>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('output_title'); ?>">
				<input type="checkbox" id="<?php echo $this->get_field_id('output_title'); ?>" name="<?php echo $this->get_field_name('output_title'); ?>" value="1" <?php checked($output_title, true) ?>> <?php _e( 'Output title', 'wp-editor-widget' ); ?>
			</label>
		</p>
		<?php

	} // END form()

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

		$instance['title']			= ( !empty($new_instance['title']) ? strip_tags( $new_instance['title']) : '' );
		$instance['content']		= ( !empty($new_instance['content']) ? $new_instance['content'] : '' );
		$instance['output_title']	= ( isset($new_instance['output_title']) && $new_instance['output_title'] == "1" ? 1 : 0 );

		do_action( 'wp_editor_widget_update', $new_instance, $instance );

 	 	return apply_filters( 'wp_editor_widget_update_instance', $instance, $new_instance );

	} // END update()

} // END class WP_Editor_Widget
