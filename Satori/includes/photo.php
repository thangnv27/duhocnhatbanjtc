<?php
/**
 * Custom photo post type
 */

add_action('init', 'create_photo_post_type');

function create_photo_post_type(){
    register_post_type('photo', array(
        'labels' => array(
            'name' => __('Photos'),
            'singular_name' => __('Photos'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Photo'),
            'new_item' => __('New Photo'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Photo'),
            'view' => __('View Photo'),
            'view_item' => __('View Photo'),
            'search_items' => __('Search Photos'),
            'not_found' => __('No Photo found'),
            'not_found_in_trash' => __('No Photo found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'editor', 'author', 'excerpt', 'thumbnail',
            //'custom-fields', 'comments',
        ),
        'rewrite' => array('slug' => 'photo', 'with_front' => false),
        'can_export' => true,
        'description' => __('Photo description here.')
    ));
}

# Custom photo taxonomies
/*add_action('init', 'create_photo_taxonomies');

function create_photo_taxonomies(){
    register_taxonomy('photo_category', 'photo', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Photo Categories'),
            'singular_name' => __('Photo Categories'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Category'),
            'new_item' => __('New Category'),
            'search_items' => __('Search Categories'),
        ),
    ));
}*/