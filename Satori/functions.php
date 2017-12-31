<?php

ob_start();
/* ----------------------------------------------------------------------------------- */
# Set default timezone
/* ----------------------------------------------------------------------------------- */
date_default_timezone_set('Asia/Ho_Chi_Minh');

$themename = "PPO";
$shortname = "ppo";

if(!defined('THEME_NAME')) define ('THEME_NAME', "PPO");
if(!defined('SHORT_NAME')) define ('SHORT_NAME', "ppo");
if(!defined('MENU_NAME')) define ('MENU_NAME', SHORT_NAME . "_settings");

include 'includes/HttpFoundation/Request.php';
include 'includes/HttpFoundation/Response.php';
include 'includes/HttpFoundation/Session.php';
include 'includes/custom.php';
include 'includes/theme_functions.php';
include 'includes/common-scripts.php';
include 'includes/meta-box.php';
include 'includes/theme_settings.php';
include 'includes/home-options.php';
include 'includes/post_type_no_slug.php';
include 'includes/partner.php';
include 'includes/support-online.php';
include 'includes/photo.php';
include 'includes/video.php';

if(is_admin()){
    include 'includes/postMeta.php';
    include 'includes/slider.php';
    include 'includes/userguide.php';
    
    add_action( 'admin_menu', 'custom_remove_menu_pages' );
}else{
    include 'includes/social-post-link.php';
}

function custom_remove_menu_pages() {
    remove_menu_page('edit-comments.php');
}
    
/* ----------------------------------------------------------------------------------- */
# Post Thumbinals
/* ----------------------------------------------------------------------------------- */
if (function_exists('add_theme_support')) {
    add_theme_support('post-thumbnails');
}

/* ----------------------------------------------------------------------------------- */
# Register Sidebar
/* ----------------------------------------------------------------------------------- */
register_sidebar(array(
    'id' => __('sidebar'),
    'name' => __('Sidebar'),
    'before_widget' => '<div class="widget"><div id="%1$s">',
    'after_widget' => '</div></div>',
    'before_title' => '<div class="widget-title hd">',
    'after_title' => '</div>',
));
register_sidebar(array(
    'id' => __('ad_left'),
    'name' => __('Quảng cáo bên trái'),
));
register_sidebar(array(
    'id' => __('ad_right'),
    'name' => __('Quảng cáo bên phải'),
));
/* ----------------------------------------------------------------------------------- */
# Register menu location
/* ----------------------------------------------------------------------------------- */
register_nav_menus(array(
    'main_menu' => 'Primary Location',
    'cate_menu' => 'Menu Chuyên mục',
    'top_menu' => 'Menu Top'
));

class Menu_With_Description extends Walker_Nav_Menu {
	function start_el(&$output, $item, $depth, $args) {
		global $wp_query;
		$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
		
		$class_names = $value = '';

		$classes = empty( $item->classes ) ? array() : (array) $item->classes;

		$class_names = join( ' ', apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item ) );
		$class_names = ' class="' . esc_attr( $class_names ) . '"';

		$output .= $indent . '<li id="menu-item-'. $item->ID . '"' . $value . $class_names .'>';

		$attributes = ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) .'"' : '';
		$attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) .'"' : '';
		$attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) .'"' : '';
		$attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) .'"' : '';

		$item_output = $args->before;
		$item_output .= '<a'. $attributes .'>';
		$item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
		$item_output .= '<br /><span class="sub">' . $item->description . '</span>';
		$item_output .= '</a>';
		$item_output .= $args->after;

		$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
	}
}


/**
 * Add wysiwyg to custom field textarea
 */
function admin_add_wysiwyg_custom_field_textarea() {
    ?>
    <script type="text/javascript">/* <![CDATA[ */
        jQuery(function($){
            var i=1;
            /*$('textarea').each(function(e){
                var id = $(this).attr('id');
                if(id.lastIndexOf('meta', id) != -1){
                    tinyMCE.execCommand('mceAddControl', false, id);
                    $("#newmeta-submit").click(function(){
                        tinyMCE.triggerSave();
                    });
                }
            });*/
            
            var arr = new Array('views', 'method_register');
            if($("#courses-meta-box").length > 0){
                $("#courses-meta-box input[type='text']").each(function(){
                    arr.push($(this).attr('name'));
                });
            }
            if($("#events-meta-box").length > 0){
                $("#events-meta-box input[type='text']").each(function(){
                    arr.push($(this).attr('name'));
                });
            }
            
            $("#list-table thead tr th.left").removeClass('left').next().remove();
            $("#the-list tr[id^='meta-']").each(function(){
                if($.inArray($(this).children('td.left:first').children('input:first').val(), arr) < 0 ){
                    $(this).children('td.left:first').children('input:first').after($(this).children('td.left:first').next().html());
                    $(this).children('td.left:first').removeClass('left').next().remove();
                }else{
                    $(this).hide();
                }
            });
            
            $(window).load(function(){
                $("#newmetaleft").parent().after('<tr><td colspan="2">' + $("#newmetaleft").next().html() + '</td></tr>');
                $("#newmetaleft").next().remove();
                $('textarea').each(function(e){
                    var id = $(this).attr('id');
                    if(id.lastIndexOf('meta', id) != -1){
                        tinyMCE.execCommand('mceAddControl', false, id);
                        $("#newmeta-submit").click(function(){
                            tinyMCE.triggerSave();
                        });
                    }
                });
            });
        });
        /* ]]> */
    </script>
<?php
}
add_action('admin_print_footer_scripts', 'admin_add_wysiwyg_custom_field_textarea', 99);

