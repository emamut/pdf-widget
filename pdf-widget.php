<?php
/*
Plugin Name: PDF Widget
Plugin URI: http://URI_Of_Page_Describing_Plugin_and_Updates
Description: Simple PDF widget viewer
Version: 1.0
Author: emamut
Author URI: https://emamut.net
License: GPL2
*/

// The widget class
class My_Custom_Widget extends WP_Widget {

	// Main constructor
	public function __construct() {
		/* ... */
	}

	// The widget form (for the backend )
	public function form( $instance ) {
		/* ... */
	}

	// Update widget settings
	public function update( $new_instance, $old_instance ) {
		/* ... */
	}

	// Display the widget
	public function widget( $args, $instance ) {
		/* ... */
	}

}

// Register the widget
function my_register_custom_widget() {
	register_widget( 'My_Custom_Widget' );
}
add_action( 'widgets_init', 'my_register_custom_widget' );