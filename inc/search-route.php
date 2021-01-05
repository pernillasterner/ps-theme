<?php
function register_search() {
  register_rest_route( 'ps-theme/v1', 'search',  array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'searchResults'
  ));
}
add_action( 'rest_api_init', 'register_search' );

function searchResults() {
  return 'Test routing';
}