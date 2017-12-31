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
            <script type="text/javascript">
                    $(function() {
                        $('.item-img img').each(function(){
                            $(this).attr('href', $(this).attr('src')).css({
                                'cursor': 'pointer'
                            });
                        }).lightBox({
                            imageLoading: themeUrl + '/images/lightbox-ico-loading.gif',
                            imageBtnPrev: themeUrl + '/images/lightbox-btn-prev.gif',
                            imageBtnNext: themeUrl + '/images/lightbox-btn-next.gif',
                            imageBtnClose: themeUrl + '/images/lightbox-btn-close.gif',
                            imageBlank: themeUrl + '/images/lightbox-blank.gif'
                        });
                    });
                </script>
                 <?php
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
                        $counter = 0;
                        if ($attachments) :
                            foreach ($attachments as $attachment):
                                $counter++;
                                ?>
                                <?php if ($counter % 3 == 0) : ?>
                                    <div class="item-img mr0">
                                        <?php echo apply_filters('the_content', $attachment->post_content) . wp_get_attachment_link($attachment->ID, 'full', false); ?>
                                    </div>
                                <?php else : ?>
                                    <div class="item-img">
                                        <?php echo apply_filters('the_content', $attachment->post_content) . wp_get_attachment_link($attachment->ID, 'full', false); ?>
                                    </div>
                                <?php
                                endif;
                            endforeach;
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