<?php get_header(); ?>

<!-- WRAPPER -->
<div id="wrapper" class="bgr_about" <?php
if (get_option("bg_about") != "") {
    $url = get_option("bg_about");
    echo "style=\"background:url('{$url}') no-repeat center top transparent;\"";
}
?>>
    <div class="real_w layout_2col">
        <!-- breadcrum -->
        <div class="breadcrum">
            <h2>Hình ảnh</h2>
        </div>

        <!-- left -->
        <div class="left">

            <div class="about">
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
                <?php while (have_posts()) : the_post(); ?>
                    <h1><?php the_title(); ?></h1>
                    <div class="about_ct">
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
        <!-- right -->
        <?php get_sidebar(); ?>
        <div class="clrb"></div>
    </div>
</div>
<!-- end:WRAPPER -->

<?php get_footer(); ?>