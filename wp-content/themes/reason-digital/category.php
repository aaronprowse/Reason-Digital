<?php
/**
* A Simple Category Template
*/
 
get_header(); 

$category = single_cat_title("", false);

?>

<div class="content">
 <div class="row">
  <div class="col-12 col-md-6">
   <h1><?php echo $category; ?></h1>

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
    $items = do_shortcode('[get_portfolio_items id="' . strtolower($category) . '"]'); 
    echo $items;
    ?>

</div>
</section>

<?php get_footer(); ?>