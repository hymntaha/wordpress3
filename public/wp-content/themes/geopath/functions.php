<?php

require_once 'include/WP_boostrap_navwalker.php';
require_once 'include/library_post_type.php';
require_once 'include/members_post_type.php';
require_once 'include/board_post_type.php';
require_once 'include/library_auth.php';

/**
 * Disable emoji styles
 */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' );

// Remove head generator text, RSD and WLW manifest
remove_action ('wp_head', 'wp_generator');
remove_action ('wp_head', 'rsd_link');
remove_action ('wp_head', 'wlwmanifest_link');
remove_action ('wp_head', 'wp_shortlink_wp_head');

add_action('wp_head', function() {
    echo "
        <!-- Google Analytics -->
        <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');
        
        ga('create', '".get_field('google_analytics_id', 'option')."', 'auto');
        ga('send', 'pageview');
        </script>
        <!-- End Google Analytics -->
    ";
});

function geopath_setup()
{
    load_theme_textdomain( 'geopath' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * See: https://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
     */
    add_theme_support( 'post-thumbnails' );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    // Indicate widget sidebars can use selective refresh in the Customizer.
    add_theme_support( 'customize-selective-refresh-widgets' );

    //Include feed url links into header
    add_theme_support('automatic-feed-links');

    if (function_exists('acf_add_options_page')) {
        $parent = acf_add_options_page([
            'page_title' => 'Theme Settings',
            'menu_title' => 'Theme Settings',
            'position' => 50.1,
            'redirect' => true,
            'autoload' => true,
        ]);

        acf_add_options_sub_page([
            'page_title' 	=> 'Social Settings',
            'menu_title' 	=> 'Social Links',
            'parent_slug' 	=> $parent['menu_slug'],
        ]);

        acf_add_options_sub_page([
            'page_title' 	=> 'Footer',
            'menu_title' 	=> 'Footer',
            'parent_slug' 	=> $parent['menu_slug'],
        ]);

        acf_add_options_sub_page([
            'page_title' 	=> 'Social Media Settings',
            'menu_title' 	=> 'Social Media',
            'parent_slug' 	=> $parent['menu_slug'],
        ]);

        acf_add_options_sub_page([
            'page_title' 	=> 'Library Filters',
            'menu_title' 	=> 'Filters',
            'parent_slug' 	=> $parent['menu_slug'],
        ]);
        
        acf_add_options_sub_page([
            'page_title' 	=> 'Library',
            'menu_title' 	=> 'Library',
            'parent_slug' 	=> $parent['menu_slug'],
        ]);
        
        acf_add_options_sub_page([
            'page_title' 	=> 'Other',
            'menu_title' 	=> 'Other',
            'parent_slug' 	=> $parent['menu_slug'],
        ]);
    }
}

add_action( 'after_setup_theme', 'geopath_setup' );

/**
 * Enqueue theme scripts
 */
function geopath_scripts()
{
    wp_enqueue_script('geopath_script', get_template_directory_uri().'/js/script.js', ['jquery'], null, true);
    wp_enqueue_script('geopath_slick', get_template_directory_uri().'/bower_components/slick-carousel/slick/slick.min.js', ['geopath_script'], null, true);
    wp_enqueue_script('geopath_fancybox', get_template_directory_uri().'/bower_components/fancybox/source/jquery.fancybox.pack.js', ['geopath_script'], null, true);
    wp_enqueue_script('geopath_youtube_api', 'https://www.youtube.com/player_api', ['geopath_fancybox'], null, true);
    wp_enqueue_script('geopath_multiselector', get_template_directory_uri().'/js/bootstrap-multiselect/bootstrap-multiselect.js', ['geopath_script'], null, true);
    wp_enqueue_script('geopath_isotope', get_template_directory_uri().'/bower_components/isotope/dist/isotope.pkgd.min.js', ['geopath_script'], null, true);
    wp_enqueue_script('geopath_lodash', get_template_directory_uri().'/bower_components/lodash/dist/lodash.min.js', ['geopath_script'], null, true);
    wp_enqueue_script('geopath_scroll_to', get_template_directory_uri().'/bower_components/jquery.scrollTo/jquery.scrollTo.min.js', ['geopath_script'], null, true);

    //dataTable
    wp_enqueue_script('geopath_datatable', get_template_directory_uri() .'/bower_components/datatables.net/js/jquery.dataTables.min.js', ['geopath_script'], null, true);
    wp_enqueue_script('geopath_datatable_bs', get_template_directory_uri() .'/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js', ['geopath_script'], null, true);


    wp_localize_script( 'geopath_script', 'conf', get_theme_conf_data());

    wp_enqueue_style('geopath_style', get_template_directory_uri().'/css/styles.css', null, null, 'all');
    wp_enqueue_style(
        'geopath_font_opensans',
        'https://fonts.googleapis.com/css?family=Open+Sans+Condensed:300,300i,700',
        ['geopath_style'],
        null,
        'all'
    );
    wp_enqueue_style(
        'geopath_fontello',
        get_template_directory_uri().'/css/fontello/css/fontello.css',
        ['geopath_style'],
        null,
        'all'
    );

    wp_enqueue_style('geopath_slick', get_template_directory_uri().'/bower_components/slick-carousel/slick/slick.css', null, null, 'all');
    wp_enqueue_style('geopath_slick_theme', get_template_directory_uri().'/bower_components/slick-carousel/slick/slick-theme.css', null, null, 'all');
    wp_enqueue_style('geopath_fancybox_theme', get_template_directory_uri().'/bower_components/fancybox/source/jquery.fancybox.css', null, null, 'all');
    wp_enqueue_style('geopath_multiselect', get_template_directory_uri().'/js/bootstrap-multiselect/bootstrap-multiselect.css', null, null, 'all');
    wp_enqueue_style('geopath_datatable_bs_css', 'https://cdn.datatables.net/1.10.12/css/dataTables.bootstrap.min.css', null, null, 'all');
}
add_action( 'wp_enqueue_scripts', 'geopath_scripts' );


/**
 * Admin panel scripts
 */
function admin_geopath_scripts()
{
    wp_enqueue_script('geopath_admin_select2', get_template_directory_uri().'/bower_components/select2/dist/js/select2.min.js', ['jquery']);
    wp_enqueue_script('geopath_admin_script',  get_template_directory_uri().'/js/admin_script.js', ['jquery']);

    wp_enqueue_style('geopath_admin_select2_css', get_template_directory_uri().'/bower_components/select2/dist/css/select2.min.css');
    wp_enqueue_style('geopath_admin_style', get_template_directory_uri().'/css/admin_style.css');
}
add_action('admin_enqueue_scripts', 'admin_geopath_scripts');

/**
 * Register them menus
 */
function geopath_menus() {
    register_nav_menus(
        array(
            'header-menu' => __( 'Header Menu' ),
        )
    );
}
add_action( 'init', 'geopath_menus' );


/**
 * Add custom css which hide Elementor edit button for homepage
 */
function admin_hide_elementor_switch_mode() {
    global $post;

    $front_page_id = get_option('page_on_front');


    if (!isset($post)) {
        return;
    }

    if ($post->post_type !== 'post' || $post->ID !== $front_page_id) {
        $style =
            '<style>'
            .'#elementor-switch-mode {display: none !important;}'
            .'#elementor-editor {display: none !important; }'
            .'</style>';

        echo $style;
    }

}
add_action('admin_head', 'admin_hide_elementor_switch_mode');

/**
 * Hide some admin menu tabs
 * @since  Columbus 1.0
 */
function remove_menus()
{
    //remove_menu_page( 'edit.php' );               //Posts
    remove_menu_page( 'edit-comments.php' );        //Comments
    remove_menu_page( 'link-manager.php' );         //Link manager
    //remove_menu_page( 'tools.php' );              //Tools
    //remove_menu_page( 'themes.php' );             //Themes
    //remove_menu_page( 'plugins.php' );            //Plugins
    //remove_menu_page( 'users.php' );              //Users
    //remove_menu_page( 'options-general.php' );    //Settings
    //remove_menu_page( 'upload.php' );             //Media
    //remove_menu_page( 'edit.php?post_type=acf-field-group'); //ACF

    //remove_submenu_page( 'index.php', 'update-core.php');
}
add_action( 'admin_menu', 'remove_menus' );

/**
 * Excerpt length
 */
add_filter( 'excerpt_length', function() { return 5; }, 999 );

function get_theme_conf_data()
{
    $theme_conf = [];

    $instagram_app_id = get_field('instagram_app_id', 'option');
    $instagram_app_key = get_field('instagram_api_key', 'option');

    if ($instagram_app_id) {
        $theme_conf['ins_app_id'] = $instagram_app_id;
    }

    if ($instagram_app_key) {
        $theme_conf['ins_key'] = $instagram_app_key;
    }

    return $theme_conf;
}

function render_slick_content()
{

    $instagram_data = get_instagram_data();

    foreach ($instagram_data as $item) {
        $img_url = $item['images']['low_resolution']['url'];

        echo '<div>
                <a href="'.$item['link'].'" target="_blank" style="background-image: url('.$img_url.')"></a>
            </div>';
    }

}

function get_instagram_data()
{
    $instagram_data = get_option('instagram_feed', []);
    $instagram_app_key = get_field('instagram_api_key', 'option');

    if (!$instagram_app_key) {
        return [];
    }

    if (is_valid_data($instagram_data)) {
        return json_decode($instagram_data['json'], true);
    }

    //Get new instagram data
    $request_url = 'https://api.instagram.com/v1/users/self/media/recent/?access_token='.$instagram_app_key.'&count=12';

    $response = wp_remote_get($request_url);
    $body_response = json_decode($response['body'], true);

    if (!isset($body_response['data'])) {
        return [];
    }

    //Save instagram data into db
    $data_to_save = [
        'json' => json_encode($body_response['data']),
        'date' => date('Y-m-d H:m:i')
    ];

    update_option('instagram_feed', $data_to_save);

    return $body_response['data'];
}

function is_valid_data($data, $expire_time = '+1hours')
{
    if (!isset($data['date'])) {
        return false;
    }

    $jsonData = strtotime($data['date'].$expire_time);
    $date_now = time();


    if ($date_now < $jsonData) {
        return true;
    }

    return false;
}

function render_youtube_content()
{
    $youtube_items = get_youtube_data();

    if (!$youtube_items) {
        return;
    }

    ?>
    <div class="row video-bg text-left">
        <?php foreach ($youtube_items as $item): ?>
            <?php
                $video_id = $item['snippet']['resourceId']['videoId'];
                $video_image = $item['snippet']['thumbnails']['high']['url'];
                $video_title = $item['snippet']['title'];
                $video_date = date('M j, Y' ,strtotime($item['snippet']['publishedAt']));
            ?>
            <div class="col-sm-4">
                <div class="video-container">
                    <a class="fancybox fancybox.iframe" href="https://www.youtube.com/embed/<?php echo $video_id; ?>?enablejsapi=1&wmode=opaque" rel="ooh-hours">
                        <img class="video img-responsive" data-video-id="" src="<?php echo $video_image; ?>"/>
                    </a>
                    <h2 class="video-title"><?php echo $video_title;?></h2>
                    <p class="date-published"><?php echo $video_date; ?></p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
    <?php
}

function get_youtube_data()
{
    $youtube_data = get_option('youtube_feed', []);
    $youtube_api_key = get_field('youtube_api_key', 'option');
    $youtube_channel_id = get_field('youtube_channel_id', 'option');
    $youtube_playlist_id = get_field('youtube_playlist', 'option');

    if (!$youtube_api_key || !$youtube_channel_id || !$youtube_playlist_id) {
        return [];
    }

    if (is_valid_data($youtube_data )) {
        return json_decode($youtube_data['json'], true);
    }

    //Get youtube data
    //$request_url = 'https://www.googleapis.com/youtube/v3/search?part=id,snippet&channelId='.$youtube_channel_id.'&maxResults=6&type=video&key='.$youtube_api_key;

    //Load items from selected playlist
    $request_url = 'https://www.googleapis.com/youtube/v3/playlistItems?part=snippet&maxResults=6&playlistId='.$youtube_playlist_id.'&key='.$youtube_api_key;

    $response = wp_remote_get($request_url);

    $body_response = json_decode($response['body'], true);


    if (!isset($body_response['items'])) {
        return [];
    }

    //Save youtube data into db
    $data_to_save = [
        'json' => json_encode($body_response['items']),
        'date' => date('Y-m-d H:m:i')
    ];

    update_option('youtube_feed', $data_to_save);

    return $body_response['items'];
}

/**
 * Theme helpers functions
 */
function render_column_items($field_name)
{
    global $post;

    while(have_rows($field_name)): the_row();
        echo '<div class="borders">';

        while(have_rows('insights_col_rows')): the_row();
            $layout = get_row_layout();

            switch ($layout):
                case 'insights_col_title':
                    get_template_part('flexible_items/block', 'title');
                    break;
                case 'insights_col_text':
                    get_template_part('flexible_items/block', 'text');
                    break;
                case 'insights_col_image':
                    get_template_part('flexible_items/block', 'image');
                    break;
            endswitch;
        endwhile;
        echo '</div>';
    endwhile;
}

add_filter('acf/load_field/name=youtube_playlist', 'youtube_playlist_select');

function youtube_playlist_select($field)
{
    $youtube_api_key = get_field('youtube_api_key', 'option');
    $youtube_channel_id = get_field('youtube_channel_id', 'option');

    if (!$youtube_api_key || !$youtube_channel_id) {
        $field['choices'][] = 'First you have to setup API key and channel ID';

        return $field;
    }

    //Load data from YouTube API
    $request_url = 'https://www.googleapis.com/youtube/v3/playlists?part=snippet&channelId='.$youtube_channel_id.'&key='.$youtube_api_key;

    $response = wp_remote_get($request_url);

    $body_response = json_decode($response['body'], true);

    $items = $body_response['items'];

    foreach ($items as $item) {
        $field['choices'][$item['id']] = $item['snippet']['title'];
    }

    return $field;
}

function hex2rgb( $colour ) {
    if ( $colour[0] == '#' ) {
        $colour = substr( $colour, 1 );
    }
    if ( strlen( $colour ) == 6 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[1], $colour[2] . $colour[3], $colour[4] . $colour[5] );
    } elseif ( strlen( $colour ) == 3 ) {
        list( $r, $g, $b ) = array( $colour[0] . $colour[0], $colour[1] . $colour[1], $colour[2] . $colour[2] );
    } else {
        return false;
    }
    $r = hexdec( $r );
    $g = hexdec( $g );
    $b = hexdec( $b );
    return array( 'red' => $r, 'green' => $g, 'blue' => $b );
}

function hex2rgba($colour, $opacity)
{
    $rgb = hex2rgb($colour);

    return $rgb['red'].', '.$rgb['green'].', '.$rgb['blue'].', '.$opacity;
}

function renderBackgroundStyles($image, $color)
{
    if (!$image && !$color) {
        return;
    }
    
    return sprintf(
        'style="%s%sbackground-position: center center;background-repeat: no-repeat;background-size: cover;"', 
        $color ? sprintf('background-color: %s;', $color) : null, 
        sprintf('background-image: url(%s);', $image ?: 'none')
    );
}

/**
 * Function that will update ACF fields via JSON file update
 */
function jp_sync_acf_fields() {

	// vars
	$groups = acf_get_field_groups();
	$sync 	= array();

	// bail early if no field groups
	if( empty( $groups ) )
		return;

	// find JSON field groups which have not yet been imported
	foreach( $groups as $group ) {
		
		// vars
		$local 		= acf_maybe_get( $group, 'local', false );
		$modified 	= acf_maybe_get( $group, 'modified', 0 );
		$private 	= acf_maybe_get( $group, 'private', false );
		
		// ignore DB / PHP / private field groups
		if( $local !== 'json' || $private ) {
			
			// do nothing
			
		} elseif( ! $group[ 'ID' ] ) {
			
			$sync[ $group[ 'key' ] ] = $group;
			
		} elseif( $modified && $modified > get_post_modified_time( 'U', true, $group[ 'ID' ], true ) ) {
			
			$sync[ $group[ 'key' ] ]  = $group;
		}
	}

	// bail if no sync needed
	if( empty( $sync ) )
		return;

	if( ! empty( $sync ) ) { //if( ! empty( $keys ) ) {
		
		// vars
		$new_ids = array();
		
		foreach( $sync as $key => $v ) { //foreach( $keys as $key ) {
			
			// append fields
			if( acf_have_local_fields( $key ) ) {
				
				$sync[ $key ][ 'fields' ] = acf_get_local_fields( $key );
				
			}
			// import
			$field_group = acf_import_field_group( $sync[ $key ] );
		}
	}
}
add_action( 'acf/init', 'jp_sync_acf_fields' );