<?php

define('LIBRARY_POST_TYPE', 'library');
define('TAX_AUDIENCE', 'audience');
define('TAX_INDUSTRY', 'industry');
define('TAX_CONTENT_TYPE', 'content_type');
define('LIBRARY_ITEMS_PER_PAGE', 6);

add_action('init', 'setup_library_post_types');

function setup_library_post_types()
{
    $filter_1_name = get_field('filter_1_name', 'option');
    $filter_2_name = get_field('filter_2_name', 'option');
    $filter_3_name = get_field('filter_3_name', 'option');

    register_taxonomy(TAX_INDUSTRY, LIBRARY_POST_TYPE, [
        'label' => $filter_1_name ? $filter_1_name : 'Filter 1',
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

    register_taxonomy(TAX_AUDIENCE, LIBRARY_POST_TYPE, [
        'label' => $filter_2_name ? $filter_2_name : 'Filter 2',
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

    register_taxonomy(TAX_CONTENT_TYPE, LIBRARY_POST_TYPE, [
        'label' => $filter_3_name ? $filter_3_name : 'Filter 3',
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


    register_post_type(LIBRARY_POST_TYPE, [
        'label' => 'Library',
        'labels' => [
            //'singular_name' => 'Item',
            'add_new_item' => 'Add New Item',
            'edit_item' => 'Edit Item',
            'new_item' => 'New Item',
            'view_item' => 'View Item',
            'search_items' => 'Search Items',
            'all_items' => 'All Items',
            'not_found' => 'No Item found',
            'not_found_in_trash' => 'No items found in Trash'
        ],
        'exclude_from_search' => false,
        'publicly_queryable' => false,
        //'public' => true,
        'show_ui' => true,
        'show_in_nav_menus' => false,
        'show_in_menu' => true,
        'menu_positio' => 20,
        'hierarchical' => false,
        'supports' => ['title', 'thumbnail'],
        'taxonomies' => [TAX_AUDIENCE, TAX_CONTENT_TYPE, TAX_INDUSTRY]
    ]);
}

/**
 * Display a custom taxonomy dropdown in admin
 * @author Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_action('restrict_manage_posts', 'tsm_filter_post_type_by_taxonomy');

function tsm_filter_post_type_by_taxonomy() {
    global $typenow;

    if ($typenow == LIBRARY_POST_TYPE) {

        $selected      = isset($_GET[TAX_CONTENT_TYPE]) ? $_GET[TAX_CONTENT_TYPE] : '';
        $info_taxonomy = get_taxonomy(TAX_CONTENT_TYPE);

        wp_dropdown_categories(array(
            'show_option_all' => __("Show All {$info_taxonomy->label}"),
            'taxonomy'        => TAX_CONTENT_TYPE,
            'name'            => 'content_type',
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => true,
            'hide_empty'      => true,
        ));

        $selected      = isset($_GET[TAX_AUDIENCE]) ? $_GET[TAX_AUDIENCE] : '';
        $info_taxonomy = get_taxonomy(TAX_AUDIENCE);

        wp_dropdown_categories(array(
            'show_option_all' => __("Show All {$info_taxonomy->label}"),
            'taxonomy'        => TAX_AUDIENCE,
            'name'            => 'audience',
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => true,
            'hide_empty'      => true,
        ));

        $selected      = isset($_GET[TAX_INDUSTRY]) ? $_GET[TAX_INDUSTRY] : '';
        $info_taxonomy = get_taxonomy(TAX_INDUSTRY);

        wp_dropdown_categories(array(
            'show_option_all' => __("Show All {$info_taxonomy->label}"),
            'name'            => TAX_INDUSTRY,
            'taxonomy'        => 'industry',
            'orderby'         => 'name',
            'selected'        => $selected,
            'show_count'      => true,
            'hide_empty'      => true,
        ));
    };
}
/**
 * Filter posts by taxonomy in admin
 * @author  Mike Hemberger
 * @link http://thestizmedia.com/custom-post-type-filter-admin-custom-taxonomy/
 */
add_filter('parse_query', 'tsm_convert_id_to_term_in_query');
function tsm_convert_id_to_term_in_query($query) {
    global $pagenow;

    $taxonomies  = [TAX_CONTENT_TYPE, TAX_AUDIENCE, TAX_INDUSTRY];
    $q_vars = &$query->query_vars;

    if ($pagenow == 'edit.php' && isset($q_vars['post_type']) && $q_vars['post_type'] == LIBRARY_POST_TYPE) {

        foreach ($taxonomies as $taxonomy) {
            if (isset($q_vars[$taxonomy]) && is_numeric($q_vars[$taxonomy]) && $q_vars[$taxonomy] != 0) {
                $term = get_term_by('id', $q_vars[$taxonomy], $taxonomy);
                $q_vars[$taxonomy] = $term->slug;
            }
        }
    }
}

/**
 * Add custom columns into library admin table
 */
add_filter( 'manage_library_posts_columns' , 'library_custom_columns', 10, 2 );

function library_custom_columns($columns)
{

    $new_columns['cb'] = '<input type="checkbox" />';
    $new_columns['thumbnail'] = 'Thumbnail';
    $new_columns['title'] = 'Title';

    $new_columns['content_type'] = 'Content Type Tags';
    $new_columns['audience'] = 'Audience Tags';
    $new_columns['industry'] = 'Industry Tags';
    $new_columns['date'] = 'Date';


    return $new_columns;
}

add_action('manage_library_posts_custom_column', 'library_manage_columns_content', 10, 2);
function library_manage_columns_content($column_name, $id)
{
    global $wpdb;

    switch ($column_name) {
        case TAX_CONTENT_TYPE:
            $post_terms = wp_get_object_terms($id, TAX_CONTENT_TYPE, ['fields' => 'names']);
            echo implode(', ', $post_terms);
            break;
        case TAX_AUDIENCE:
            $post_terms = wp_get_object_terms($id, TAX_AUDIENCE, ['fields' => 'names']);
            echo implode(', ', $post_terms);
            break;
        case TAX_INDUSTRY:
            $post_terms = wp_get_object_terms($id, TAX_INDUSTRY, ['fields' => 'names']);
            echo implode(', ', $post_terms);
            break;
        case 'thumbnail':
            echo get_the_post_thumbnail($id, 'thumbnail');
            break;
    }
}

/**
 * Search Items by AJAX request
 */
add_action( 'wp_ajax_search_library_items', 'search_library_items' );
add_action( 'wp_ajax_nopriv_search_library_items', 'search_library_items');

function search_library_items()
{
    $args = [
        'post_type' => LIBRARY_POST_TYPE,
        'post_status' => 'publish',
        'posts_per_page' => LIBRARY_ITEMS_PER_PAGE,
        'cache_results'  => false,
        'paged' => 1
    ];

    $query_data = [];

    if (isset($_GET['page'])) {
        $args['paged'] = intval($_GET['page']);
    }

    parse_str($_GET['data'], $query_data);

    //Create tax query
    $tax_query = get_library_tax_query($query_data);

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    //Create date query
    $date_query = get_library_date_query($query_data);

    if (!empty($date_query)) {
        $args['date_query'] = $date_query;
    }

    $query = new WP_Query($args);


    //Render html response
    $blocks = [];

    foreach ($query->posts as $post) {
        ob_start();

        render_library_block($post);
        $blocks[] = ob_get_contents();

        ob_end_clean();
    }

    //Create response json
    $response = [
        'found_posts' => intval($query->found_posts),
        'max_num_page' => $query->max_num_pages,
        'posts_per_page' => LIBRARY_ITEMS_PER_PAGE,
        'blocks' => $blocks
    ];

    echo json_encode($response);
    die();
}

function get_library_date_query($query_data)
{
    $date_query = [];

    if (!isset($query_data['date'])) {
        return [];
    }

    foreach ($query_data['date'] as $date) {
        $date_arr = explode('_', $date);

        $month = isset($date_arr[1]) ? $date_arr[1] : null;
        $year = isset($date_arr[2]) ? $date_arr[2] : null;

        if ($month && $year) {
            $date_query[] = [
                'month' => $month,
                'year' => $year
            ];
        }
    }

    if (count($date_query) > 1) {
        $date_query['relation'] = 'OR';
    }

    return $date_query;
}

function get_library_tax_query($query_data)
{
    $allowed_taxes = [
        TAX_CONTENT_TYPE,
        TAX_AUDIENCE,
        TAX_INDUSTRY
    ];

    $tax_query = [];

    foreach($query_data as $taxonomy => $terms_ids) {

        if (in_array($taxonomy, $allowed_taxes)) {
            $tax_query[] = [
                'taxonomy' => $taxonomy,
                'field' => 'term_id',
                'terms' => array_values($terms_ids),
                'operator' => 'IN'
            ];
        }
    }

    if (count($tax_query) > 1) {
        $tax_query['relation'] = 'OR';
    }

    return $tax_query;
}

/**
 * HTML helpers functions
 */
function render_select_lib_options($tax_slug) {
    $terms = get_terms([
        'taxonomy' => $tax_slug,
        'hide_empty' => true
    ]);

    foreach ($terms as $term) {
        echo '<option value="'.$term->term_id.'" class="'.$tax_slug.'_'.$term->term_id.'">'.$term->name.'</option>';
    }
}

function render_select_mont_options()
{
    global $wpdb; // Don't forget

    $collection = $wpdb->get_results("
          SELECT YEAR(p.post_date) AS post_year, MONTH(p.post_date) as post_month_num, MONTHNAME(p.post_date) AS post_month
          FROM {$wpdb->posts} AS p
          WHERE p.post_type = '".LIBRARY_POST_TYPE."' AND p.post_status = 'publish'
          GROUP BY post_month, post_year
          ORDER BY p.post_date DESC
    ", OBJECT );


    foreach ($collection as $month_item) {
        $date_value = 'date_'.$month_item->post_month_num.'_'.$month_item->post_year;

        echo '<option value="'.$date_value.'" class="'.$date_value.'">'.$month_item->post_month . ' '. $month_item->post_year .'</option>';
    }
}

function render_library_block($item)
{
    if (has_post_thumbnail($item->ID)) {
        $post_thumbnail_url = get_the_post_thumbnail_url($item->ID, 'full');
    }

    $terms_collection = wp_get_object_terms($item->ID, [TAX_CONTENT_TYPE, TAX_AUDIENCE, TAX_INDUSTRY]);

    $content_type_tags = array_filter($terms_collection, function($item) { return $item->taxonomy == TAX_CONTENT_TYPE;});
    $article_title =  implode(' ', array_map(function($term){ return $term->name; }, $content_type_tags));
    $brief_text  =  wp_trim_words(get_field('brief_description', $item->ID), 40 ,'...');
    $item_title = $item->post_title;

    $file_data = get_field('file', $item->ID);
    $file_name = isset($file_data['filename']) ? $file_data['filename'] : null;
    $file_url= isset($file_data['url']) ? $file_data['url'] : null;


    ?>
        <div class="grid-item grid-item col-sm-6 col-xs-12 col-md-4 item-container <?php echo get_item_categories($terms_collection, $item); ?>">
            <a href="<?php echo $file_url; ?>" target="_blank" download="<?php echo $file_name; ?>" class="library-item-link" >
                <div class="grid-item-img"
                    <?php echo isset($post_thumbnail_url) ? 'style="background-image: url('. $post_thumbnail_url .')"' : null; ?>
                >
                    <div></div>
                </div>
                <div class="item-description">
                    <h2><?php echo $article_title; ?></h2>
                    <h3><?php echo $item_title; ?></h3>
                    <p><?php echo $brief_text; ?></p>
                </div>
            </a>
        </div>
    <?php
}

function get_item_categories($terms_collection, $item)
{
    $terms = [];
    foreach ($terms_collection as $term) {
        $terms[] = $term->taxonomy.'_'.$term->term_id;
    }

    $classes = implode(' ', $terms);

    //Add class with date
    $post_date  = strtotime($item->post_date);
    $classes .= ' date_'.date('n', $post_date).'_'.date('Y', $post_date);

    return $classes;
}

/**
 * Changes for tag/taxonomy admin box
 */
add_action('admin_menu', 'add_library_admin_box');

function add_library_admin_box()
{
    if (!is_admin()) {
        return;
    }

    add_meta_box('library_tags_box', __('Item Tags'), 'library_item_box', LIBRARY_POST_TYPE, 'side', 'core');

    //Remove default tag boxes
    remove_meta_box('tagsdiv-'.TAX_INDUSTRY, LIBRARY_POST_TYPE, 'core');
    remove_meta_box('tagsdiv-'.TAX_AUDIENCE, LIBRARY_POST_TYPE, 'core');
    remove_meta_box('tagsdiv-'.TAX_CONTENT_TYPE, LIBRARY_POST_TYPE, 'core');

    add_action('save_post', 'save_library_taxonomy_data');
}

function library_item_box($post)
{
    // Get all theme taxonomy terms
    $audience_terms = get_terms(['taxonomy' => TAX_AUDIENCE]);
    $content_type_terms = get_terms(['taxonomy' => TAX_CONTENT_TYPE]);
    $industries_terms = get_terms(['taxonomy' => TAX_INDUSTRY]);

    //Get terms defined for post
    $post_audience_terms = wp_get_object_terms($post->ID, TAX_AUDIENCE, ['fields' => 'ids']);
    $post_content_type_terms = wp_get_object_terms($post->ID, TAX_CONTENT_TYPE, ['fields' => 'ids']);
    $post_industries_terms = wp_get_object_terms($post->ID, TAX_INDUSTRY, ['fields' => 'ids']);

    ?>
    <input type="hidden" name="library_taxonomy_noncename" id="library_taxonomy_noncename" value="<?php echo wp_create_nonce( 'library_taxonomy_noncename' ); ?>" />
        <div class="custom-select2-wrapper">
            <p>Audience Tags</p>
            <select class="custom-select2" name='audience_terms[]' multiple id='audience_terms' data-placeholder="Select Audience Tags">
                <?php
                    foreach($audience_terms as $term):
                        $selected = in_array($term->term_id, $post_audience_terms);
                    ?>
                    <option <?php echo $selected ? 'selected': null; ?> value="<?php echo $term->term_id?>"><?php echo $term->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="custom-select2-wrapper">
            <p>Industries Tags</p>
            <select class="custom-select2" name='industries_terms[]' multiple id='industries_terms' data-placeholder="Select Industries Tags">
                <?php
                    foreach($industries_terms as $term):
                        $selected = in_array($term->term_id, $post_industries_terms);
                        ?>
                    <option <?php echo $selected ? 'selected': null; ?> value="<?php echo $term->term_id?>"><?php echo $term->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="custom-select2-wrapper">
            <p>Content Type Tags</p>
            <select class="custom-select2" name='content_type_terms[]' multiple id='content_type_terms' data-placeholder="Select Content Type Tags">
                <?php foreach($content_type_terms as $term): ?>
                    <?php $selected = in_array($term->term_id, $post_content_type_terms); ?>
                    <option <?php echo $selected ? 'selected': null; ?>  value="<?php echo $term->term_id?>"><?php echo $term->name; ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    <?php
}

function save_library_taxonomy_data($post_id)
{
    if (!isset($_POST['library_taxonomy_noncename']) || !wp_verify_nonce( $_POST['library_taxonomy_noncename'], 'library_taxonomy_noncename' )) {
        return $post_id;
    }

    // verify if this is an auto save routine. If it is our form has not been submitted, so we dont want to do anything
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return $post_id;

    if (!current_user_can('edit_page', $post_id))
        return $post_id;

    //Now we can save terms into the post
    $library_item = get_post($post_id);

    //Allow only for library post types
    if ($library_item->post_type !== LIBRARY_POST_TYPE) {
        return $post_id;
    }

    //Create post terms array before save
    $industries_terms = [];
    $content_types_terms = [];
    $audience_terms = [];

    if (isset($_POST['industries_terms']) && count($_POST['industries_terms'])) {
        foreach ($_POST['industries_terms'] as $term) {
            $industries_terms[] = intval($term);
        }
    }

    if (isset($_POST['content_type_terms']) && count($_POST['content_type_terms'])) {
        foreach ($_POST['content_type_terms'] as $term) {
            $content_types_terms[] = intval($term);
        }
    }

    if (isset($_POST['audience_terms']) && count($_POST['audience_terms'])) {
        foreach ($_POST['audience_terms'] as $term) {
            $audience_terms[] = intval($term);
        }
    }

    //Save replace existsing terms by new
    wp_set_object_terms($post_id, $industries_terms, TAX_INDUSTRY);
    wp_set_object_terms($post_id, $content_types_terms, TAX_CONTENT_TYPE);
    wp_set_object_terms($post_id, $audience_terms, TAX_AUDIENCE);

    return $post_id;
}