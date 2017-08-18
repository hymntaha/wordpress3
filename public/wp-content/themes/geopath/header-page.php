<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700" rel="stylesheet">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?> >
    <nav class="navbar navbar-default navbar-geopath">
    <div class="height-100">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header navbar-header-geopath">
            <button type="button" class="navbar-toggle navbar-toggle-geopath collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <div id="hamburger">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </button>
            <a class="navbar-brand navbar-brand-geopath" href="<?php echo esc_url(home_url()); ?>">
                <img src="<?php echo get_template_directory_uri().'/images/geopath-logo-descriptor-white-copy.png'; ?>" alt="geopath.org" />
            </a>
        </div>
        <?php
        wp_nav_menu( array(
                'menu'              => 'header-menu',
                'theme_location'    => 'header-menu',
                'depth'             => 1,
                'container'         => 'div',
                'container_class'   => 'collapse navbar-collapse geopath-navbar-collapse',
                'container_id'      => 'bs-example-navbar-collapse-1',
                'menu_class'        => 'nav navbar-nav navbar-right',
                'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                'walker'            => new wp_bootstrap_navwalker())
        );
        ?>
    </div><!-- /.container-fluid -->
</nav>
