<?php
function twentytwentyone_child_enqueue_styles() {
    // Parent theme ki CSS ko dequeue karein
    wp_dequeue_style('twenty-twenty-one-style');
    wp_deregister_style('twenty-twenty-one-style');
    
    // Child theme ki custom CSS ko enqueue karein
    wp_enqueue_style('child-style', get_stylesheet_directory_uri() . '/css/custom-style.css');
}
add_action('wp_enqueue_scripts', 'twentytwentyone_child_enqueue_styles', 20);


register_nav_menus(array("header-menu" => "header menu"));
wp_get_nav_menu_items('primary', array('order' => 'ASC'));

add_theme_support('post-thumbnails');

// Register the Event CPT and Taxonomy
function create_event_post_type() {
    register_post_type('event',
        array(
            'labels' => array(
                'name' => 'Events',
                'singular_name' => 'Event'
            ),
            'public' => true,
            'supports' => array('title', 'editor', 'thumbnail','excerpt'),
            'has_archive' => true,
           
        )
    );
    
    register_taxonomy('event_category', 'event', array(
        'label' => 'Event Categories',
        'rewrite' => array('slug' => 'event-category'),
        'hierarchical' => true,
        'show_admin_column' => true
    ));
}
add_action('init', 'create_event_post_type');

// Enqueue jQuery and Localize Script
function my_theme_enqueue_scripts() {
    wp_enqueue_script('jquery'); // Load jQuery
    wp_enqueue_script('event-script', get_stylesheet_directory_uri() . '/js/event-script.js', array('jquery'), null, true);
    wp_localize_script('event-script', 'event_ajax', array('ajaxurl' => admin_url('admin-ajax.php')));
}
add_action('wp_enqueue_scripts', 'my_theme_enqueue_scripts');

// Handle Event Submission
function handle_event_submission() {
    if (!isset($_POST['_wpnonce']) || !wp_verify_nonce($_POST['_wpnonce'], 'event_submission_nonce')) {
        wp_send_json_error(['message' => 'Invalid nonce']);
    }

    if (!isset($_POST['title']) || !isset($_POST['content']) || !isset($_POST['category'])) {
        wp_send_json_error(['message' => 'Missing required fields']);
    }

    $title = $_POST['title'];
    $content = $_POST['content'];
    $excerpt = $_POST['excerpt'];
    $category_id = intval($_POST['category']);

    $event_id = wp_insert_post([
        'post_title'   => $title,
        'post_content' => $content,
        'post_excerpt' => $excerpt,
        'post_type'    => 'event',
        'post_status'  => 'publish'
    ]);

    wp_set_post_terms($event_id, [$category_id], 'event_category');

    // Handle Image Upload
   

        $upload = wp_handle_upload($_FILES['thumbnail'], ['test_form' => false]);

        if (!isset($upload['error']) && isset($upload['file'])) {
            $attachment_id = wp_insert_attachment([
                'post_mime_type' => $upload['type'],
                'post_title'     => $_FILES['thumbnail']['name'],
                'post_content'   => '',
                'post_status'    => 'inherit',
                'post_parent'    => $event_id,
            ], $upload['file'], $event_id);

            if (!is_wp_error($attachment_id)) {
                $attach_data = wp_generate_attachment_metadata($attachment_id, $upload['file']);
                wp_update_attachment_metadata($attachment_id, $attach_data);
                set_post_thumbnail($event_id, $attachment_id);
                wp_send_json_success(['message' => 'Event submitted successfully!']);
            }
        }
    }

 

add_action('wp_ajax_handle_event_submission', 'handle_event_submission');
add_action('wp_ajax_nopriv_handle_event_submission', 'handle_event_submission');


add_filter('show_admin_bar', '__return_false');
?>

