<?php

// LOADING SCRIPTS
function add_theme_scripts() {
  // Loading CSS
  wp_enqueue_style( 'style', get_stylesheet_uri() );
  // Loading JS
  wp_enqueue_script( 'script', get_theme_file_uri('/js/scripts-bundled.js'), null, 1.0, true);
  // Loading FONTS
  wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


// BASIC SETUP
function init() {
  // Generate title tag
  add_theme_support('title-tag');
}

add_action( 'after_setup_theme', 'init' );