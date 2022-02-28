<?php get_header(); ?>

<div class="content">
 <div class="row">
  <div class="col-12 col-md-6">
   <h1><?php the_title();?></h1>

   <?php get_template_part('includes/section', 'content'); ?>

  </div>

  <div class="col-12 col-md-6 align-self-end">
   <ul class="list-unstyled portfolio-nav">
    <?php
    $categories = do_shortcode('[get_portfolio_categories]'); 
    echo $categories;
 ?>

  </div>
 </div>

 <?php 
    $items = do_shortcode('[get_portfolio_items id="portfolio"]'); 
    echo $items;
    ?>

</div>




<?php get_footer(); ?>