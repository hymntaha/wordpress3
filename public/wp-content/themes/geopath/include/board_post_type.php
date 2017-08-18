<?php

define('BOARD_POST_TYPE', 'geo_board');
define('TAX_BOARD_TABS', 'geo_tab_board');
add_action('init', 'setup_board_post_type');

function setup_board_post_type()
{
    register_taxonomy(TAX_BOARD_TABS, BOARD_POST_TYPE, [
        'label' => 'Tabs',
        'labels' => [
            'singular_name' => 'Tag',
        ],
        'show_in_menu' => true,
        'show_in_quick_edit' => true,
        'show_in_nav_menus' => false,
        'show_tagcloud' => false,
        'hierarchical' => false,
        'capabilities' => [
            'manage_terms' => 'manage_options', //by default only admin
            'edit_terms' => 'manage_options',
            'delete_terms' => 'manage_options',
            'assign_terms' => 'edit_posts'  // means administrator', 'editor', 'author', 'contributor'
        ]
    ]);

    register_post_type(BOARD_POST_TYPE, [
        'label' => 'Board',
        'labels' => [
            'add_new_item' => 'Add New Member',
            'edit_item' => 'Edit Member',
            'new_item' => 'New Member',
            'view_item' => 'View Member',
            'search_items' => 'Search Members',
            'all_items' => 'All Members',
            'not_found' => 'No Member found',
            'not_found_in_trash' => 'No member found in Trash'
        ],
        'exclude_from_search' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_nav_menus' => false,
        'show_in_menu' => true,
        'menu_positio' => 20,
        'hierarchical' => false,
        'supports' => ['title'],
    ]);
}

//Rename title placeholder
add_filter('gettext','geopath_custom_board_enter_title');

function geopath_custom_board_enter_title( $input ) {

    global $post_type;

    if( is_admin() && 'Enter title here' == $input && BOARD_POST_TYPE == $post_type )
        return 'Enter Company Name';

    return $input;
}

/**
 * Add custom columns into library admin table
 */
add_filter( 'manage_geo_board_posts_columns' , 'geo_board_custom_columns', 10, 2 );

function geo_board_custom_columns($columns)
{

    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['title'] = 'Company';
    $new_columns['name'] = 'Name';
    $new_columns['member_title'] = 'Title';
    $new_columns['tabs'] = 'Tabs';


    return $new_columns;
}

add_action('manage_geo_board_posts_custom_column', 'geo_board_manage_columns_content', 10, 2);

function geo_board_manage_columns_content($column_name, $id)
{
    global $post, $wpdb;

    switch ($column_name) {
        case 'name':
            the_field('member_contact', $id);
            break;
        case 'tabs':
            $post_terms = wp_get_object_terms($id, TAX_BOARD_TABS, ['fields' => 'names']);
            echo implode(', ', $post_terms);
            break;
        case 'member_title':
            the_field('member_title', $id);
            break;
    }
}

/**
 * Ajax Request for dataTables
 */
add_action( 'wp_ajax_board_type_items', 'get_board_type_items' );
add_action( 'wp_ajax_nopriv_board_type_items', 'get_board_type_items');

function get_board_type_items()
{
    global $wpdb;

    $term_slug = esc_sql($_GET['cat_slug']);


    $data = ['data' => []];



    $query = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => BOARD_POST_TYPE,
        'post_status' => 'publish',
        'tax_query' => [
            [
                'taxonomy' => TAX_BOARD_TABS,
                'field'    => 'slug',
                'terms'    => $term_slug,
            ]
        ]
    ]);

    foreach ($query->posts as $item) {
        $data['data'][] = [
            get_field('member_contact', $item->ID),
            get_field('member_title', $item->ID),
            $item->post_title, //company
        ];
    }

    echo json_encode($data);
    die();
}

/**
 * Changes for board taxonomy box
 */
add_action('admin_menu', 'add_board_admin_box');

function add_board_admin_box()
{
    if (!is_admin()) {
        return;
    }

    add_meta_box('board_tags_box', __('Item Tabs'), 'board_item_box', BOARD_POST_TYPE, 'side', 'core');

    //Remove default tag boxes
    remove_meta_box('tagsdiv-'.TAX_BOARD_TABS, BOARD_POST_TYPE, 'core');

    add_action('save_post', 'save_board_taxonomy_data');
}

function board_item_box($post)
{
    // Get all theme taxonomy terms
    $board_terms = get_terms(['taxonomy' => TAX_BOARD_TABS]);

    //Get terms defined for post
    $post_terms = wp_get_object_terms($post->ID, TAX_BOARD_TABS, ['fields' => 'ids']);

    ?>
    <input type="hidden" name="board_taxonomy_noncename" id="board_taxonomy_noncename" value="<?php echo wp_create_nonce( 'board_taxonomy_noncename' ); ?>" />
    <div class="custom-select2-wrapper">
        <p>Tabs Tags</p>
        <select class="custom-select2" name='board_terms[]' multiple id='board_terms' data-placeholder="Select Board Tab">
            <?php
            foreach($board_terms as $term):
                $selected = in_array($term->term_id, $post_terms);
                ?>
                <option <?php echo $selected ? 'selected': null; ?> value="<?php echo $term->term_id?>"><?php echo $term->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php
}

function save_board_taxonomy_data($post_id)
{
    if ( !isset($_POST['board_taxonomy_noncename']) || !wp_verify_nonce( $_POST['board_taxonomy_noncename'], 'board_taxonomy_noncename' )) {
        return $post_id;
    }

    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if (!current_user_can('edit_page', $post_id))
        return $post_id;

    //Now we can save terms into the post
    $post = get_post($post_id);

    //Allow only for library post types
    if ($post->post_type !== BOARD_POST_TYPE) {
        return $post_id;
    }

    //Create post terms array before save
    $tabs_terms = [];

    foreach ($_POST['board_terms'] as $term_id) {
        $tabs_terms [] = intval($term_id);
    }


    //Save replace existsing terms by new
    wp_set_object_terms($post_id, $tabs_terms, TAX_BOARD_TABS);

    return $post_id;
}