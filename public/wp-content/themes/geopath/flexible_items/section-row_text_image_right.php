<?php
    $section_bg = get_sub_field('section_bg');
    $section_bg_color = get_sub_field('section_bg_color');

    $section_style = $section_bg ? 'background-image: url('.$section_bg.'); ' : null;
    $section_style .= $section_bg_color ? 'background-color: '.$section_bg_color.'; ' : null;
?>

<div class="container-fluid " style="<?php echo $section_style ? $section_style : null; ?>">
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <?php the_sub_field('section_rows_text_text'); ?>
                </div>
                <div class="col-sm-4">
                    <?php $section_image = get_sub_field('section_image'); ?>

                    <?php if ($section_image): ?>
                        <img src="<?php echo $section_image; ?>" alt="chart" class="img-responsive">
                    <?php endif; ?>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.row -->
</div><!-- /.container-fluid -->