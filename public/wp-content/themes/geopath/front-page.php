<?php get_header(); ?>

    <header class="homepage-header">
        <div class="welcome">
            <?php $hero_text = get_field('hero_top_text'); ?>

            <?php if ($hero_text): ?>
                <p><?php echo $hero_text; ?></p>
            <?php endif; ?>

            <?php $hero_image = get_field('hero_image');?>

            <?php if ($hero_image):?>
                <img class="img-responsive" src="<?php echo $hero_image?>" alt="geopath - audience and location measurement">
            <?php endif; ?>
        </div>

        <a href="#next-section" class="scroll-down">
            <span>scroll down</span>
            <br>
            <img src="<?php echo get_template_directory_uri().'/images/arrow-down.png'?>" alt="scroll down icon">
        </a>
    </header>

    <?php
        $info_text = get_field('below_hero_text_section');
        $info_text_bg = get_field('below_hero_bg');
        $info_text_bg_color = get_field('below_hero_bg_color');

        $info_text_style = $info_text_bg ? 'background-image: url('.$info_text_bg.'); ' : null;
        $info_text_style .= $info_text_bg_color ? 'background-color: '.$info_text_bg_color. ';' : null;
?>

    <?php if($info_text): ?>
        <article id="next-section" class="container-fluid info info-section" style="<?php echo $info_text_style ? $info_text_style : null; ?>">
            <div class="row">
                <div class="text col-xs-12">
                    <?php echo $info_text; ?>
                </div>
            </div>
        </article>
    <?php endif;?>

    <?php
        $blog_items = get_field('blog_items');
        $blog_bg = get_field('blog_bg_img');
        $blog_bg_color = get_field('blog_bg_img_color');

        $style = $blog_bg ? ' background-image: url('.$blog_bg.');' : null;
        $style .= $blog_bg_color ? ' background-color: '.$blog_bg_color.';' : null;
    ?>
    <?php if ($blog_items): ?>
        <section class="container-fluid blog" style="<?php echo $style ? $style : null; ?>">

            <h1>The Bl<span class="o">o</span>g</h1>
            <a class="go-to-blog-link" target="_blank" href="<?php the_field('blog_link'); ?>">
                <?php the_field('blog_link_text'); ?>
            </a>

            <div class="blog-items-wrapper">
                <?php foreach($blog_items as $item_id): ?>
                    <?php

                        $blog_post = get_post($item_id);

                        if ($blog_post->post_status !== 'publish'):
                            continue;
                        endif;

                        $post_img = get_field('blog_item_img', $item_id);
                        $post_bg_color = get_field('blog_item_bg', $item_id);
                        $post_url = get_field('blog_item_url', $item_id);
                        $post_author_img = get_field('blog_item_author_img', $item_id);
                        $post_author_fb = get_field('post_author_facebook_name', $item_id);
                        $post_author_twitter = get_field('post_author_twitter_name', $item_id);
                        $post_author_mail = get_field('blog_item_author_mail', $item_id);
                    ?>

                    <div class="col-xs-12 col-sm-6 col-md-4 blog-link">
                        <div class="blog-image-container" style="background-image: url('<?php echo $post_img; ?>')">
                            <div>
                                <div>
                                    <div class="author-avatar">
                                        <div class="image-wrapper" style="background-image: url('<?php echo $post_author_img; ?>');">
                                        </div>
                                        <span>Posted By</span>
                                    </div>
                                    <div class="contact-details-container">
                                        <div class="contact-details">

                                            <?php if ($post_author_twitter): ?>
                                                <a href="http://twitter.com/<?php echo $post_author_twitter ; ?>" class="line" target="blank">
                                                    Twitter: @<?php echo $post_author_twitter; ?>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($post_author_mail): ?>
                                                <a href="mailto:<?php echo $post_author_mail; ?>" class="line" target="blank">
                                                    Email: <?php echo $post_author_mail; ?>
                                                </a>
                                            <?php endif; ?>

                                            <?php if ($post_author_fb): ?>
                                                <a href="http://facebook.com/<?php echo $post_author_fb;?>" target="blank">
                                                    Facebook: @<?php echo $post_author_fb; ?>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="blog-post color-1" style="<?php echo $post_bg_color ? 'background-color: '.$post_bg_color.';' : null;?>">
                            <h2><?php echo wp_trim_words($blog_post->post_title, 15, '...'); ?></h2>
                            <p><?php echo wp_trim_words(get_field('blog_item_desc', $item_id), 70, '...'); ?></p>

                            <?php if ($post_url): ?>
                                <a href="<?php echo $post_url; ?>" target="_blank">View Post</a>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    <?php endif; ?>


    <?php
        $newsletter_bg = get_field('newsletter_bg');
        $newsletter_bg_color = get_field('newsletter_bg_color');

        $style =  $newsletter_bg ? ' background-image: url('.$newsletter_bg.');' : null;
        $style .= $newsletter_bg_color ? ' background-color: '.$newsletter_bg_color.';' : null;

        $newsletter_bar_color = get_field('newsletter_bar_bg_color');
        $newsletter_bar_opacity = get_field('newsletter_bar_opacity');

        $bar_color_val = $newsletter_bar_color ? hex2rgba($newsletter_bar_color, $newsletter_bar_opacity) : null;
        $bar_style = $bar_color_val ? 'background-color: rgba('.$bar_color_val.')' : null;

    ?>
    <section class="container-fluid get-in-touch" style="<?php echo $style ? $style : null; ?>">
        <div class="row">
            <div >
                <div class="container-fluid">
                    <div class="row">
                        <div class="stripe" style="<?php echo $bar_style ? $bar_style : null; ?>">
                            <div class="col-sm-12">
                                <div class="flex height-100">
                                    <h1 class="follow-us">Follow Us:</h1>
                                    <?php get_template_part('social', 'container')?>
                                </div>
                            </div><!-- /col-sm-6 -->
                            <div class="col-sm-12 divider">
                                <?php
                                    $mailchimp_shortcode = get_field('mailchimp_shortcode');

                                    if ($mailchimp_shortcode):
                                        echo do_shortcode($mailchimp_shortcode);
                                    endif;
                                ?>
                            </div>
                        </div><!-- /.stripe -->
                    </div><!-- /.row   -->
                </div><!-- .container-fluid -->

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="slider">
                                <?php render_slick_content(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </section>

    <?php
        if( have_rows('homepage_sections') ):
            while ( have_rows('homepage_sections') ) : the_row();
                $row_layout = get_row_layout();

                switch($row_layout):
                    case 'section_info':
                        get_template_part('flexible_items/section', 'info_text');
                        break;
                    case 'section_rows_text':
                        get_template_part('flexible_items/section', 'rows_text');
                        break;
                endswitch;
            endwhile;
        endif;
    ?>


    <?php
        $insights_bg = get_field('insights_bg');
        $insights_bg_color = get_field('insights_bg_color');

        $style = $insights_bg ? ' background-image: url('.$insights_bg.');' : null;
        $style .= $insights_bg_color ? ' background-color: '.$insights_bg_color.';' : null;
    ?>
    <section class="insights container-fluid" style="<?php echo $style ? $style : null; ?>">
        <h1 class="text-center">Out of H<span class="o">o</span>me By The Numbers</h1>
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h2><?php the_field('insights_title');?></h2>
                </div>
            </div>
            <div class="row flex">

                <div class="col-sm-12 col-md-3 first-col border-top">
                    <?php the_field('insights_left_text'); ?>
                </div>

                <div class="col-sm-4 col-md-3 border-top">
                    <?php render_column_items('insights_col_1'); ?>

                </div>

                <div class="col-sm-4 col-md-3 border-top">
                    <?php render_column_items('insights_col_2'); ?>
                </div>

                <div class="col-sm-4 col-md-3 border-top">
                    <?php render_column_items('insights_col_3'); ?>
                </div>

            </div>
        </div>
    </section>

<?php get_footer();
