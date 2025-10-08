<?php

function aac_get_published_posts_count()
{
    $count = wp_count_posts('post')->publish;
    return intval($count);
}

function aac_get_published_courses_count()
{

    $count_posts = wp_count_posts('courses');

    if (isset($count_posts->publish)) {
        return intval($count_posts->publish);
    }

    return 0;
}
function aac_get_tutor_enrolled_count() {
    global $wpdb;

    $count = $wpdb->get_var("
        SELECT COUNT(DISTINCT p.post_author)
        FROM {$wpdb->prefix}posts p
        WHERE p.post_type = 'tutor_enrolled'
    ");

    return intval($count);
}



function aac_get_daily_visits()
{
    $manual_mode = aac_settings('daily-visit-manual');
    $is_auto = filter_var($manual_mode, FILTER_VALIDATE_BOOLEAN);

    if ($is_auto) {
        return aac_get_real_daily_visits();
    } else {
        return intval(aac_settings('daily-visit'));
    }
}
