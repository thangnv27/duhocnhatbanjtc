<?php
/**
 * Custom video post type
 */

add_action('init', 'create_video_post_type');

function create_video_post_type(){
    register_post_type('video', array(
        'labels' => array(
            'name' => __('Videos'),
            'singular_name' => __('Videos'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Video'),
            'new_item' => __('New Video'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Video'),
            'view' => __('View Video'),
            'view_item' => __('View Video'),
            'search_items' => __('Search Videos'),
            'not_found' => __('No Video found'),
            'not_found_in_trash' => __('No Video found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 'author', 'excerpt', 'thumbnail',
            //'custom-fields', 'comments','editor',
        ),
        'rewrite' => array('slug' => 'video', 'with_front' => false),
        'can_export' => true,
        'description' => __('Video description here.')
    ));
}

# Custom video taxonomies
add_action('init', 'create_video_taxonomies');

function create_video_taxonomies(){
    register_taxonomy('video_playlist', 'video', array(
        'hierarchical' => true,
        'labels' => array(
            'name' => __('Playlist'),
            'singular_name' => __('Playlist'),
            'add_new' => __('Add New'),
            'add_new_item' => __('Add New Playlist'),
            'new_item' => __('New Playlist'),
            'search_items' => __('Search Playlist'),
        ),
    ));
}
// Add video meta box
if(is_admin()){
    add_action('admin_menu', 'video_add_box');
    add_action('save_post', 'video_add_box');
    add_action('save_post', 'video_save_data');
}

# video meta box
$video_meta_box = array(
    'id' => 'video-meta-box',
    'title' => 'Thêm youtube video',
    'page' => 'video',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Đường dẫn video youtube',
            'desc' => 'Đường dẫn video youtube copy trên trình duyệt',
            'id' => 'video_link',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Sắp xếp',
            'desc' => 'Thứ tự hiển thị video trong playlist',
            'id' => 'video_order',
            'type' => 'text',
            'std' => '',
        ),
));


function video_add_box(){
    global $video_meta_box;
    add_meta_box($video_meta_box['id'], $video_meta_box['title'], 'video_show_box', $video_meta_box['page'], $video_meta_box['context'], $video_meta_box['priority']);
}

// Callback function to show fields in video meta box
function video_show_box() {
    // Use nonce for verification
    global $video_meta_box, $post;

    custom_output_meta_box($video_meta_box, $post);
}

// Save data from video meta box
function video_save_data($post_id) {
    global $video_meta_box;
    custom_save_meta_box($video_meta_box, $post_id);
}