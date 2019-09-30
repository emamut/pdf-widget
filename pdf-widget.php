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
class PDF_Widget extends WP_Widget {

  // Main constructor
  public function __construct() {
    parent::__construct(
      'my_custom_widget',
      __( 'PDF Reader', 'text_domain' ),
      array(
        'customize_selective_refresh' => true,
      )
    );
  }

  // The widget form (for the backend )
public function form( $instance ) {

  // Set widget defaults
  $defaults = array(
    'title'    => '',
    'text'     => ''
  );

  // Parse current settings with defaults
  extract( wp_parse_args( ( array ) $instance, $defaults ) ); ?>

  <?php // Widget Title ?>
  <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php _e( 'Title', 'text_domain' ); ?></label>
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
  </p>

  <?php // Text Field ?>
  <p>
    <label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php _e( 'URL:', 'text_domain' ); ?></label>
    <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
  </p>
  <?php }

  // Update widget settings
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance['title']    = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
    $instance['text']     = isset( $new_instance['text'] ) ? wp_strip_all_tags( $new_instance['text'] ) : '';

    return $instance;
  }

  // Display the widget
  public function widget( $args, $instance ) {

    extract( $args );

    // Check the widget options
    $title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
    $text     = isset( $instance['text'] ) ? $instance['text'] : '';

    // WordPress core before_widget hook (always include )
    echo $before_widget;

    // Display the widget
    echo '<div class="widget-text wp_widget_plugin_box">';

      // Display widget title if defined
      if ( $title ) {
        echo $before_title . $title . $after_title;
      }

      // Display text field
      if ( $text ) {
        echo '<iframe src="https://docs.google.com/viewer?url=' . $text . '&embedded=true" style="width:600px; height:350px;" frameborder="0"></iframe>';
      }

    // WordPress core after_widget hook (always include )
    echo $after_widget;

  }

}

// Register the widget
function my_register_custom_widget() {
  register_widget( 'PDF_Widget' );
}
add_action( 'widgets_init', 'my_register_custom_widget' );