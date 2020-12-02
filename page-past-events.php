<?php
/**
* Template For Post Type Page->Past Events
*/
get_header(); ?>

<?php pageBanner(array(
    'title' => 'Past Events',
    'subtitle' => 'Recape of our pasts events!'
)); ?>

<div class="container container--narrow page-section">
<?php
$today = date('Ymd');
$args = array(
  'paged' => get_query_var('paged', 1),
  'post_type' => 'event',
  'meta_key' => 'event_date',
  'orderby' => 'meta_value_num',
  'order' => 'ASC',
  'meta_query' => array(
    array(
      'key' => 'event_date',
      'compare' => '<',
      'value' => $today,
      'type' => 'numeric'
)));
$pastEvents = new WP_Query($args);

while($pastEvents->have_posts()) { $pastEvents->the_post();
  get_template_part('template-parts/content-event');
}

// Reset global variables
wp_reset_postdata();

echo paginate_links(array(
  'total' => $pastEvents->max_num_pages
)); 
?>
</div>

<?php get_footer(); ?>