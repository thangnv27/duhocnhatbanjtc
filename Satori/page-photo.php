<?php
/*
  Template Name: Mẫu trang photo
 */
?>
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
            </div>
            <div class="post-entry">
            <?php
                    $albums = new WP_Query(array(
                                'post_type' => 'photo',
                                'post_status' => 'publish',
                                'posts_per_page' => 9,
                            ));
                    $counter = 0;
                    if ($albums->post_count > 0):
                        while ($albums->have_posts()) : $albums->the_post();
                            $counter++;

                            $args = array(
                                'orderby' => 'menu_order',
                                'post_type' => 'attachment',
                                'post_parent' => get_the_ID(),
                                'post_mime_type' => 'image',
                                'post_status' => null,
                                'posts_per_page' => -1,
                                'exclude' => get_post_thumbnail_id()
                            );
                            $attachments = get_posts($args);
                            $countImg = count($attachments);
                            ?>
                            <?php if ($counter % 3 == 0) : ?>
                                <div class="photos mr0">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php get_image_url(); ?>" alt="<?php the_title(); ?>" /></a>
                                    <div class="photos-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?> (<?php echo $countImg ?> ảnh)</a></div>
                                </div>
                            <?php else : ?>
                                <div class="photos">
                                    <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><img src="<?php get_image_url(); ?>" alt="<?php the_title(); ?>" /></a>
                                    <div class="photos-title"><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?> (<?php echo $countImg ?> ảnh)</a></div>
                                </div>
                            <?php
                            endif;
                        endwhile;
                    endif;
                    ?>
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