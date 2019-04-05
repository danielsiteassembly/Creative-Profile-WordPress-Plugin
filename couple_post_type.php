<?php
// Create custom post type for couple plugin
/**
 * Register a Couple post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function couple_init() {
  $labels = array(
    'name'                  => _x( 'Couples', 'post type general name', 'cpl' ),
    'singular_name'         => _x( 'Couple', 'post type singular name', 'cpl' ),
    'featured_image'        => _x( 'Cover Image (1350x300)', 'post type feature image', 'cpl' ),
    'set_featured_image'    => _x( 'Set cover image', 'post type set cover image', 'cpl' ),
    'remove_featured_image' => _x( 'Remove feature image', 'post type remove feature image', 'cpl' ),
    'use_featured_image'    => _x( 'Use as Cover Image', 'post type cover image', 'cpl' ),
    'menu_name'             => _x( 'Couples', 'admin menu', 'cpl' ),
    'name_admin_bar'        => _x( 'Couple', 'add new on admin bar', 'cpl' ),
    'add_new'               => _x( 'Add New', 'Couple', 'cpl' ),
    'add_new_item'          => __( 'Add Couple Name', 'cpl' ),
    'new_item'              => __( 'New Couple', 'cpl' ),
    'edit_item'             => __( 'Edit Couple Name', 'cpl' ),
    'view_item'             => __( 'View Couple', 'cpl' ),
    'all_items'             => __( 'All Couples', 'cpl' ),
    'search_items'          => __( 'Search Couples', 'cpl' ),
    'parent_item_colon'     => __( 'Parent Couples:', 'cpl' ),
    'not_found'             => __( 'No Couples found.', 'cpl' ),
    'not_found_in_trash'    => __( 'No Couples found in Trash.', 'cpl' )
  );

  $args = array(
    'labels'             => $labels,
                'description'        => __( 'Description.', 'cpl' ),
    'public'             => true,
    'publicly_queryable' => true,
    'show_ui'            => true,
    'show_in_menu'       => true,
    'query_var'          => true,
    'rewrite'            => array( 'slug' => 'couples' ),
    'capability_type'    => 'post',
    'has_archive'        => true,
    'hierarchical'       => false,
    'menu_position'      => null,
    'menu_icon'          => 'dashicons-groups',
    'supports'           => array('title', 'thumbnail', 'editor')
  );

  register_post_type( 'couples', $args );
}
add_action( 'init', 'couple_init' );
?>