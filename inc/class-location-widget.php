<?php

// http://www.wpbeginner.com/wp-tutorials/how-to-create-a-custom-wordpress-widget/

// Creating the widget
class Location_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			// Base ID of your widget
			'location_widget',

			// Widget name will appear in UI
			__('Location Widget', 'location_widget_domain'),

			// Widget description
			array( 'description' => __( 'Sample widget for showing locations in sidebar', 'location_widget_domain' ), )
		);
	}

	// Creating widget front-end
	// This is where the action happens
	public function widget( $args, $instance ) {
		
		global $post; 
		$title = apply_filters( 'widget_title', $instance['title'] );
		
		// before and after widget arguments are defined by themes
		echo $args['before_widget'];
		if ( ! empty( $title ) )
			echo $args['before_title'] . $title . $args['after_title'];

		// This is where you run the code and display the output
		// echo __( 'Hello, World!', 'location_widget_domain' );
		
		$atts = array();
		
		echo generate_map($atts);

		echo $args['after_widget'];
	}

	// Widget Backend
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = __( 'New title', 'location_widget_domain' );
		}
		
		// Widget admin form
?>
<p>
<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
</p>

<?php
	}

	// Updating widget replacing old instances with new
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';
		return $instance;
	}
} // Class location_widget ends here

// Register and load the widget
function location_load_widget() {
	register_widget( 'Location_Widget' );
}
add_action( 'widgets_init', 'location_load_widget' );
