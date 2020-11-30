<?php

// LOADING SCRIPTS
function add_theme_scripts() {
  // Loading FONTS
  wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  // Loading JS & CSS
  wp_enqueue_script( 'script', 'http://localhost:3000/bundled.js', null, 1.0, true);
 
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


// BASIC SETUP
function init() {
  // Generate title tag
  add_theme_support('title-tag');
}
add_action( 'after_setup_theme', 'init' );



function adjust_queries($query) {
  // Determines whether the current request is for an administrative interface page AND whether the query is the main query.
  if(!is_admin() && is_post_type_archive('program') && is_main_query()) {
    $query->set('orderby', 'title');
    $query->set('order', 'ASC');
    $query->set('post_per_page', -1);
  }

  if(!is_admin() && is_post_type_archive('event') && is_main_query()) {
    $today = date('Ymd');
    $query->set('meta_key', 'event_date');
    $query->set('orderby', 'meta_value_num');
    $query->set('order', 'ASC');
    $query->set('meta_query', array(
      array(
        'key' => 'event_date',
        'compare' => '>=',
        'value' => $today,
        'type' => 'numeric'
      )
    ));
  }
}
add_action('pre_get_posts', 'adjust_queries');
