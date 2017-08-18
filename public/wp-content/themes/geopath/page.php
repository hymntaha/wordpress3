<?php get_header('page'); ?>

<?php while(have_posts()): the_post(); ?>
    <section class="our-company tab-to-geopath page-content" <?php echo renderBackgroundStyles(get_field('page_background'), get_field('page_background_color')); ?>>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                    $page_header = get_field('page_header');
                    $page_header_img = get_field('page_img');
                    ?>

                    <?php if ($page_header): ?>
                        <h1><?php echo $page_header; ?></h1>
                    <?php endif;?>

                    <?php if ($page_header_img): ?>
                        <img src="<?php echo $page_header_img; ?>" alt="" class="img-responsive center-block page-header-img"/>
                    <?php endif; ?>

                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 flex">
                                    <?php the_content(); ?>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </section>
<?php endwhile; ?>
<?php get_footer(); ?>