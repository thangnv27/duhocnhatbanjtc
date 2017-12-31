<?php

/**
 * Partners Menu Page
 */

# Custom partner post type
add_action('init', 'create_partner_post_type');

function create_partner_post_type(){
    register_post_type('partner', array(
        'labels' => array(
            'name' => __('Đối tác'),
            'singular_name' => __('Đối tác'),
            'add_new' => __('Add new'),
            'add_new_item' => __('Add new Partner'),
            'new_item' => __('New Partner'),
            'edit' => __('Edit'),
            'edit_item' => __('Edit Partner'),
            'view' => __('View Partner'),
            'view_item' => __('View Partner'),
            'search_items' => __('Search Partners'),
            'not_found' => __('No Partner found'),
            'not_found_in_trash' => __('No Partner found in trash'),
        ),
        'public' => true,
        'show_ui' => true,
        'publicy_queryable' => true,
        'exclude_from_search' => false,
        'menu_position' => 5,
        'hierarchical' => false,
        'query_var' => true,
        'supports' => array(
            'title', 
//            'custom-fields', 'comments','editor', 'thumbnail','excerpt', 'author',
        ),
        'rewrite' => array('slug' => 'partner', 'with_front' => false),
        'can_export' => true,
        'description' => __('Partner description here.')
    ));
}

//# Custom partner taxonomies
//add_action('init', 'create_partner_taxonomies');
//
//function create_partner_taxonomies(){
//    register_taxonomy('partner_category', 'partner', array(
//        'hierarchical' => true,
//        'labels' => array(
//            'name' => __('Partner Categories'),
//            'singular_name' => __('Partner Categories'),
//            'add_new' => __('Add New'),
//            'add_new_item' => __('Add New Category'),
//            'new_item' => __('New Category'),
//            'search_items' => __('Search Categories'),
//        ),
//    ));
//}


# partner meta box
$partner_meta_box = array(
    'id' => 'partner-meta-box',
    'title' => 'Thông tin logo',
    'page' => 'partner',
    'context' => 'normal',
    'priority' => 'high',
    'fields' => array(
        array(
            'name' => 'Đường dẫn ảnh Logo',
            'desc' => '',
            'id' => 'partner_image',
            'type' => 'text',
            'std' => '',
        ),
        array(
            'name' => 'Đường dẫn đến website',
            'desc' => '',
            'id' => 'partner_link',
            'type' => 'text',
            'std' => '',
        ),
));

// Add partner meta box
if(is_admin()){
    add_action('admin_menu', 'partner_add_box');
    add_action('save_post', 'partner_add_box');
    add_action('save_post', 'partner_save_data');
}

function partner_add_box(){
    global $partner_meta_box;
    add_meta_box($partner_meta_box['id'], $partner_meta_box['title'], 'partner_show_box', $partner_meta_box['page'], $partner_meta_box['context'], $partner_meta_box['priority']);
}

// Callback function to show fields in partner meta box
function partner_show_box() {
    // Use nonce for verification
    global $partner_meta_box, $post;

    // Use nonce for verification
    echo '<input type="hidden" name="partner_meta_box_nonce" value="', wp_create_nonce(basename(__FILE__)), '" />';

    echo '<table width="100%">';
    foreach ($partner_meta_box['fields'] as $field) {
        // get current post meta data
        $meta = get_post_meta($post->ID, $field['id'], true);

        echo '<tr>',
        '<th style="text-align: left; width: 20%;"><label for="', $field['id'], '">', $field['name'], '</label></th>',
        '<td>';
        switch ($field['type']) {
            case 'text':
                if($field['id'] == 'partner_image'){
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', htmlspecialchars($meta) ? htmlspecialchars($meta) : htmlspecialchars($field['std']), '" size="30" style="width:88%" />';
                    echo '<input type="button" id="upload_partner_image_button" class="button button-upload" value="Upload" />', '<br /><span class="description">', $field['desc'], '</span>';
                }else{
                    echo '<input type="text" name="', $field['id'], '" id="', $field['id'], '" value="', htmlspecialchars($meta) ? htmlspecialchars($meta) : htmlspecialchars($field['std']), '" size="30" style="width:88%" />', '<br /><span class="description">', $field['desc'], '</span>';
                }
                break;
            case 'textarea':
                echo '<textarea name="', $field['id'], '" id="', $field['id'], '" cols="60" rows="4" style="width:97%">', $meta ? $meta : $field['std'], '</textarea>', '<br />', $field['desc'];
                break;
            case 'select':
                echo '<select name="', $field['id'], '" id="', $field['id'], '">';
                foreach ($field['options'] as $option) {
                    echo '<option value="', $option , '" ', $meta == $option ? ' selected="selected"' : '', '>', $option, '</option>';
                }
                echo '</select>';
                break;
            case 'radio':
                foreach ($field['options'] as $key => $option) {
                    echo '<input type="radio" name="', $field['id'], '" value="', $key, '"', $meta == $key ? ' checked="checked"' : '', ' /> ', $option , ' ';
                }
                break;
            case 'checkbox':
                echo '<input type="checkbox" name="', $field['id'], '" id="', $field['id'], '"', $meta ? ' checked="checked"' : '', ' />';
                break;
        }
        echo '<td>',
        '</tr>';
    }

    echo '</table>';
}

// Save data from partner meta box
function partner_save_data($post_id) {
    global $partner_meta_box;
       // verify nonce
    if (!wp_verify_nonce($_POST['partner_meta_box_nonce'], basename(__FILE__))) {
        return $post_id;
    }
    // check autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    // check permissions
    if ('page' == $_POST['post_type']) {
        if (!current_user_can('edit_page', $post_id)) {
            return $post_id;
        }
    } elseif (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    foreach ($partner_meta_box['fields'] as $field) {
        $old = get_post_meta($post_id, $field['id'], true);
        $new = $_POST[$field['id']];
        if ($new && $new != $old) {
            update_post_meta($post_id, $field['id'], $new);
        } elseif ('' == $new && $old) {
            delete_post_meta($post_id, $field['id'], $old);
        }
    }
}
