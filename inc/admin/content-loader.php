<?php

function aac_get_published_posts_count()
{
    $count = wp_count_posts('post')->publish;
    return intval($count);
}

function aac_get_auto_users_count()
{
    $user_count = count_users();
    $total = isset($user_count['total_users']) ? intval($user_count['total_users']) : 0;


    return number_format($total, 0, '.', '٬');
}


function aac_get_published_courses_count()
{

    $count_posts = wp_count_posts('courses');

    if (isset($count_posts->publish)) {
        return intval($count_posts->publish);
    }

    return 0;
}

function aac_get_tutor_enrolled_count()
{
    global $wpdb;

    $manual_mode = aac_settings('number-of-students-manual');

    $is_auto = filter_var($manual_mode, FILTER_VALIDATE_BOOLEAN);

    if ($is_auto) {
        $count = $wpdb->get_var("
            SELECT COUNT(*) 
            FROM {$wpdb->prefix}posts 
            WHERE post_type = 'tutor_enrolled'
        ");
        return intval($count);
    } else {
        return intval(aac_settings('number-of-students'));
    }
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
