<?php

add_action('rest_api_init', 'Services');
add_action('rest_api_init', 'News');
add_action('rest_api_init', 'Doctors');


// Services API
function Services()
{
    register_rest_route('services/v1', 'all', [
        'method' => WP_REST_SERVER::READABLE,
        'callback' => 'getServices',
    ]);
}

function getServices()
{
    $services = get_posts(array(
        'post_type' => 'services',
        'post_status' => 'publish',
        'posts_per_page' => -1
    ));

    $data = [];
    foreach ($services as $service => $value) {
        $data[$service]['title'] = $value->post_title;
        $data[$service]['icon'] = get_post_meta($value->ID)['icon'][0];
        $data[$service]['description'] = substr(get_post_meta($value->ID)['description'][0], 0, 125);
        $data[$service]['content'] =  get_post_meta($value->ID)['content'][0];
        $data[$service]['link'] = esc_url(get_permalink($value->ID));
    }
    return $data;
}

// News API
function News()
{
    register_rest_route('news/v1', 'all', [
        'method' => WP_REST_SERVER::READABLE,
        'callback' => 'getNews',
    ]);
}

function getNews()
{
    $news = get_posts(array(
        'post_type' => 'news',
        'post_status' => 'publish',
        'posts_per_page' => -1
    ));

    $data = [];
    foreach ($news as $key => $value) {
        $data[$key]['title'] = $value->post_title;
        $data[$key]['description'] =  substr(get_post_meta($value->ID)['description'][0], 0, 50) . '...';
        $data[$key]['content'] =  get_post_meta($value->ID)['content'][0];
        $data[$key]['link'] = esc_url(get_permalink($value->ID));
    }
    return $data;
}


// Doctors API
function Doctors()
{
    register_rest_route('doctors/v1', 'all', [
        'method' => WP_REST_SERVER::READABLE,
        'callback' => 'getDoctors',
    ]);
}

function getDoctors()
{
    $news = get_posts(array(
        'post_type' => 'doctors',
        'post_status' => 'publish',
        'posts_per_page' => -1
    ));

    $data = [];
    foreach ($news as $key => $value) {
        $data[$key]['title'] = $value->post_title;
        $data[$key]['description'] =  get_post_meta($value->ID)['description'][0];
        $data[$key]['image'] = wp_get_attachment_image_url(get_post_meta($value->ID)['image'][0], 'full');
        $data[$key]['content'] =  get_post_meta($value->ID)['content'][0];
        $data[$key]['link'] = esc_url(get_permalink($value->ID));
    }
    return $data;
}
