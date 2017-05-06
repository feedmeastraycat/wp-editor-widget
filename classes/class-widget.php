<?php
//avoid direct calls to this file
if ( ! defined( 'ABSPATH' ) ) {
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
		
		// WPML support?
		if ( function_exists( 'icl_get_languages' ) ) {
			$widget_name = esc_html__( 'Multilingual', 'wp-editor-widget' ) . ' ' . esc_html__( 'Rich text', 'wp-editor-widget' );
		}
		else {
			$widget_name = esc_html__( 'Rich text', 'wp-editor-widget' );
		}

		$widget_ops = apply_filters(
			'wp_editor_widget_ops',
			array(
				'classname' 	=> 'WP_Editor_Widget',
				'description' 	=> __( 'Arbitrary text, HTML or rich text through the standard WordPress visual editor.', 'wp-editor-widget' ),
			)
		);
		
		parent::__construct(
			'WP_Editor_Widget',
			$widget_name,
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

		$title			= apply_filters( 'wp_editor_widget_title', $instance['title'] );
		$output_title	= apply_filters( 'wp_editor_widget_output_title', $instance['output_title'] );
		$content		= apply_filters( 'wp_editor_widget_content', $instance['content'] );
		
		$show = true;
		
		// WPML support?
		if ( function_exists( 'icl_get_languages' ) ) {
			$language = apply_filters( 'wp_editor_widget_language', $instance['language'] );
			$show = ($language == icl_get_current_language());
		}
		
		if ( $show ) {
	
			$default_html = $args['before_widget'];
	
			if ( '1' == $output_title && ! empty( $title ) ) {
				$default_html .= $args['before_title'] . $title . $args['after_title'];
			}
	
			$default_html .= $content;
	
			$default_html .= $args['after_widget'];
			
			echo apply_filters( 'wp_editor_widget_html', $default_html, $args['id'], $instance, $args['before_widget'], $args['after_widget'], $output_title, $title, $args['before_title'], $args['after_title'], $content );
			
		}

	} // END widget()

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {

		if ( isset( $instance['title'] ) ) {
			$title = $instance['title'];
		}
		else {
			$title = __( 'New title', 'wp-editor-widget' );
		}

		if ( isset( $instance['content'] ) ) {
			$content = $instance['content'];
		}
		else {
			$content = '';
		}

		$output_title = ( isset( $instance['output_title'] ) && '1' == $instance['output_title'] ? true : false );
		?>
		<input type="hidden" id="<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'content' ) ); ?>" value="<?php echo esc_attr( $content ); ?>">
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'wp-editor-widget' ); ?>:</label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<a href="javascript:WPEditorWidget.showEditor('<?php echo esc_attr( $this->get_field_id( 'content' ) ); ?>');" class="button"><?php _e( 'Edit content', 'wp-editor-widget' ) ?></a>
		</p>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'output_title' ) ); ?>">
				<input type="checkbox" id="<?php echo esc_attr( $this->get_field_id( 'output_title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'output_title' ) ); ?>" value="1" <?php checked( $output_title, true ) ?>> <?php _e( 'Output title', 'wp-editor-widget' ); ?>
			</label>
		</p>
		<?php if ( function_exists( 'icl_get_languages' ) ) : $languages = icl_get_languages( 'skip_missing=0&orderby=code' ); ?>
			<label for="<?php echo esc_attr( $this->get_field_id( 'language' ) ); ?>">
				<?php _e( 'Language', 'wp-editor-widget' ); ?>:
				<select id="<?php echo esc_attr( $this->get_field_id( 'language' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'language' ) ); ?>">
					<?php foreach ( $languages as $id => $lang ) : ?>
						<option value="<?php echo esc_attr( $lang['language_code'] ) ?>" <?php selected( $instance['language'], $lang['language_code'] ) ?>><?php echo esc_attr( $lang['native_name'] ) ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		<?php endif; ?>
		<?php
			
		do_action( 'wp_editor_widget_form', $this, $instance );

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

		$instance['title']			= ( ! empty( $new_instance['title'] ) ? strip_tags( $new_instance['title'] ) : '' );
		$instance['content']		= ( ! empty( $new_instance['content'] ) ? $new_instance['content'] : '' );
		$instance['output_title']	= ( isset( $new_instance['output_title'] ) && '1' == $new_instance['output_title'] ? 1 : 0 );
		
		// WPML support
		if ( function_exists( 'icl_get_languages' )  ) {
			$instance['language']   = ( isset( $new_instance['language'] ) ? $new_instance['language'] : '');
		}

		do_action( 'wp_editor_widget_update', $new_instance, $instance );

 	 	return apply_filters( 'wp_editor_widget_update_instance', $instance, $new_instance );

	} // END update()

} // END class WP_Editor_Widget
