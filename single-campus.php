<?php 
/**
* Post Type Template for Single Campus
*/
get_header();?>

<?php while(have_posts()) {
  the_post(); ?>
  
  <?php pageBanner(); ?>

  <div class="container container--narrow page-section">
    <div class="metabox metabox--position-up metabox--with-home-link">
      <p><a class="metabox__blog-home-link" href="<?php echo get_post_type_archive_link('campus'); ?>"><i class="fa fa-home" aria-hidden="true"></i> All Campuses</a> <span class="metabox__main"><?php the_title(); ?></span></p>
    </div>

    <div class="generic-content"><?php the_content(); ?></div>

    <!-- Google Map -->
    <?php $mapLocation = get_field('map_location'); ?>
    <div class="acf-map">
      <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>">
        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        <?php echo $mapLocation['address'];  ?>
      </div>
    </div>
    
   
  
    <!-- Get and Output data if related_programs contains the current program post -->
    <?php
    // PROGRAMS
    $args = array(
      'posts_per_page' => -1,
      'post_type' => 'program',
      'orderby' => 'title',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'related_campus',
          'compare' => 'LIKE',
          'value' => strval(get_the_ID())
        )
      )
    );
    $programs = new WP_Query($args);
  

    if ($programs->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Programs available at this Campus</h2>';

      echo '<ul class="min-list link-list">';
      while ($programs->have_posts()) {
        $programs->the_post(); ?>
        <li>
          <a href="<?php the_permalink();?>"><?php the_title(); ?></a>
        </li>
      <?php
      }
      echo '</ul>';
    }

    // Reset global variables
    wp_reset_postdata();

    // EVENTS
    $today = date('Ymd');
    $args = array(
      'posts_per_page' => 2,
      'post_type' => 'event',
      'meta_key' => 'event_date',
      'orderby' => 'meta_value_num',
      'order' => 'ASC',
      'meta_query' => array(
        array(
          'key' => 'event_date',
          'compare' => '>=',
          'value' => $today,
          'type' => 'numeric'
        ),
        array(
          'key' => 'related_programs',
          'compare' => 'LIKE',
          'value' => strval(get_the_ID())
        )
      )
    );
    $events = new WP_Query($args);
    
    if ($events->have_posts()) {
        echo '<hr class="section-break">';
        echo '<h2 class="headline headline--medium">Upcoming ' . get_the_title() . ' Events</h2>';

      while ($events->have_posts()) {
        $events->the_post();
        get_template_part('template-parts/content-event');
      }
    } ?>

    <!-- Reset global variables -->
    <?php wp_reset_postdata(); ?>

  </div>

<?php } ?>

<?php get_footer(); ?>