<?php

/**
* Template Name: Our Company
*/

get_header('page');
?>
    <section class="our-company tab-to-geopath" <?php echo renderBackgroundStyles(get_field('ourcompany_tab_background'), get_field('ourcompany_tab_background_color')); ?>>
        <div class="gradient">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        <?php
                            $tab_hero_title = get_field('tab_hero_title');
                            $tab_img = get_field('tab_img');
                        ?>

                        <?php if($tab_hero_title): ?>
                            <h1><?php echo $tab_hero_title; ?></h1>
                        <?php endif;  ?>

                        <?php if($tab_img): ?>
                            <img class="img-responsive img-space" src="<?php echo $tab_img; ?>" alt="From Tab to Geopath">
                        <?php endif;?>

                        <?php the_field('tab_text'); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-company market-locator" <?php echo renderBackgroundStyles(get_field('ourcompany_market_background'), get_field('ourcompany_market_background_color')); ?>>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <?php
                        $locator_title = get_field('locator_title');
                        $locator_text = get_field('locator_text');
                        $locator_iframe = get_field('locator_iframe');
                    ?>

                    <?php if ($locator_title): ?>
                        <h1><?php echo $locator_title; ?></h1>
                    <?php endif;?>


                    <?php echo $locator_text; ?>

                    <?php if($locator_iframe): ?>
                        <!-- .container-fluid>.row -->
                        <div class="container">
                            <div class="row">
                                <div class="col-xs-12 flex">
                                    <iframe src="<?php echo $locator_iframe; ?>" scrolling="yes" frameborder="0"></iframe>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>

    <section class="our-company our-members" <?php echo renderBackgroundStyles(get_field('ourcompany_members_background'), get_field('ourcompany_members_background_color')); ?>>
        <div class="gradient">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xs-12">
                        <h1><?php the_field('header_tpl_title'); ?></h1>
                        <?php the_field('header_tpl_text'); ?>
                        <div class="tables-container">
                            <ul class="nav nav-tabs">
                                <li class="our-members-tab active"><a class="our-members-tab__link" data-toggle="tab" role="tab" data-target="#plants">Plants</a></li>
                                <li class="our-members-tab"><a class="our-members-tab__link" data-toggle="tab" role="tab" data-target="#agencies">Agencies</a></li>
                                <li class="our-members-tab"><a class="our-members-tab__link" data-toggle="tab" role="tab" data-target="#advertisers">Advertisers</a></li>
                                <li class="our-members-tab"><a class="our-members-tab__link" data-toggle="tab" role="tab" data-target="#advertisingAgency">Advertising Agency</a></li>
                                <li class="our-members-tab"><a class="our-members-tab__link" data-toggle="tab" role="tab" data-target="#associates">Associates</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="plants">
                                    <table data-items-cat="mbpln" class="table table-striped" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>City</th>
                                            <th>State</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="agencies">
                                    <table data-items-cat="mbagn" class="table table-striped" cellspacing="0" width="100%" >
                                        <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>City</th>
                                            <th>State</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="advertisers">
                                    <table data-items-cat="mbadv" class="table table-striped" cellspacing="0" width="100%" >
                                        <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>City</th>
                                            <th>State</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="advertisingAgency">
                                    <table data-items-cat="mbaaa" class="table table-striped" cellspacing="0" width="100%" >
                                        <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>City</th>
                                            <th>State</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div data-items-cat="mbasc" role="tabpanel" class="tab-pane" id="associates">
                                    <table data-items-cat="mbasc" class="table table-striped" cellspacing="0" width="100%" >
                                        <thead>
                                        <tr>
                                            <th>Company</th>
                                            <th>City</th>
                                            <th>State</th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div><!-- /.tab-pane -->
                            </div><!-- /.tab-content -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="our-company our-board" <?php echo renderBackgroundStyles(get_field('ourcompany_board_background'), get_field('ourcompany_board_background_color')); ?>>
        <div class="container-fluid">
            <div class="row">
                <div class="col-xs-12">
                    <h1><?php the_field('board_tpl_title'); ?></h1>
                    <?php the_field('board_tpl_text'); ?>
                    <div class="tables-container our-board__table">
                        <ul class="nav nav-tabs">
                            <li class="our-board-tab active"><a class="our-board-tab__link" data-toggle="tab" role="tab" data-target="#plants2">Plant Operators</a></li>
                            <li class="our-board-tab"><a class="our-board-tab__link" data-toggle="tab" role="tab" data-target="#agencies2">Agencies</a></li>
                            <li class="our-board-tab"><a class="our-board-tab__link" data-toggle="tab" role="tab" data-target="#advertisers2">Advertisers</a></li>
                            <li class="our-board-tab"><a class="our-board-tab__link" data-toggle="tab" role="tab" data-target="#exOfficio">Ex-Officio</a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane active" id="plants2">
                                <table data-items-cat="bdplo" class="table table-striped" cellspacing="0" width="100%" >
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Company</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="agencies2">
                                <table data-items-cat="bdagc" class="table table-striped" cellspacing="0" width="100%" >
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Company</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="advertisers2">
                                <table data-items-cat="bdadv" class="table table-striped" cellspacing="0" width="100%" >
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Company</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                            <div role="tabpanel" class="tab-pane" id="exOfficio">
                                <table data-items-cat="bdexo" class="table table-striped" cellspacing="0" width="100%" >
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Title</th>
                                        <th>Company</th>
                                    </tr>
                                    </thead>
                                </table>
                            </div>
                        </div><!-- /.tab-content -->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
get_footer();