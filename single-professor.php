<?php 
/**
* Post Type Template for Single Professor
*/
get_header();?>

<?php while(have_posts()) {
  the_post(); ?>

<?php pageBanner(); ?>

  <div class="container container--narrow page-section">

    <div class="generic-content">
      <div class="row group">
        <div class="one-third"><?php the_post_thumbnail('professorPortrait'); ?></div>
        <div class="two-thirds"><?php the_content(); ?></div>
      </div>
    </div>

    <hr class="section-break">

    <?php 
    // Add related programs
    $relatedPrograms = get_field('related_programs');
    if($relatedPrograms) {
        echo '<h2 class="headline headline--medium">Subject(s) Taught</h2>';
        echo '<ul class="link-list min-list">';
        foreach ($relatedPrograms as $program) { ?>
        <li><a href="<?php echo get_the_permalink($program); ?>"><?php echo get_the_title($program); ?></a></li>
        <?php }
        echo '</ul>';
    }
    ?>

  </div>
  
<?php } ?>

<?php get_footer(); ?>