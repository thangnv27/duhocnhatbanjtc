<?php

/**
 * @author Ngo Van Thang <ngothangit@gmail.com>
 * 
 * Custom post type permalinks without the slug
 */

add_action('admin_menu', 'add_cpt_settings_page');

function add_cpt_settings_page(){
    global $menuname;
    
    add_submenu_page($menuname, //Menu ID – Defines the unique id of the menu that we want to link our submenu to. 
                                    //To link our submenu to a custom post type page we must specify - 
                                    //edit.php?post_type=my_post_type
            __('Post type Options'), // Page title
            __('Post type Options'), // Menu title
            'edit_themes', // Capability - see: http://codex.wordpress.org/Roles_and_Capabilities#Capabilities
            'cpt_options', // Submenu ID – Unique id of the submenu.
            'cpt_options_page' // render output function
        );
    
    if ($_GET['page'] == 'cpt_options') {
        if (isset($_REQUEST['action']) and 'save' == $_REQUEST['action']) {
            $post_types = getRequest("ppo_cpt_slug");
            if(is_array($post_types)){
                update_option("cpt_without_slug", json_encode($post_types));
            }else{
                delete_option("cpt_without_slug");
            }
            header("Location: {$_SERVER['REQUEST_URI']}&saved=true");
            die();
        } 
    }
}
/**
 * Custom post type settings ouput
 * 
 * @global string $themename
 */
function cpt_options_page() {
?>
    <div class="wrap">
        <div class="opwrap" style="margin-top: 10px;" >
            <div class="icon32" id="icon-options-general"></div>
            <h2 class="wraphead">Post type Options</h2>
            <?php
            if (isset($_REQUEST['saved']))
                echo '<div id="message" class="updated fade"><p><strong>Post type options saved.</strong></p></div>';
            ?>
            <form method="post">
                <h3>Post Type without base slug for Permalinks</h3>
                <div>
                    <?php
                    $post_types = get_post_types();
                    foreach ($post_types as $post_type) {
                        if(in_array($post_type, array('post', 'page'))){
                            echo <<<HTML
<div>
    <input type="checkbox" name="ppo_cpt_slug[]" value="{$post_type}" id="{$post_type}" checked="checked" disabled="disabled" />
    <label for="{$post_type}">{$post_type}</label>
</div>
HTML;
                        }elseif(in_array($post_type, ppo_get_cpt_without_slug())){
                            echo <<<HTML
<div>
    <input type="checkbox" name="ppo_cpt_slug[]" value="{$post_type}" id="{$post_type}" checked="checked" />
    <label for="{$post_type}">{$post_type}</label>
</div>
HTML;
                        }else{
                            echo <<<HTML
<div>
    <input type="checkbox" name="ppo_cpt_slug[]" value="{$post_type}" id="{$post_type}" />
    <label for="{$post_type}">{$post_type}</label>
</div>
HTML;
                        }
                    }
                    ?>
                </div>
                <div class="submit">
                    <input name="save" type="submit" value="Save changes" class="button button-large button-primary" />
                    <input type="hidden" name="action" value="save" />
                </div>
            </form>
        </div>
    </div>
<?php
}
function ppo_get_cpt_without_slug(){
    $post_types = array();
    if(get_option("cpt_without_slug") != ""){
        $post_types = json_decode(get_option("cpt_without_slug"));
    }
    return $post_types;
}
/**
 * Remove the slug from published post permalinks
 */
function ppo_remove_cpt_slug($post_link, $post, $leavename) {
    if (!in_array($post->post_type, ppo_get_cpt_without_slug()) || 'publish' != $post->post_status)
        return $post_link;

    $post_link = str_replace('/' . $post->post_type . '/', '/', $post_link);

    return $post_link;
}

add_filter('post_type_link', 'ppo_remove_cpt_slug', 10, 3);

/**
 * Some hackery to have WordPress match postname to any of our public post types
 * All of our public post types can have /post-name/ as the slug, so they better be unique across all posts
 * Typically core only accounts for posts and pages where the slug is /post-name/
 */
function ppo_parse_request_tricksy($query) {
    // Only noop the main query
    if (!$query->is_main_query())
        return;

    // Only noop our very specific rewrite rule match
    if (2 != count($query->query)
            || !isset($query->query['page']))
        return;

    // 'name' will be set if post permalinks are just post_name, otherwise the page rule will match
    if (!empty($query->query['name'])){
        $post_types = array_merge(array('post', 'page',), ppo_get_cpt_without_slug());
        $query->set('post_type', $post_types);
    }
}

add_action('pre_get_posts', 'ppo_parse_request_tricksy');