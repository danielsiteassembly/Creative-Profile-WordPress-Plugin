<?php

/**
 * @package Couple
 */
/*
Plugin Name: Couple
Description: Description: Easily create dynamic web pages for your photography or videography clients and share them with the world.
Version: 1.0.1
Author: Site Assembly
*/

define( 'VVD_COUPLE_DIR', plugin_dir_path( __FILE__ ) );

function couple_styles( $page ) {
    /* Js File */
    wp_enqueue_script( 'wickedpicker-js', plugins_url('/js/wickedpicker.min.js', __FILE__));
    wp_enqueue_script( 'datepicker-js', plugins_url('/js/datepicker.min.js', __FILE__));

    /* CSS File*/
    wp_enqueue_style( 'wickedpicker-css', plugins_url('/css/wickedpicker.min.css', __FILE__));
    wp_enqueue_style( 'datepicker-css', plugins_url('/css/datepicker.min.css', __FILE__));
    wp_enqueue_style( 'font-awesome-css', plugins_url('/css/font-awesome.css', __FILE__));

}

add_action( 'admin_enqueue_scripts', 'couple_styles');


function singleCoupleScripts() {
    global $post;
    if($post->post_type == 'couples' && is_single())
    {
        // Css
        wp_enqueue_style( 'single-couple-css', plugins_url('/css/couple-style.css', __FILE__) );
        wp_enqueue_style( 'single-couple-lightbox-css', plugins_url('/css/lightbox/simplelightbox.min.css', __FILE__) );

        // Js
        wp_enqueue_script( 'masonary-js', plugins_url('/js/masonary/masonry.pkgd.js', __FILE__), '', '', true);
        wp_enqueue_script( 'single-couple-js', plugins_url('/js/couple-script.js', __FILE__), '', '', true);
        wp_enqueue_script( 'single-couple-lightbox-js', plugins_url('/js/lightbox/simple-lightbox.min.js', __FILE__), '', '', true);
    }
}
add_action( 'wp_enqueue_scripts', 'singleCoupleScripts' );

require_once( VVD_COUPLE_DIR . 'required.php' );
require_once( VVD_COUPLE_DIR . 'couple_post_type.php' );
require_once( VVD_COUPLE_DIR . 'couple_meta.php' );
require_once( VVD_COUPLE_DIR . 'couple_ajax.php' );

add_action( 'edit_form_after_title', 'wp692_edit_form_after_title' );

function wp692_edit_form_after_title() {
    echo '<h1>Description</h1>';
}

// Plugin activation hook
if(!function_exists('addCouplePage'))
{
    function addCouplePage()
    {
        $postType = 'page'; // set to post or page
        $userID = get_current_user_id(); // set to user id
        $postStatus = 'publish';  // set to future, draft, or publish
        $leadTitle = 'Couples';
        $post_content = "[couples]";

        $new_post = array(
            'post_title' => $leadTitle,
            'post_status' => $postStatus,
            'post_content' => $post_content,
            'post_author' => $userID,
            'post_type' => $postType
        );

        $post_id = wp_insert_post($new_post);
    }
    register_activation_hook(__FILE__, 'addCouplePage');
}

if(!function_exists('removeCouplePage'))
{
    function removeCouplePage()
    {
        $page = get_page_by_path( 'couples' );
        $page_id = $page->ID;
        wp_delete_post( $page_id, true );
    }
    register_deactivation_hook(__FILE__, 'removeCouplePage');
}

function load_couples_template($template) {
    global $post;

    if ($post->post_type == "couples" && $template !== locate_template(array("single-couples.php"))){
        /* This is a "couples" post 
         * AND a 'single couples template' is not found on 
         * theme or child theme directories, so load it 
         * from our plugin directory
         */
        return plugin_dir_path( __FILE__ ) . "single-couples.php";
    }

    return $template;
}

add_filter('single_template', 'load_couples_template');