<?php

define('MEMBER_POST_TYPE', 'geo_member');
define('TAX_MEMBERS_TABS', 'geo_tab');
add_action('init', 'setup_members_post_type');

function setup_members_post_type()
{
    register_taxonomy(TAX_MEMBERS_TABS, MEMBER_POST_TYPE, [
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

    register_post_type(MEMBER_POST_TYPE, [
        'label' => 'Members',
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
add_filter('gettext','geopath_custom_enter_title');

function geopath_custom_enter_title( $input ) {

    global $post_type;

    if( is_admin() && 'Enter title here' == $input && MEMBER_POST_TYPE == $post_type )
        return 'Enter Company Name';

    return $input;
}

/**
 * Add custom columns into library admin table
 */
add_filter( 'manage_geo_member_posts_columns' , 'geo_member_custom_columns', 10, 2 );

function geo_member_custom_columns($columns)
{

    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['title'] = 'Company Name';
    $new_columns['city'] = 'City';
    $new_columns['state'] = 'State';
    $new_columns['tabs'] = 'Tabs';


    return $new_columns;
}

add_action('manage_geo_member_posts_custom_column', 'geo_member_manage_columns_content', 10, 2);

function geo_member_manage_columns_content($column_name, $id)
{
    global $post, $wpdb;

    switch ($column_name) {
        case 'city':
            the_field('member_city', $id);
            break;
        case 'tabs':
            $post_terms = wp_get_object_terms($id, TAX_MEMBERS_TABS, ['fields' => 'names']);
            echo implode(', ', $post_terms);
            break;
        case 'state':
            the_field('member_state', $id);
            break;
    }
}

/**
 * Ajax Request for dataTables
 */
add_action( 'wp_ajax_members_type_items', 'get_members_type_items' );
add_action( 'wp_ajax_nopriv_members_type_items', 'get_members_type_items');

function get_members_type_items()
{
    global $wpdb;

    $term_slug = esc_sql($_GET['cat_slug']);


    $data = ['data' => []];



    $query = new WP_Query([
        'posts_per_page' => -1,
        'post_type' => MEMBER_POST_TYPE,
        'post_status' => 'publish',
        'tax_query' => [
            [
                'taxonomy' => TAX_MEMBERS_TABS,
                'field'    => 'slug',
                'terms'    => $term_slug,
            ]
        ]
    ]);

    foreach ($query->posts as $item) {
        $data['data'][] = [
            $item->post_title,
            get_field('member_city', $item->ID),
            get_field('member_state', $item->ID),
        ];
    }

    echo json_encode($data);
    die();
}

/**
* Changes for member taxonomy box
*/
add_action('admin_menu', 'add_member_admin_box');

function add_member_admin_box()
{
    if (!is_admin()) {
        return;
    }

    add_meta_box('members_tags_box', __('Item Tabs'), 'members_item_box', MEMBER_POST_TYPE, 'side', 'core');

    //Remove default tag boxes
    remove_meta_box('tagsdiv-'.TAX_MEMBERS_TABS, MEMBER_POST_TYPE, 'core');

    add_action('save_post', 'save_members_taxonomy_data');
}

function members_item_box($post)
{
    // Get all theme taxonomy terms
    $tax_terms = get_terms(['taxonomy' => TAX_MEMBERS_TABS]);

    //Get terms defined for post
    $post_terms = wp_get_object_terms($post->ID, TAX_MEMBERS_TABS, ['fields' => 'ids']);

    ?>
        <input type="hidden" name="member_taxonomy_noncename" id="member_taxonomy_noncename" value="<?php echo wp_create_nonce( 'member_taxonomy_noncename' ); ?>" />
        <div class="custom-select2-wrapper">
        <p>Tabs Tags</p>
        <select class="custom-select2" name='member_terms[]' multiple id='member_terms' data-placeholder="Select Member Tab">
            <?php
            foreach($tax_terms as $term):
                $selected = in_array($term->term_id, $post_terms);
                ?>
                <option <?php echo $selected ? 'selected': null; ?> value="<?php echo $term->term_id?>"><?php echo $term->name; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php
}

function save_members_taxonomy_data($post_id)
{
    if ( !isset($_POST['member_taxonomy_noncename']) || !wp_verify_nonce( $_POST['member_taxonomy_noncename'], 'member_taxonomy_noncename' )) {
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
    if ($post->post_type !== MEMBER_POST_TYPE) {
        return $post_id;
    }

    //Create post terms array before save
    $tabs_terms = [];

    foreach ($_POST['member_terms'] as $term) {
        $tabs_terms[] = intval($term);
    }


    //Save replace existsing terms by new
    wp_set_object_terms($post_id, $tabs_terms, TAX_MEMBERS_TABS);

    return $post_id;
}