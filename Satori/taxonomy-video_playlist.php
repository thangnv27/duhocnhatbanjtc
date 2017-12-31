<?php
/*
  Template Name: Page Playlist Video
 */
?>
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
            <div class="post-heading">
                <h1><?php single_cat_title(); ?></h1>
            </div>
            <div class="post-entry">
                <div id="vdo"></div>
                <script type="text/javascript">
                    jwplayer("vdo").setup({
                        width: '100%',
                        height: 400,
                        playlist: [
                        <?php while (have_posts()) : the_post(); ?>
                            {
                                image: "<?php get_image_url(); ?>",
                                file: "<?php echo get_post_meta(get_the_ID(), "video_link", true); ?>",
                                title: "<?php the_title(); ?>"
                            },
                        <?php endwhile; ?>
                    ],
                    primary: "flash",
                    listbar: {
                        position: "right",
                        size: '35%' 
                    }
                });
                </script>
                <div class="video-heading">
                    <h3>Danh sách video khác</h3>
                </div>
                <div class="other-video">
                    <?php
                $taxonomy = 'video_playlist';
                $term = get_queried_object();
                $tax_terms = get_terms($taxonomy, array(
                    'orderby' => 'id',
                    'order' => 'DESC',
                    //'number' => 8,
                    'exclude' => array($term->term_id),
                ));
                ?>
                   <?php foreach ($tax_terms as $key => $tax_term) {
                    if ($key%2==0): 
                ?>
                    <div class="item mr0">
                    <?php else : ?>
                    <div class="item">
                    <?php endif; ?>
                    <div class="other-playlist-item">
                            <div class="thumb">
                                <a href="<?php echo esc_attr(get_term_link($tax_term, $taxonomy)); ?>" title="<?php echo $tax_term->name; ?>">
                                    <img src="<?php echo z_taxonomy_image_url($tax_term->term_id); ?>" alt="<?php echo $tax_term->name; ?>" />
                                </a>
                            </div>
                            <div class="video-title">
                                <a href="<?php echo esc_attr(get_term_link($tax_term, $taxonomy)); ?>" title="<?php echo $tax_term->name; ?>"><?php echo $tax_term->name; ?></a>
                            </div>
                    </div>
                </div>
               <?php } ?>
            </div>
                <!------>
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