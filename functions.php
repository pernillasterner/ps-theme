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