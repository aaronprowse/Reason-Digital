 <?php get_header('alt'); ?>
 <div class="content">
  <div class="row">
   <div class="col-12 col-md-5">
    <div id="content-left">
     <h1><?php the_title();?></h1>
     <?php get_template_part('includes/section', 'content'); ?>
    </div>
   </div>
   <div class="col-12 col-md-7">
    <div id="content-right">
     <?php the_post_thumbnail(); ?>
    </div>
   </div>
  </div>
 </div>


 <?php get_footer(); ?>