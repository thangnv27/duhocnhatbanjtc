<?php get_header(); ?>
<!-- BEGIN WRAPPER-CONTENT -->
<div id="wrapper-content">
    <!-- BEGIN MAIN -->
    <div id="main">
        <div class="container">
            <!-- BEGIN HOMEPAGE BLOCKS -->

            <!-- BEGIN WRAPPER-FEATURED -->
            <?php if (get_option("bg_banner") != "") { ?>
                <div class="banner_content">
                    <img src="<?php echo get_option("bg_banner"); ?>" />
                </div>
            <?php } ?>
            <!-- END WRAPPER-FEATURED -->

            <?php
            $boxArr = json_decode(get_option('cat_box1'));
            if (count($boxArr) > 0):
                $taxonomy = 'category';
                foreach ($boxArr as $key => $catID) :
                    $category = get_category($catID);
                    ?>
                    <div class="homepage-widget">
                        <div class="block full">
                            <?php if($key == 0): ?>
                            <h1><a href="<?php echo get_term_link($catID, 'category'); ?>"><?php echo ucfirst($category->name); ?></a></h1>
                            <?php elseif(in_array($key, array(1,2))): ?>
                            <h2><a href="<?php echo get_term_link($catID, 'category'); ?>"><?php echo ucfirst($category->name); ?></a></h2>
                            <?php else: ?>
                            <h3><a href="<?php echo get_term_link($catID, 'category'); ?>"><?php echo ucfirst($category->name); ?></a></h3>
                            <?php endif; ?>
                            <div class="tabs-wrapper">
                                <ul class="child_cate">
                                <?php
                                $subCats = get_categories(array(
                                    'type' => 'post',
                                    'taxonomy' => $taxonomy,
                                    'child_of' => $category->term_id,
                                    'hide_empty' => 0,
                                        ));
                                foreach ($subCats as $child) :
                                    ?>
                                    <li><h4><a href="<?php echo get_term_link($child, $taxonomy); ?>"><?php echo $child->name; ?></a></h4></li> 
                                <?php endforeach; ?>
                                </ul>
                                <div class="tabs_container">
                                    <div class="tab_content" id="tab1" style="display: block;">
                                        <?php
                                        $loop = new WP_Query(
                                                        array(
                                                            'post_type' => 'post',
                                                            'cat' => $category->term_id,
                                                            'posts_per_page' => 4,
                                                            'orderby' => ''
                                                        )
                                        );
                                        $counter = 0;
                                        while ($loop->have_posts()) : $loop->the_post();
                                            if ($counter == 0) :
                                                ?>
                                                <div class="block-item-big block-item-big-last">
                                                    <div class="block-image">
                                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                            <img width="152" height="106" src="<?php get_image_url(); ?>" alt="<?php the_title(); ?>">
                                                        </a>
                                                    </div>
                                                    <h4>
                                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                            <?php the_title(); ?>
                                                        </a>
                                                    </h4>
                                                    <p><?php the_excerpt(); ?></p>							
                                                </div>
                                            <?php else: ?>
                                                <div class="block-item-small">
                                                    <h4>
                                                        <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                                                            <?php the_title(); ?>
                                                        </a>
                                                    </h4>
                                                </div>
                                            <?php
                                            endif;
                                            $counter++;
                                        endwhile;
                                        wp_reset_query();
                                        ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach;
            endif;
            ?>
        </div>
        <!-- END HOMEPAGE BLOCKS -->
    </div>
    <!-- END MAIN -->

    <!-- BEGIN SIDEBAR -->
<?php get_sidebar(); ?>
    <!-- END SIDEBAR -->			
</div>
<!-- END WRAPPER-CONTENT -->

<?php get_footer(); ?>