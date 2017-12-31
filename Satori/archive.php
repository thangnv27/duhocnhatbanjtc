<?php get_header(); ?>
<!-- BEGIN WRAPPER-CONTENT -->
<div id="wrapper-content">
    <!-- BEGIN MAIN -->
    <div id="main">
        <div class="container">

            <div class="breadcrumbs">
                 <?php
                    if (function_exists('bcn_display')) {
                        bcn_display();
                    }
                    ?>
            </div>

            <div class="block archive">
                <h1>
                    <?php single_cat_title(); ?>						
                </h1>
                <?php while (have_posts()) : the_post();  ?>
                <div class="post-<?php the_ID(); ?> post type-post status-publish format-standard hentry category-tin-tuc-du-hoc-nhat category-tin-tuc-su-kien block-item-big" id="post-1223">
                    <h2>
                        <a title="<?php the_permalink(); ?>" href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h2>

                    <div class="block-image">
                        <a title="<?php the_permalink(); ?>" href="<?php the_permalink(); ?>">
                            <img width="142" height="142" alt="<?php the_title(); ?>" src="<?php bloginfo('stylesheet_directory'); ?>/timthumb.php?src=<?php get_image_url(); ?>&w=142&h=142"/>
                        </a>
                    </div>

                    <span class="block-meta">
                        <span class="heading-author">admin</span> 
                        <span class="heading-date"><?php the_time('H:s - d/m/Y'); ?></span>
                    </span>
                    <p><?php the_excerpt(); ?></p>
                    <a class="readmore" title="<?php the_title(); ?>" href="<?php the_permalink(); ?>" rel="nofollow">Chi tiết<span class="block-arrows">»</span></a>
                </div>
                <?php endwhile; ?>
                <?php getpagenavi(); ?>
            </div>
        </div>
    </div>

    <!-- END MAIN -->

    <!-- BEGIN SIDEBAR -->
    <?php get_sidebar(); ?>
    <!-- END SIDEBAR -->			
</div>
<!-- END WRAPPER-CONTENT -->

<?php get_footer(); ?>