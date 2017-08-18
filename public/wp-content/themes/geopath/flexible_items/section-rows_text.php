<section class="what-we-do container-fluid">
    <div class="row">
        <?php
            $section_title = get_sub_field('section_rows_text_title');
            $section_bg = get_sub_field('section__title_bg');
            $section_bg_color = get_sub_field('section__title_bg_color');

            $section_style = $section_bg ? 'background-image: url('.$section_bg.'); ' : null;
            $section_style .= $section_bg_color ? 'background-color: '.$section_bg_color.'; ' : null;
        ?>
        <?php if ($section_title): ?>
            <div class="top-overlay height-100" style="<?php echo $section_style; ?>">
                <h1><?php echo $section_title; ?></h1>
            </div>
        <?php endif; ?>

        <?php
            if( have_rows('section_rows_text_types') ):
                while ( have_rows('section_rows_text_types') ) : the_row();

                    $row_text_type = get_row_layout();

                    switch ($row_text_type):
                        case 'section_rows_text_image_left':
                            get_template_part('flexible_items/section', 'row_text_image_left');
                            break;
                        case 'section_rows_text_image_right':
                            get_template_part('flexible_items/section', 'row_text_image_right');
                            break;
                    endswitch;
                endwhile;
            endif;?>
    </div>
</section>