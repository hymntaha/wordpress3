<?php
/**
 * Template Name: Geekout page
 */

get_header('page');
?>
    <header class="geekout-header" <?php echo renderBackgroundStyles(get_field('geekout_hero_background'), get_field('geekout_hero_background_color')); ?>>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <img src="<?php the_field('hero_image'); ?>" alt="geekout" class="geekout-img img-responsive">
                    <p><?php the_field('hero_text'); ?></p>
                </div>
            </div>
        </div>
        <nav class="geekout-nav">
            <ul class="geekout-nav-buttons nav nav-pills">
                <li class="geekout-nav-items"><a href="#library">geekOUT Library</a></li>
                <li class="geekout-nav-items"><a href="#research">Our Research</a></li>
                <li class="geekout-nav-items"><a href="#transit" >Transit</a></li>
                <li class="geekout-nav-items"><a href="#oOH">OOH Office Hours</a></li>
            </ul>
        </nav>
    </header>

    <section id="library" class="geekout-section geekout-library" <?php echo renderBackgroundStyles(get_field('geekout_library_background'), get_field('geekout_library_background_color')); ?>>
        <div class="gradient">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1><?php the_field('library_header'); ?></h1>

                        <?php the_field('library_text'); ?>

                        <?php $library_link = get_field('library_link'); ?>

                        <?php if ($library_link): ?>
                            <a href="<?php echo $library_link; ?>" class="geekout-link"><?php the_field('library_link_text'); ?></a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="research" class="geekout-section our-research" <?php echo renderBackgroundStyles(get_field('geekout_research_background'), get_field('geekout_research_background_color')); ?>>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php the_field('research_header'); ?></h1>
                    <?php the_field('research_text'); ?>

                    <?php $img_src = get_field('research_image'); ?>

                    <?php if ($img_src): ?>
                        <img class="img-responsive" src="<?php echo $img_src; ?>" alt="research info">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section id="transit" class="geekout-section transit" <?php echo renderBackgroundStyles(get_field('geekout_transit_background'), get_field('geekout_transit_background_color')); ?>>
        <div class="gradient">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <h1><?php the_field('transit_header'); ?></h1>

                        <?php the_field('transit_text'); ?>

                        <div class="container-fluid charts-container">
                            <div class="row">
                                <?php while(have_rows('transit_icons')): the_row(); ?>
                                    <?php
                                        $icon_link_select = get_sub_field('icon_link');
                                        $icon_link = null;
                                        $download = false;

                                        if ($icon_link_select == 'internal'):
                                            $icon_link = get_sub_field('icon_internal_link');
                                            $download = true;
                                        endif;

                                        if ($icon_link_select == 'external'):
                                            $icon_link = get_sub_field('icon_external_link');
                                        endif;
                                    ?>

                                    <div class="col-xs-6 col-sm-3 no-padding">
                                        <?php
                                            if ($icon_link) :

                                                echo '<a href="'.$icon_link.'" class="icon-link" target="_blank" '.($download ? 'download' : null ).'  >';
                                            endif;
                                        ?>
                                                <img src="<?php the_sub_field('icon_image'); ?>" alt="<?php the_sub_field('icon_text'); ?>" class="img-responsive chart">
                                                <p class="caption"><?php the_sub_field('icon_text'); ?></p>
                                        <?php
                                            if ($icon_link) :
                                                echo '</a>';
                                            endif;
                                        ?>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="oOH" class="geekout-section out-of-home" <?php echo renderBackgroundStyles(get_field('geekout_ooh_background'), get_field('geekout_ooh_background_color')); ?>>
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php the_field('ooh_header'); ?></h1>
                    <?php the_field('ooh_text'); ?>
                </div>
            </div>

            <?php render_youtube_content(); ?>

        </div>
    </section>
<?php get_footer(); ?>