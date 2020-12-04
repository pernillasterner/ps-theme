<?php
/**
* Archive Template For Campuses
*/
get_header(); ?>

<?php pageBanner(array(
    'title' => 'Our Campuses',
    'subtitle' => 'Studdy Hard'
)); ?>


<div class="container container--narrow page-section">

  <div class="acf-map">
    <?php 
    while(have_posts()) { the_post(); ?>
      <?php $mapLocation = get_field('map_location'); ?>
      <div class="marker" data-lat="<?php echo $mapLocation['lat']; ?>" data-lng="<?php echo $mapLocation['lng']; ?>"></div>
    <?php }
    echo paginate_links(); 
    ?>
  </div>
</div>

<?php get_footer(); ?>