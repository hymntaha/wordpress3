
    <footer class="container-fluid">
        <div class="row footer-flex">
            <div class="col-sm-4 map-container">
                <iframe class="map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3022.3292088607664!2d-73.98969578444822!3d40.75478347932716!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c259ab43c1058f%3A0xffb012d0fa24ca06!2s561+7th+Ave%2C+New+York%2C+NY+10018%2C+Stany+Zjednoczone!5e0!3m2!1spl!2spl!4v1473766570844" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
            <div class="col-sm-4 middle-container">
                <div class="wrapper">
                    <a href="<?php echo esc_url(home_url()); ?>" class="footer-brand"></a>
                    <?php get_template_part('social', 'container')?>
                </div>
            </div>
            <div class="col-sm-4 flex-space-around">
                <div>
                    <?php
                        $footer_contact_text = get_field('footer_contact_text', 'option');

                        if ($footer_contact_text):
                            echo $footer_contact_text;
                        endif;
                    ?>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <?php wp_footer(); ?>
    <script type="text/javascript">
        var ajaxurl = '<?php echo admin_url('admin-ajax.php'); ?>';
    </script>
</body>
</html>