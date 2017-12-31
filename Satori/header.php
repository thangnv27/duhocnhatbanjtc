<!DOCTYPE html>
<html lang="vi" prefix="og: http://ogp.me/ns#">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php bloginfo('charset'); ?>" />
        <title><?php wp_title('|', true, 'right'); ?></title>
        <meta name="keywords" content="<?php echo get_option('keywords_meta') ?>" />
        <?php if(is_home()): ?>
        <meta name="description" content="<?php echo get_option('description_meta') ?>" />
        <?php endif; ?>
        <link rel="shortcut icon" href="<?php echo get_option('favicon'); ?>" />
        <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo('stylesheet_url'); ?>" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/jquery.lightbox-0.5.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="<?php bloginfo('stylesheet_directory'); ?>/css/common.css"/>
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

        <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery-1.9.1.min.js" ></script>
        <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.lightbox-0.5.js" ></script>
        <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jwplayer.js" ></script>
        <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.jcarousel.min.js" ></script>
        <script type="text/javascript" src="<?php bloginfo('stylesheet_directory'); ?>/js/jquery.bxslider.min.js"></script>
        <script>
            var siteUrl = "<?php bloginfo('siteurl'); ?>";
            var themeUrl = "<?php bloginfo('stylesheet_directory'); ?>";
            var ajaxurl = siteUrl + '/wp-admin/admin-ajax.php';
            jwplayer.key="58TBujyyCUP+cEmwMmC6hv6KhP7bJJgI//VkMU65FYnU09bZUz+BbVB4+5L58ZCY";
        </script>
        <?php wp_head(); ?>
    </head>
    <body>
        <!--<div id="fb-root"></div>-->
        <script>(function(d, s, id) {
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) return;
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/vi_VN/all.js#xfbml=1";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <a name='top'></a>
        <!-- BEGIN WRAPPER -->
        <div id="wrapper">

            <!-- BEGIN HEADER -->
            <div id="header">			
                <div class="main">

                    <!-- BEGIN HEADER-MIDDLE -->
                    <div id="header-middle">
                        <!-- BEGIN WRAPPER-NAVIGATION -->
                        <div id="wrapper-navigation">
                            <div id="navigation">
                                <div class="menu-top-menu-container">
                                    <?php
                                    wp_nav_menu(array(
                                        'theme_location' => 'top_menu',
                                        'menu_class' => 'menu',
                                        'menu_id' => 'menu-top-menu'
                                    ));
                                    ?>
                                </div>
                            </div>
                        </div>
                        <!-- END WRAPPER-NAVIGATION -->

                        <div class="search">			
                            <div class="textwidget">
                                <style type="text/css">
                                    .gsc-control-cse {
                                        padding: 0;
                                    }
                                </style>
                                <script>
                                (function() {
                                    var cx = '002476649678555872890:_ns_1yf-oy0';
                                    var gcse = document.createElement('script');
                                    gcse.type = 'text/javascript';
                                    gcse.async = true;
                                    gcse.src = (document.location.protocol == 'https:' ? 'https:' : 'http:') +
                                        '//www.google.com/cse/cse.js?cx=' + cx;
                                    var s = document.getElementsByTagName('script')[0];
                                    s.parentNode.insertBefore(gcse, s);
                                })();
                                </script>
                                <gcse:search></gcse:search>
                            </div>
                        </div>
                    </div>
                    <!-- END HEADER-MIDDLE -->

                    <!--Logo-->
                    <div id="logo">

                        <a href='<?php bloginfo('siteurl'); ?>' class="logo">
                            <img src="<?php echo get_option('sitelogo'); ?>" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" />
                        </a>
                        <div class="menu-main-menu-container">
                            <?php
                            $walker = new Menu_With_Description;
                            wp_nav_menu(array(
                                'theme_location' => 'main_menu',
                                'menu_class' => 'menu',
                                'walker' => $walker,
                                'menu_id' => 'menu-main-menu'
                            ));
                            ?>
                        </div>
                    </div>
                </div>	
            </div>

            <div class="home_banner">
                <?php
                $loop = new WP_Query(array('post_type' => 'slider', 'orderby' => 'meta_value', 'meta_key' => 'slide_order', 'order' => 'ASC'));
                if ($loop->post_count > 0) :
                    ?>
                    <div class="real_w">
                        <ul id="slider-top">
                            <?php while ($loop->have_posts()) : $loop->the_post(); ?> 
                                <li>
                                    <a href="<?php echo get_post_meta(get_the_ID(), "slide_link", true); ?>" title="<?php the_title(); ?>">
                                        <img src="<?php echo get_post_meta(get_the_ID(), "slide_img", true); ?>" alt="<?php the_title(); ?>" />
                                    </a>
                                </li>
                            <?php endwhile; ?>
                        </ul>
                        <div class="clrb"></div>
                    </div>
                <?php endif; ?>
                <?php wp_reset_query(); ?>
            </div>

            <script type="text/javascript">
            if($("ul#slider-top li").length > 1){
                $('#slider-top').bxSlider({
                    nextText: '',
                    prevText: '',
                    pager: false,
                    mode: 'fade',
                    auto: true,
                    controls:false
                });
            }
            </script>
            <!-- end:SLIDE TOP -->
