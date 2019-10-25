<?php
/*
Plugin Name: PDF Widget
Plugin URI: https://github.com/emamut-net/pdf-widget
Description: Simple PDF viewer widget
Version: 1.0
Author: emamut
Author URI: https://emamut.net
License: GPL2
*/

// The widget class
class PDF_Widget extends WP_Widget
{

  // Main constructor
  public function __construct()
  {
    parent::__construct(
      'pdf_widget',
      __( 'PDF Widget', 'text_domain' ),
      array(
        'customize_selective_refresh' => true,
      )
    );

    add_action( 'wp_enqueue_scripts', 'my_custom_script_load' );
    function my_custom_script_load(){
      wp_enqueue_style( 'fontawesome', plugins_url('fontawesome/css/font-awesome.min.css', __FILE__) );
      wp_enqueue_style( 'styles', plugins_url('styles.css', __FILE__) );

      wp_enqueue_script( 'pdfobject', plugin_dir_url( __FILE__ ) . 'js/pdfobject.min.js', array( 'jquery' ) );
      wp_enqueue_script( 'app', plugin_dir_url( __FILE__ ) . 'js/app.js', array( 'jquery' ) );
    };
  }

  // The widget form (for the backend )
  public function form( $instance )
  {
    // Set widget defaults
    $defaults = array(
      'title'    => '',
      'url'     => '',
      'pdf_url'     => '',
      'height'     => ''
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
      <label for="<?php echo esc_attr( $this->get_field_id( 'pdf_url' ) ); ?>"><?php _e( 'PDF URL:', 'text_domain' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'pdf_url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'pdf_url' ) ); ?>" type="text" value="<?php echo esc_attr( $pdf_url ); ?>" />
    </p>

    <?php // Text Field ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>"><?php _e( 'Link URL:', 'text_domain' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'url' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'url' ) ); ?>" type="text" value="<?php echo esc_attr( $url ); ?>" />
    </p>

    <?php // Text Field ?>
    <p>
      <label for="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>"><?php _e( 'Height in pixels:', 'text_domain' ); ?></label>
      <input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'height' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'height' ) ); ?>" type="text" value="<?php echo isset($height) ? esc_attr( $height ) : '300'; ?>" style="width: 30%; margin-right: .5rem;" />px
    </p>
    <?php
  }

  // Update widget settings
  public function update( $new_instance, $old_instance )
  {
    $instance = $old_instance;
    $instance['title']       = isset( $new_instance['title'] ) ? wp_strip_all_tags( $new_instance['title'] ) : '';
    $instance['url']         = isset( $new_instance['url'] ) ? wp_strip_all_tags( $new_instance['url'] ) : '';
    $instance['pdf_url']     = isset( $new_instance['pdf_url'] ) ? wp_strip_all_tags( $new_instance['pdf_url'] ) : '';
    $instance['height']      = isset( $new_instance['height'] ) ? wp_strip_all_tags( $new_instance['height'] ) : '';

    return $instance;
  }

  // Display the widget
  public function widget( $args, $instance )
  {
    extract( $args );

    // Check the widget options
    $title    = isset( $instance['title'] ) ? apply_filters( 'widget_title', $instance['title'] ) : '';
    $url      = isset( $instance['url'] ) ? $instance['url'] : '';
    $pdf_url  = isset( $instance['pdf_url'] ) ? $instance['pdf_url'] : '';
    $height   = isset( $instance['height'] ) ? $instance['height'] : '';

    // WordPress core before_widget hook (always include )
    echo $before_widget;

    // Display the widget
    echo '<div class="widget-text wp_widget_plugin_box">';

    // Display widget title if defined
    if ( $title ) {
      echo $before_title . $title . $after_title;
    }

    // Display text field
    if ( $pdf_url ) {
      echo '<div id="pdf-widget-container">
        <div id="myPDF" data-pdf-url="' . $pdf_url . '" data-url="' . $url . '" data-height="' . $height . '" style="height: ' . $height . 'px"></div>';
        if (isset($url) and !empty($url)) echo '<button id="link"><i class="fa fa-external-link"></i></button>';
      echo '</div>';
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