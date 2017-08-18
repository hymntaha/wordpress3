<?php
/**
 * Template Name: Library page
 */

    get_header('page');
?>
    <section class="geekout-library container-fluid" <?php echo renderBackgroundStyles(get_field('library_top_background'), get_field('library_top_background_color')); ?>>
        <div class="row">
            <div class="col-xs-12">
                <h1><?php the_field('library_header'); ?></h1>
                <div class="container">
                    <?php the_field('library_text'); ?>
                </div>
                <?php if (!library_has_access()): ?>
                    <div id="library-login-form">
                        <?php if (library_auth_requested()): ?>
                            <div class="row error-message">
                                <div class="col-lg-offset-4 col-lg-4 col-md-offset-3 col-md-6 col-sm-12">
                                    <div class="alert alert-danger">
                                        <?php the_field('library_invalid_email_copy', 'option'); ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <form method="post">
                            <div class="row">
                                <div class="col-lg-offset-4 col-lg-3 col-sm-8">
                                    <input type="email" class="input flex-children triangle" name="<?php echo $libraryPostName; ?>" placeholder="Type your e-mail address" />
                                </div>
                                <div class="col-lg-1 col-sm-4">
                                    <button type="submit" class="button flex-children">
                                        Log in
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php else: ?>
                    <?php
                        $filter_1_name = get_field('filter_1_name', 'option');
                        $filter_2_name = get_field('filter_2_name', 'option');
                        $filter_3_name = get_field('filter_3_name', 'option');
                    ?>
                    <form id="library-filters" class="library-filters">
                        <div class="flex geekout-nav-buttons">
                            <div class="flex-children first">
                                <p class="default-text">NARROW BY</p>
                                <p class="reset-filters hidden">Reset Filters</p>
                            </div>
                            <select class="select flex-children triangle" multiple="multiple" id="industry" name="<?php echo TAX_INDUSTRY; ?>[]" data-placeholder="<?php echo $filter_1_name ? $filter_1_name : 'Filter 1'; ?>">
                                    <?php render_select_lib_options(TAX_INDUSTRY); ?>
                                </select>
                            <select class="select flex-children" multiple="multiple" id="audienceProfile" name="<?php echo TAX_AUDIENCE; ?>[]" data-placeholder="<?php echo $filter_2_name ? $filter_2_name : 'Filter 2'; ?>">
                                    <?php render_select_lib_options(TAX_AUDIENCE); ?>
                                </select>
                            <select class="select flex-children" multiple="multiple" id="contentType" name="<?php echo TAX_CONTENT_TYPE; ?>[]" data-placeholder="<?php echo $filter_3_name ? $filter_3_name : 'Filter 3'; ?>">
                                <?php render_select_lib_options(TAX_CONTENT_TYPE); ?>
                                </select>
                            <select class="select flex-children last" multiple="multiple" id="datePublished" name="date[]"data-placeholder="Date Published">
                                    <?php render_select_mont_options(); ?>
                            </select>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php if (library_has_access()): ?>
    <main class="container-fluid library-items" <?php echo renderBackgroundStyles(get_field('library_background'), get_field('library_background_color')); ?>>
        <div id="library-items" class="grid">
            <?php

            $lib_items = new WP_Query([
                'post_type' => LIBRARY_POST_TYPE,
                'post_status' => 'publish',
                'cache_results'  => false,
                'orderby' => 'date',
                'order' => 'DEC',
                'posts_per_page' => LIBRARY_ITEMS_PER_PAGE
            ]);

            foreach ($lib_items->posts as $item):
                render_library_block($item);
            endforeach;
            ?>
        </div>
        <div id="load-more" style="<?php echo $lib_items->max_num_pages > 1 ? 'display: block': 'display: none'; ?>">
                <span class="btn btn-default" data-current-page="1">Load More</span>
        </div>
        <div id="msg-box">
            No Items Found
        </div>
    </main>
    <?php endif; ?>
<?php
    get_footer();
