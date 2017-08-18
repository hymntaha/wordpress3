<div class="social-container">
    <?php
    $fb_link = get_field('social_url_facebook', 'option');
    $linkedin_link = get_field('social_url_linkedin', 'option');
    $twitter_link = get_field('social_url_twitter', 'option');
    $youtube_link = get_field('social_url_youtube', 'option');
    $instagram_link = get_field('social_url_instagram', 'option');
    ?>
    <?php if ($fb_link): ?>
        <a href="<?php echo $fb_link; ?>" target="_blank" class="social-icon"><span class="icon-facebook"></span></a>
    <?php endif; ?>

    <?php if ($twitter_link): ?>
        <a href="<?php echo $twitter_link; ?>" target="_blank" class="social-icon"><span class="icon-twitter"></span></a>
    <?php endif; ?>

    <?php if ($linkedin_link): ?>
        <a href="<?php echo $linkedin_link; ?>" target="_blank" class="social-icon"><span class="icon-linkedin"></span></a>
    <?php endif; ?>

    <?php if ($youtube_link): ?>
        <a href="<?php echo $youtube_link; ?>" target="_blank" class="social-icon"><span class="icon-youtube-play"></span></a>
    <?php endif; ?>

    <?php if ($instagram_link): ?>
        <a href="<?php echo $instagram_link; ?>" target="_blank" class="social-icon"><span class="icon-instagram"></span></a>
    <?php endif; ?>

</div>