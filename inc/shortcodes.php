<?php
/**
 * This is where timber shortcodes are set up.
 * Not to be mistaken for Wordpress shortcodes.
 */

add_shortcode( 'button', 'button_shortcode' );
function button_shortcode( $atts ) {
  if (isset($atts['id'])) {
    $id = esc_attr($atts['id']);
  } else {
    $id = "btn-blue";
  }
  if (isset( $atts['link'] )) {
    $link = esc_url_raw( $atts['link']);
  } else {
    $link = "#";
  }
  if (isset( $atts['text'] )) {
    $text = esc_textarea($atts['text']);
  }
  if (isset( $atts['class'] )) {
    $class = esc_textarea($atts['class']);
  } else {
    $class = '';
  }

  return Timber::compile( 'shortcodes/buttons.twig', array( 'id' => $id, 'link' => $link, 'text' => $text, 'class' => $class ) );
}