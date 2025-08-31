<?php

// Create a menu on the tutor dashboard

add_filter('tutor_dashboard/nav_items', function ($nav_items) {


    $nav_items['tickets'] = [
        'title' => 'تیکت ها',
        'icon' => 'tickets-icon',
        'url' => tutor_utils()->get_tutor_dashboard_page_permalink('tickets'),
        'order' => 99,
        'show' => current_user_can('subscriber') || current_user_can('teacher'),
    ];

    return $nav_items;
});

add_filter('tutor_dashboard/nav_items', function ($nav_items) {


    $nav_items['new-ticket'] = [
        'url' => tutor_utils()->get_tutor_dashboard_page_permalink('tickets'),

    ];

    return $nav_items;
});

add_filter('tutor_dashboard/nav_items', function ($nav_items) {


    $nav_items['single-ticket'] = [
        'url' => tutor_utils()->get_tutor_dashboard_page_permalink('tickets'),
    ];
    
    return $nav_items;
});







