<?php global  $shortname; ?>
<div id="sidebar">
    <div class="widget hotline">
        <div class="textwidget">
            <h3 class="widget-title support">Hỗ trợ trực tuyến</h3>
            <h4>Hotline: <?php echo get_option($shortname . "_hotline"); ?></h4>
            <h5>Chuyên viên tư vấn</h5>
            <?php
            $loop = new WP_Query(array(
                        'post_type' => 'support_online',
                        'orderby' => 'meta_value_num',
                        'order' => 'ASC',
                        'meta_key' => 'so_order',
                    ));
            while ($loop->have_posts()) : $loop->the_post();
            ?>
            <p>
                <span class="online">
                    <a rel="nofollow" href="ymsgr:sendim?<?php echo get_post_meta(get_the_ID(), "so_yahoo_id", true); ?>">
                        <img border="0" src="http://opi.yahoo.com/online?u=<?php echo get_post_meta(get_the_ID(), "so_yahoo_id", true); ?>&m=g&t=5" alt="lien he tu van du hoc nhat" />
                    </a>
                </span>
                <b><?php echo get_post_meta(get_the_ID(), "so_name", true); ?></b>: 
                <span><?php echo get_post_meta(get_the_ID(), "so_phone", true); ?></span>
                <br/>
                <span class="online">
                    <a href="skype:<?php echo get_post_meta(get_the_ID(), "so_skype_id", true); ?>?call" rel="nofollow">
                        <img width="16" height="16" alt="tu van du hoc nhat" style="border: none;" src="http://mystatus.skype.com/smallicon/<?php echo get_post_meta(get_the_ID(), "so_skype_id", true); ?>" />
                    </a>
                </span>
                <?php echo get_post_meta(get_the_ID(), "so_email", true); ?>
            </p>
            <?php endwhile; ?>
        </div>
    </div>
    <div class="widget">
        <?php echo stripslashes(get_option($shortname . "_video")); ?>
    </div>
    <?php
    global $wp_query;
    query_posts( array ( 
        'post_type' => 'post', 
        'meta_query' => array(
            array(
                'key' => 'is_most',
                'value' => '1',
            )
        ),
        'posts_per_page' => -1,
    ));
    if($wp_query->found_posts > 0):
    ?>
    <div class="widget">
        <h3 class="widget-title">Tin HOT</h3>
        <div class="menu-danh-muc-container">
            <ul>
                <?php while (have_posts()) : the_post(); ?>
                <li><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile;?>
            </ul>
        </div>
    </div>
    <?php 
    endif; // end found Top hot
    wp_reset_query(); 
    
    if ( function_exists('dynamic_sidebar') ) { dynamic_sidebar('sidebar'); } 
    ?>
    
    <div class="tygia"><?php include 'box-tygia.php'; ?></div>
    
    <div class="widget mt20">
        <div class="fb-like-box" data-href="<?php echo get_option(SHORT_NAME . "_fbURL"); ?>" data-width="220px" data-height="233px" data-colorscheme="light" data-show-faces="true" data-header="false" data-stream="false" data-show-border="true"></div>
    </div>
</div>