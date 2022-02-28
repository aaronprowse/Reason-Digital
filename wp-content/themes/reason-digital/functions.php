<?php
function scripts() {

wp_register_style('style', get_template_directory_uri() . '/dist/global.css', [], 1, 'all');
wp_enqueue_style('style');


wp_enqueue_script('jquery');

wp_register_script('app', get_template_directory_uri() . '/dist/app.js', ['jquery'], 1, true);
wp_enqueue_script('app');


}
add_action('wp_enqueue_scripts','scripts');

	
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 600, 600);

function portfolio_categories() {
 $parent_term_id = 8;
$taxonomies = array( 
    'category',
);
$args = array(
    // 'parent'         => $parent_term_id, use this for subcategory under parent category. For this example I have used child of to produce all the sub categories and descendants.
    'child_of'      => $parent_term_id, 
); 
$terms = get_terms($taxonomies, $args);
// var_dump($terms);

foreach( $terms as $category ) {

if($category->name == "All") {
//Prevents user from hitting ALL Category Page. This has been implemented to prevent the website from not being able to use the "categorys" from the wordpress admin. if at a later date the client decides to have a blog. Alternatively remove the all category and this will work no problem. Canonical can be added to all category page to prevent duplicate content issues with SEO. This will also create dependency to the client to always have the portfolio as home page but can be discussed pre development.
$cat_link = get_home_url();
} else {
 $cat_link = get_category_link( $category->term_id ); 

}

    $category_link = sprintf( 
        '<a href="%1$s" alt="%2$s">%3$s</a>',
        esc_url( $cat_link ),
        esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
        esc_html( $category->name )
    );
     
    echo '<li class="display-inline">' . sprintf( esc_html__( '%s', 'textdomain' ), $category_link ) . '</li> ';
}

// Use this route if you there is no future chance of a blog being implemented.
// $categories = get_categories( array(
//     'orderby' => 'name',
//     'order'   => 'ASC'
// ) );

// // var_dump($categories);
 
// foreach( $categories as $category ) {
//     $category_link = sprintf( 
//         '<a href="%1$s" alt="%2$s">%3$s</a>',
//         esc_url( get_category_link( $category->term_id ) ),
//         esc_attr( sprintf( __( 'View all posts in %s', 'textdomain' ), $category->name ) ),
//         esc_html( $category->name )
//     );
     
//     echo '<li class="display-inline">' . sprintf( esc_html__( '%s', 'textdomain' ), $category_link ) . '</li> ';
// } 
}

add_shortcode('get_portfolio_categories', 'portfolio_categories');


function portfolio_items($cat) {

 if($cat) {
  $cat = "'" . $cat['id'] . "'";
 } else {
  $cat = 'portfolio';
 }

$the_query = new WP_Query( array( 
    'category_name' => $cat
) ); 
if ( $the_query->have_posts() ) {
    $string = '<div class="row">';
    while ( $the_query->have_posts() ) {
        $the_query->the_post();

        $post_id = get_the_ID();
        $category = get_the_category();

            if ( has_post_thumbnail() ) {
            $string .= '<div class="col-12 col-md-4 portfolio">';
            $string .= '<a href="' . get_the_permalink() .'"><div class="portfolio__thumbnail-container">' . get_the_post_thumbnail($post_id, 'full', ['class' => 'img-responsive portfolio__thumbnail']) . '</div><h2>' . get_the_title() . '</h2>';
            $string .= '<h3>' . $category[0]->cat_name .'</h3>';
            $string .= "</a></div>";
            } else { 
            // If no featured thumbnail
            $string .= '<a href="' . get_the_permalink() .'">' . get_the_title() .'</a>';
            }
            }
    } else {
 $string .= '<h2>No Posts Found</h2>';
}
$string .= '</div>';
// if ( $the_query->have_posts() ) {
//     $string = '<ul class="list-unstyled portfolio-list">';
//     while ( $the_query->have_posts() ) {
//         $the_query->the_post();
//         $post_id = get_the_ID();
//             if ( has_post_thumbnail() ) {
//             $string .= '<li class="display-inline">';
//             $string .= '<a href="' . get_the_permalink() .'">' . get_the_post_thumbnail($post_id, 'full', ['class' => 'img-responsive portfolio-thumbnail']) . '</a>' . '<a href="' . get_the_permalink() .'">' . get_the_title() .'</a></li>';
//             } else { 
//             // If no featured thumbnail
//             $string .= '<li><a href="' . get_the_permalink() .'">' . get_the_title() .'</a></li>';
//             }
//             }
//     } else {
//  $string .= '<li>No Posts Found</li>';
// }
// $string .= '</ul>';
   
return $string;
   
wp_reset_postdata();
}
add_shortcode('get_portfolio_items', 'portfolio_items');