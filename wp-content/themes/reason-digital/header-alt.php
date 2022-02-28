<!DOCTYPE html>
<html <?php language_attributes(); ?>>


<head>
 <meta charset="<?php bloginfo( 'charset' ); ?>">
 <meta http-equiv="X-UA-Compatible" content="IE=edge">
 <meta name="viewport" content="width=device-width, initial-scale=1.0">
 <title><?php the_title(); ?></title>

 <?php wp_head(); ?>

 <link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/css/portfolio.css" type="text/css" media="screen" />
</head>

<body <?php body_class(); ?>>

 <div class="container-fluid">
  <header>
   <?php 
if ( function_exists( 'the_custom_logo' ) ) {
    the_custom_logo();
}
?>
   <nav class="navbar">
    <?php wp_nav_menu(); ?>
    <div class="ham">
     <span class="bar1"></span>
     <span class="bar2"></span>
     <span class="bar3"></span>
    </div>
   </nav>
  </header>

  <?php
		wp_body_open();
		?>