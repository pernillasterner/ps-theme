<?php
/**
* Archive Template For Events
*/
get_header(); ?>

<?php pageBanner(array(
    'title' => 'All Events',
    'subtitle' => 'See what is going on!'
)); ?>

<div class="container container--narrow page-section">
<?php 
while(have_posts()) { the_post();
  get_template_part('template-parts/content-event');
}
echo paginate_links(); 
?>

<hr class="section-break">

<p>Looking for a recape of pasts events? <a href="<?php echo site_url('/past-events'); ?>">Check out our past events archive</a></p>
</div>

<?php get_footer(); ?>