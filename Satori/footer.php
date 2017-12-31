<div id="wrapper-footer">
    <div class="main">
        <div id="footer">

            <ul id="partner">
                <?php
                query_posts(array(
                    'post_type' => 'partner',
                    'posts_per_page' => -1,
                ));
                while (have_posts()) : the_post();
                    ?>
                    <li>
                        <a href="<?php echo get_post_meta(get_the_ID(), "partner_link", true); ?>" title="<?php the_title(); ?>">
                            <img src="<?php echo get_post_meta(get_the_ID(), "partner_image", true); ?>" alt="<?php the_title(); ?>" />
                        </a>
                    </li>
                <?php endwhile; ?>
                <?php wp_reset_query(); ?>
            </ul>
            <script type="text/javascript">
                $(function() {
                    $('#partner').jcarousel({
                        auto: 2,
                        wrap: 'circular',
                        scroll: 2
                    });
                });
            </script>
        </div>
    </div>
</div>
<div class="bottom-footer">
    <div class="main">
        <div class="widget">
            <div class="widget-container r_box widget_nav_menu" id="nav_menu-2">
                <div class="widget-title">Văn phòng Bắc Giang</div>
                <div><?php echo stripslashes(get_settings('footer_col1')); ?></div>
            </div>
        </div>
        <div class="widget">
            <div class="widget-container r_box widget_nav_menu" id="nav_menu-2">
                <div class="widget-title">Văn Phòng Việt Trì - Phú Thọ</div>
                <div><?php //echo stripslashes(get_settings('footer_col2')); ?></div>
            </div>
        </div>
        <div class="widget">
            <div class="widget-container r_box widget_nav_menu" id="nav_menu-2">
                <div class="widget-title">Văn Phòng Tokyo - Nhật Bản</div>
                <div><?php echo stripslashes(get_settings('footer_col3')); ?></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="copyright">
            Copyright &copy; <?php bloginfo('name'); ?>. All rights reserved. Powered by <a href="http://ppo.vn" title="Công ty TNHH PPO Việt Nam - Thiết kế web chuyên nghiệp">PPO.VN</a>.
            <!-- BEGIN HEADER-TOP -->
            <!-- END HEADER-TOP -->
        </div>
        <div style="clear:both;"></div>
    </div>
</div>

<div id="footer-bottom">
    <p class="right"><a rel="nofollow" href='#top' class='backToTop'>
            <img src="<?php bloginfo('stylesheet_directory'); ?>/images/back_to_top.png" rel="nofollow"/></a>
    </p>
</div>
<div style="top: 0px; left: 57.5px; position: fixed;" id="ad_left">
    <?php if (function_exists('dynamic_sidebar')) {
        dynamic_sidebar('ad_left');
    } ?>
</div>

<div style="top: 0px; right: 54.5px; position: fixed;" id="ad_right">
<?php if (function_exists('dynamic_sidebar')) {
    dynamic_sidebar('ad_right');
} ?>
</div>
<script type="text/javascript">
    jQuery(document).ready(function(){
        adFloat.register();
    });
    var adFloat = {
        register: function() {
            jQuery(window).resize(adFloat.check);
            jQuery(window).ready(adFloat.check);
        },
        check: function() {
            var windowWidth = jQuery(window).width();
            var adWidth = 100;
            var posLeft = (windowWidth - 1024)/2 - adWidth - 5;
            var posRight = (windowWidth - 1024)/2 - adWidth - 8;
            var isIE6 = /msie|MSIE 6/.test(navigator.userAgent);
            var posTop = 580;
            if(windowWidth < 1000){
                jQuery("#ad_left, #ad_right").hide();
            } else {
                jQuery("#ad_left, #ad_right").show();
                jQuery("#ad_left").css({ top: posTop , left: posLeft, position: (isIE6 ? "absolute" : "fixed")});
                jQuery("#ad_right").css({ top: posTop , right: posRight, position: (isIE6 ? "absolute" : "fixed")});
            }
            jQuery(window).scroll(function() {
                if(jQuery(window).scrollTop() > posTop) {
                    jQuery("#ad_left, #ad_right").css({top: 0});
                }
                else {
                    jQuery("#ad_left, #ad_right").css({top: posTop - jQuery(window).scrollTop()});
                }
            });
        }
    }; 
</script>

</div>
<!-- END WRAPPER -->
<?php wp_footer();?>
<script type='text/javascript'>window._sbzq || function (e) {
    e._sbzq = [];
    var t = e._sbzq;
    t.push(["_setAccount", <?php echo get_option("ppo_subizID"); ?>]);
    var n = e.location.protocol == "https:" ? "https:" : "http:";
    var r = document.createElement("script");
    r.type = "text/javascript";
    r.async = true;
    r.src = n + "//static.subiz.com/public/js/loader.js";
    var i = document.getElementsByTagName("script")[0];
    i.parentNode.insertBefore(r, i)
}(window);</script>
</body>
</html>