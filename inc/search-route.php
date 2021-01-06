<?php
function register_search() {
  register_rest_route( 'ps-theme/v1', 'search',  array(
    'methods' => WP_REST_SERVER::READABLE,
    'callback' => 'searchResults'
  ));
}
add_action( 'rest_api_init', 'register_search' );

function searchResults($data) {
  $professors = new WP_Query(array(
    'post_type' => 'professor',
    's' => sanitize_text_field($data['term'])
  ));

  $professorResults = array();

  while($professors->have_posts()) {
    $professors->the_post();
    array_push($professorResults, array(
      'title' => get_the_title(),
      'permalink' => get_the_permalink()
    ));
  }

  return $professorResults;
}