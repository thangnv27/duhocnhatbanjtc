<?php get_header(); ?>
<!-- BEGIN WRAPPER-CONTENT -->
<div id="wrapper-content">
    <!-- BEGIN MAIN -->
    <div id="main">
        <div class="container">
            <?php while (have_posts()) : the_post(); ?>
            <div class="breadcrumbs">
                    <?php
                    if (function_exists('bcn_display')) {
                        bcn_display();
                    }
                    ?>
            </div>
            <div class="post-heading">
                <h1><?php the_title(); ?></h1>
                <span class="heading-author">
                    <?php the_author(); ?>
                </span> 
                <span class="heading-date">
                    <?php the_time('d/m/Y'); ?>
                </span>
            </div>
            <div class="post-entry">
            <?php the_content(); ?>
            </div>
            <div class="comment_box" id="comment_box">
                <h2>Bình luận</h2>
                <div class="comment_box_ct">
                    <div class="fb-comments" data-href="<?php echo getCurrentRquestUrl(); ?>" data-width="690" data-num-posts="10"></div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <!-- END MAIN -->

    <!-- BEGIN SIDEBAR -->
    <?php get_sidebar(); ?>
    <!-- END SIDEBAR -->			
</div>
<!-- END WRAPPER-CONTENT -->

<?php get_footer(); ?>