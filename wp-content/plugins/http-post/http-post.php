<?php
   /*
   Plugin Name: HTTP-Post
   Plugin URI: https://github.com/aaronprowse/Reason-Digital
   description: Custom Plugin for HTTP Post requests when content is modified.
   Version: 1.0
   Author: Aaron Prowse
   Author URI: https://github.com/aaronprowse/Reason-Digital
   */



function page_created($post) {
   $data = $post->ID;
   update_api("created", $data);
}

/* This function is when the post is deleted but does not cover when trashed, trashed is covered under function page_modified() */
function page_deleted($post_id) {
   update_api("deleted", $post_id);
}

/* Function needs improving currently it posts an update on a new publish. Attempted to use get_post_status() but this only returned 'publish' and not any other values for me to filter */
/* Also attempted an alternative route to get the post creation time and modified time to see if they match this in theroy should then prevent the modify */
/* Also attempted changing the hook from save_post to edit_post but same problem. */
function page_modified($post_id) {
      update_api("modified", $post_id);
}

add_action( 'save_post', 'page_modified');
add_action( 'before_delete_post', 'page_deleted');


add_action( 'auto-draft_to_publish', 'page_created' );
/* If auto draft is disabled then draft_to_publish hook will be called. */
add_action( 'draft_to_publish', 'page_created' );

   


function update_api( $action, $post_id ) {


$username = 'apiuser';
$password = 'passwd';

// ADD A CHECK TO MAKE SURE A USERNAME & PASSWORD HAS BEEN INPUTED IF NOT REMOVE AUTHORIZATION LINE.
$headers = array( 
     'Authorization' => 'Basic ' . base64_encode( "$username:$password" ), 
     'Content-Type' => 'application/json' 
);
//To test the post load: http://ptsv2.com/t/71sy2-1646094521
   $url = 'http://ptsv2.com/t/71sy2-1646094521/post';
   $arguments = array(
      'method' => 'POST',
      'data_format' => 'body',
      'headers'     => $headers,
      'body' => json_encode(
         array(
         'action' => $action,
         'pageId' => $post_id
         )
      )
      );

   $response = wp_remote_post( $url, $arguments);

   if(is_wp_error($response)) {
      $error_message = $response->get_error_message();
      echo "Something went wrong: $error_message";
   } 
   //Testing
   // } else {
   //    echo 'Response:<pre>';
   //    print_r($response);
   //    echo '</pre>';
   // }
}

/*                           */
/*    WP Admin Custom Page   */
/*                           */

   function admin_page() {
      add_menu_page(
         'HTTP Post Plugin Page',
         'HTTP Post',
         'manage_options',
         'http-post',
         'init'
      );
   }

   function init() {
      echo "<h1>HTTP Post - inputs are not operational this is how I would plan</h1>";
      echo "<em>For testing purposes please feel free to use a service like: <a href='http://ptsv2.com/t/71sy2-1646094521' target='_blank'>http://ptsv2.com/t/71sy2-1646094521</a></em><br/><br/> ";
       $html = 'Enter post URL : <input type="text" name="url" required/><br /><br />';
      $html.= 'Enter Username: <input type="text" name="username" /><br /><br />';
      $html.= 'Enter Password: <input type="text" name="password" /><br /><br />';
      $html.= 'Username & Password may not be required for your payload.<br /><br />';

 $html.= '<input type="submit" value="save" name="save" />';

 echo $html;

   }

   add_action('admin_menu', 'admin_page');

   function http_post_install() {
    global $table_prefix, $wpdb;

    $tblname = 'httppost';
    $wp_track_table = $table_prefix . "$tblname ";

    #Check to see if the table exists already, if not, then create it

    if($wpdb->get_var( "show tables like '$wp_track_table'" ) != $wp_track_table) 
    {

        $sql = "CREATE TABLE `". $wp_track_table . "` ( ";
        $sql .= "  `url` text NOT NULL, ";
        $sql .= "  `username` text, ";
        $sql .= "  `password` text, ";
        $sql .= ") ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ; ";
        require_once( ABSPATH . '/wp-admin/includes/upgrade.php' );
        dbDelta($sql);
    }
}

 register_activation_hook( __FILE__, 'http_post_install' );



?>