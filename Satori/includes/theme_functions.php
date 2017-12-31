<?php
/**
 * 
 * @param string $key a simple string which identifies the fragment.<br /> 
 * Notice that the function adds a prefix to avoid colliding with other transients. <br />
 * You can alter the prefix by editing the function or adding a filter that matches the 'fragmentcacheprefix' tag.
 * @param int $ttl Time to live: a time in seconds for the cache to live. <br />
 * I usually make use of time constants. You can see: http://codex.wordpress.org/Transients_API#Using_Time_Constants<br />
 * For example, DAYINSECONDS is 86400, the number of seconds in a day. <br />
 * This helps those of us who are too lazy for some simple math.
 * @param mixed $function the function which creates the output. This can be anything as the examples in this post show.
 * @return string
 */
function t_fragment_cache($key, $ttl, $function) {
    if (is_user_logged_in()) {
        call_user_func($function);
        return;
    }
    $key = apply_filters('fragment_cache_prefix', 'fragment_cache_') . $key;
    $output = get_transient($key);
    if (empty($output)) {
        ob_start();
        call_user_func($function);
        $output = ob_get_clean();
        set_transient($key, $output, $ttl);
    }
    echo $output;
}
/**
 * Function to upload an image to the media library and set it as the featured image of a post
 * @param string Name of the upload field
 * @param int ID of the post
 * @return int ID of the attachment
 * */
function set_featured_image_width_media_handle($file, $post_id) {
    require_once(ABSPATH . "wp-admin/includes/image.php");
    require_once(ABSPATH . "wp-admin/includes/file.php");
    require_once(ABSPATH . "wp-admin/includes/media.php");
    $attachment_id = media_handle_upload($file, $post_id);
    // Set featured image to post
    update_post_meta($post_id, '_thumbnail_id', $attachment_id);
    $attachment_data = array(
        'ID' => $attachment_id
    );
    wp_update_post($attachment_data);
    return $attachment_id;
}
/**
 * Function to upload an image to the media library and set it as the featured image of a post
 * @param array Array filename and url of the file
 * @param int ID of the post
 * @return int ID of the attachment
 * */
function set_featured_image_width_media_sideload($url, $post_id, $desc = "") {
    require_once(ABSPATH . "wp-admin/includes/image.php");
    require_once(ABSPATH . "wp-admin/includes/file.php");
    require_once(ABSPATH . "wp-admin/includes/media.php");
    
    media_sideload_image($url, $post_id, $desc);
    
    // get the newly uploaded image
    $attachments = get_posts( array(
        'post_type' => 'attachment',
        'number_posts' => 1,
        'post_parent' => $post_id,
        'orderby' => 'post_date',
        'order' => 'DESC',) 
    );
    $attachment_id = $attachments[0]->ID;
    // Set featured image to post
    update_post_meta($post_id, '_thumbnail_id', $attachment_id);
    $attachment_data = array(
        'ID' => $attachment_id
    );
    wp_update_post($attachment_data);
    
    return $attachment_id;
}
/**
 * Function to upload an image to the media library and set it as the featured image of a post
 * @param array File info
 * @param int ID of the post
 * @return int ID of the attachment
 * */
function set_featured_image_width_handle_sideload($file_array, $post_id) {
    require_once(ABSPATH . "wp-admin/includes/image.php");
    require_once(ABSPATH . "wp-admin/includes/file.php");
    require_once(ABSPATH . "wp-admin/includes/media.php");

    // do the validation and storage stuff
    $attachment_id = media_handle_sideload( $file_array, $post_id );

    // Unlink temp file
    @unlink($file_array['tmp_name']);
    
    if ( is_wp_error($attachment_id) ) {
        return $attachment_id;
    }
    // Set featured image to post
    update_post_meta($post_id, '_thumbnail_id', $attachment_id);
    $attachment_data = array(
        'ID' => $attachment_id
    );
    // Update attachment file
    wp_update_post($attachment_data);
    
    return $attachment_id;
}

add_action('login_head', 'custom_login_logo');

function custom_login_logo() {
    echo '<style type="text/css">
        h1 a { background-image:url('.get_option('sitelogo').') !important; }
    </style>';
}

// Enable Links Manager (WP 3.5)
add_filter( 'pre_option_link_manager_enabled', '__return_true' );

/**
 * Create a nicely formatted and more specific title element text for output
 * in head of document, based on current view.
 *
 * @since Twenty Fourteen 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function ppo_wp_title( $title, $sep ) {
	global $paged, $page;

	if ( is_feed() ) {
		return $title;
	}

	// Add the site name.
	$title .= get_bloginfo( 'name' );

	// Add the site description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) ) {
		$title = "$title $sep $site_description";
	}

	// Add a page number if necessary.
	if ( $paged >= 2 || $page >= 2 ) {
		$title = "$title $sep " . sprintf( __( 'Page %s', 'ppo' ), max( $paged, $page ) );
	}

	return $title;
}

add_filter( 'wp_title', 'ppo_wp_title', 10, 2 );

/*----------------------------------------------------------------------------*/
# add a favicon to blog
/*----------------------------------------------------------------------------*/
function add_blog_favicon(){
    $favicon = get_option('favicon');
    if(trim($favicon) == ""){
        echo '<link rel="icon" href="' . get_bloginfo('siteurl') . '/favicon.ico" type="image/x-icon" />\n';
    }else{
        echo '<link rel="icon" href="' . $favicon . '" type="image/x-icon" />' . "\n";
    }
}
add_action('wp_head', 'add_blog_favicon');

/*----------------------------------------------------------------------------*/
# Add Google Analytics to blog
/*----------------------------------------------------------------------------*/
function add_blog_google_analytics(){
    global $shortname;

    $GAID = get_option($shortname . '_gaID');
    if($GAID and $GAID != ''):
        echo <<<HTML
<script type="text/javascript">

    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '$GAID']);
    _gaq.push(['_trackPageview']);
    
    (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();

</script>
HTML;
    endif;
}
add_action('wp_head', 'add_blog_google_analytics');
/* ---------------------------------------------------------------------------- */
# Add Facebook JS SDK
/* ---------------------------------------------------------------------------- */

function add_fb_jssdk() {
    echo <<<HTML
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
HTML;
}

add_action('wp_footer', 'add_fb_jssdk');
/*----------------------------------------------------------------------------*/
# Check current category has children
/*----------------------------------------------------------------------------*/
function category_has_children() {
    global $wpdb;
    $term = get_queried_object();
    $category_children_check = $wpdb->get_results(" SELECT * FROM wp_term_taxonomy WHERE parent = '$term->term_id' ");
    if ($category_children_check) {
        return true;
    } else {
        return false;
    }
}

/*----------------------------------------------------------------------------*/
# Get the current category id if we are on an archive/category page
/*----------------------------------------------------------------------------*/
function getCurrentCatID() {
    global $wp_query;
    if (is_category() || is_single()) {
        $cat_ID = get_query_var('cat');
    }
    return $cat_ID;
}

/*-----------------------------------------------------*\
# Rename menu title via language ID (ZD Multilang)
\*-----------------------------------------------------*/
add_filter('wp_nav_menu_objects', 'add_menu_parent_class');
function add_menu_parent_class($items) {
    global $wpdb;

    if(function_exists('zd_multilang_get_locale')){
        $DefLang = zd_multilang_get_locale();
        $posttrans = "wp_zd_ml_trans";
        foreach ($items as $item) {
            $ID = $item->object_id;
            $query = "SELECT * FROM $posttrans where LanguageID='$DefLang' and post_status = 'published' and ID = $ID";
            $TrPosts = $wpdb->get_row($query);
            if ($TrPosts) {
                $item->title = $TrPosts->post_title;
            }
        }
    }

    return $items;
}

/* ----------------------------------------------------------------------------------- */
# Redefine user notification function
/* ----------------------------------------------------------------------------------- */
if (!function_exists('custom_wp_new_user_notification')) {
    function custom_wp_new_user_notification($user_id, $plaintext_pass = '') {
        $user = new WP_User($user_id);

        $user_login = $user->user_login;
        $user_email = $user->user_email;

        $message = sprintf(__('New user registration on %s:'), get_option('blogname')) . "\r\n\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
        $message .= sprintf(__('E-mail: %s'), $user_email) . "\r\n";

        @wp_mail(
                get_option('admin_email'), sprintf(__('[%s] New User Registration'), get_option('blogname')), $message
        );

        if (empty($plaintext_pass))
            return;
        
        $login_url = wp_login_url();
        
        $message = sprintf(__('Hi %s,'), $user->display_name) . "\r\n\r\n";
        $message .= sprintf(__("Welcome to %s! Here's how to log in:"), get_option('blogname')) . "\r\n\r\n";
        $message .= ($login_url == "") ? wp_login_url() : $login_url . "\r\n";
        $message .= sprintf(__('Username: %s'), $user_login) . "\r\n";
        $message .= sprintf(__('Password: %s'), $plaintext_pass) . "\r\n\r\n";

        @wp_mail(
                $user_email, sprintf(__('[%s] Your username and password'), get_option('blogname')), $message
        );
    }
}

if(!function_exists('set_html_content_type')){
    function set_html_content_type() {
        return 'text/html';
    }
}

/* GET THUMBNAIL URL */
function get_image_url() {
    $image_id = get_post_thumbnail_id();
    $image_url = wp_get_attachment_image_src($image_id, 'full');
    $image_url = $image_url[0];
    if($image_url != ""){
        echo $image_url;
    }else{
        bloginfo( 'stylesheet_directory' );
        echo "/images/no_image_available.jpg";
    }
}
/**
 * Get post thumbnail url
 * 
 * @param integer $post_id
 * @param type $size
 * @return string
 */
function get_post_thumbnail_url($post_id, $size){
    return wp_get_attachment_url( get_post_thumbnail_id($post_id, $size) );
}

/**
 * Rewrite URL
 * @param string $lang_code Example: vn, en...
 * @param bool $show TRUE or FALSE
 * @return string
 */
function ppo_multilang_permalink($lang_code, $show = false) {
    $uri = getCurrentRquestUrl();
    $siteurl = get_bloginfo('siteurl');
    $end = substr($uri, strlen($siteurl));
    if (!isset($_GET['lang'])) {
        $uri = $siteurl . "/" . $lang_code . $end;
    }
    if($show){
        echo $uri;
    }
    return $uri;
}

/* PAGE NAVIGATION */
function getpagenavi($arg = null) {
?>
    <div class="paging">
<?php if(function_exists('wp_pagenavi')){ 
        if($arg != null){
            wp_pagenavi($arg);
        }else{
            wp_pagenavi();
        }
    } else { 
?>
    <div><div class="inline"><?php previous_posts_link('« Previous') ?></div><div class="inline"><?php next_posts_link('Next »') ?></div></div>
<?php } ?>
    </div>
<?php
}
/* END PAGE NAVIGATION */