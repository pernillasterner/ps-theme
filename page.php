<?php get_header();?>

<?php while(have_posts()) {
  the_post(); ?>
  
  <div class="page-banner">
    <div class="page-banner__bg-image" style="background-image: url(<?php echo get_theme_file_uri('images/ocean.jpg'); ?>);"></div>
    <div class="page-banner__content container container--narrow">
      <h1 class="page-banner__title"><?php the_title(); ?></h1>
      <div class="page-banner__intro">
        <p>FIX THIS LATER!!</p>
      </div>
    </div>  
  </div>

  
  <div class="container container--narrow page-section">
    <!-- Show only if the current page is a child page -->
    <?php if (is_page() && $post->post_parent) { ?>
      <div class="metabox metabox--position-up metabox--with-home-link">
        <p><a class="metabox__blog-home-link" href="<?php echo get_permalink( $post->post_parent )?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title( $post->post_parent ); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
      </div>
    <?php } ?>

  <!-- Show only if it´s a parent OR child page -->
  <?php
  // Check if the current page has any children - It will return a collection of children pages 
  $parent = get_pages( array(
    'child_of' => get_the_ID()
  ));
  ?>
    <?php if ($post->post_parent || $parent) : ?>
      <div class="page-links">
        <h2 class="page-links__title"><a href="#"><?php echo get_the_title( $post->post_parent ); ?></a></h2>
        <ul class="min-list">
          <?php
          // Check if it´s a childpage. If it´s not add the page id instead. 
          if($post->post_parent) {
            $childOf = $post->post_parent;
          } else {
            $childOf = get_the_ID();
          }
          ?>
          <?php wp_list_pages( $args = array(
            'title_li' => null,
            'child_of' => $childOf,
            'sort_column' => 'menu_order'
          )); ?>
        </ul>
      </div>
    <?php endif; ?>
        
    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>

  

<?php } ?>

<?php get_footer(); ?>