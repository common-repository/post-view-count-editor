<?php
/**
 * Plugin Name: Post View Count Editor
 * Plugin URI: https://www.reggae.it/my-wordpress-plugins
 * Description: Edit PostView Count from a Backend Metabox
 * Version: 1.3
 * Author: Andrea Marinucci
 * Author URI: 
 */


//Create a Metbox  for all posttype
function postcount_box_edit()
{
    
    
    //just one of this post type or All?
    //$screens = ['post', 'Event'];
    
    $screens = get_post_types();
    
    
    foreach ($screens as $screen) {
        add_meta_box(
            'postcount_box_edit',           // Unique ID
            'Post View Count Editor',  // Box title
            'postcount_box_edit_html',  // Content callback, must be of type callable
             $screen  ,                 // Post type
			'side', // $context
      		  'low' // $priority
        );
    }
}

function postcount_your_function() {
    global $current_user;
    if($current_user->roles[0] == 'administrator') {
        add_action('add_meta_boxes', 'postcount_box_edit');
        // fill in your parameters
    }
}
add_action('admin_init','postcount_your_function');

 //  add_action('add_meta_boxes', 'postcount_box_edit');




// The Htlm t show in the Box
function postcount_box_edit_html($post)
{

$post = get_post();
 $countKey = 'post_views_count';
    $count = get_post_meta($post->ID, $countKey, true);

    ?>
    <label >Views:</label>
        <input size="6" id="postvieweditor" type="text" name="new_post_count" value="<?php echo $count;?>">
    <?php
}




//Save the value on post Update
function postcount_box_save_postdata($post_id)
{

	$post = get_post();
 	$countKey = 'post_views_count';
    $count = get_post_meta($post->ID, $countKey, true);

	$newcount_= sanitize_text_field( $_POST['new_post_count'] );



    if (array_key_exists('new_post_count', $_POST)) {
        update_post_meta(
            $post_id,
            $countKey,
             $newcount_
        );
    }
}
add_action('save_post', 'postcount_box_save_postdata');






?>
