<?php
include 'keys.php';
require get_theme_file_path('/inc/search-route.php');

// Rest API
function ps_theme_custom_rest() {
  // register_rest_field ( 'name-of-post-type', 'name-of-field-to-return', array-of-callbacks-and-schema()
  register_rest_field('post', 'authorName', array(
    'get_callback' => function() { return get_the_author(); }
  ));
}
add_action( 'rest_api_init', 'ps_theme_custom_rest' );


// Page Banner Content
function pageBanner($args = NULL) {
  
  if(!$args['title'] ) {
    $args['title'] = get_the_title();
  }

  if(!$args['subtitle'] ) {
    $args['subtitle'] = get_field('page_banner_subtitle');
  }
  
  if(!$args['photo']) {
    if(get_field('page_banner_background_image') && !is_archive() && !is_home()) {
      $args['photo'] = get_field('page_banner_background_image')['sizes']['pageBanner'];
    } else {
      $args['photo'] = get_theme_file_uri('/images/ocean.jpg');
    }
  } ?>

  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo $args['photo']; ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php echo $args['title']; ?></h1>
      <div class="page-banner__intro">
        <p><?php echo $args['subtitle']; ?></p>
      </div>
    </div>  
  </div>
  <?php
}

// LOADING SCRIPTS
function add_theme_scripts() {
  global $googleMapAPI_KEY;
  // Loading FONTS
  wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'custom-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto+Condensed:300,300i,400,400i,700,700i|Roboto:100,300,400,400i,700,700i' );
  // Loading JS & CSS
  wp_enqueue_script( 'googleMap', "//maps.googleapis.com/maps/api/js?key=$googleMapAPI_KEY", null, 1.0, true);
  wp_enqueue_script( 'script', 'http://localhost:3000/bundled.js', null, 1.0, true);

  wp_localize_script( 'script', 'themeData', array(
    'root_url' => get_site_url()
  ));

}
add_action( 'wp_enqueue_scripts', 'add_theme_scripts' );


// BASIC SETUP
function init() {
  // Generate title tag
  add_theme_support('title-tag');
  add_theme_support('post-thumbnails');
  add_image_size('professorLandscape', 400, 260, true);
  add_image_size('professorPortrait', 480, 650, true);
  add_image_size('pageBanner', 1500, 350, true);
}
add_action( 'after_setup_theme', 'init' );


// Determines whether the current request is for an administrative interface page AND whether the query is the main query.
function adjust_queries($query) {
  if(!is_admin() && is_post_type_archive('campus') && is_main_query()) {
    $query->set('post_per_page', -1);
  }

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


// GOOGLE MAP API
function mapKey($googleMapAPI_KEY) {
  // global $googleMapAPI_KEY;
  $api['key'] = $googleMapAPI_KEY;
  return $api;
}
add_filter('acf/fields/google_map/api', 'mapKey');