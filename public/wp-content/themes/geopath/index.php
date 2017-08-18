<?php get_header('page'); ?>

<?php while(have_posts()): the_post(); ?>
    <section class="our-company tab-to-geopath page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
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