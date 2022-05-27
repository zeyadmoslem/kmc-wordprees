<?php

add_action('rest_api_init', 'Services');


// Services API
function Services()
{
    register_rest_route('services/v1', 'all' , [
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
        $data[$service]['description'] = get_post_meta($value->ID)['description'][0];
        $data[$service]['content'] =  substr(get_post_meta($value->ID)['content'][0], 0, 125);
        $data[$service]['link'] = esc_url(get_permalink($value->ID));
    }
    return $data;
}
