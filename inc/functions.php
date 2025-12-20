<?php

defined('ABSPATH') || exit('NO Access');


function aac_settings($key = '')
{
    $options = get_option('aac_settings');

    if (!isset($options[$key])) {
        return null;
    }

    return $options[$key];
}

// Calculating daily site visits
function aac_get_real_daily_visits()
{
    if (preg_match('/bot|crawl|slurp|spider|facebook|google|yandex/i', $_SERVER['HTTP_USER_AGENT'])) {
        return get_transient('aac_daily_visits_' . date('Y-m-d')) ?: 0;
    }

    session_start();
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? 'unknown';
    $url = $_SERVER['REQUEST_URI'] ?? '/';
    $today = date('Y-m-d');

    $visitor_id = md5($ip . $ua . $url);
    $visitor_key = 'aac_visitor_' . $visitor_id . '_' . $today;
    $visit_key = 'aac_daily_visits_' . $today;

    if (isset($_SESSION[$visitor_key]) || get_transient($visitor_key)) {
        return get_transient($visit_key) ?: get_option($visit_key, 0);
    }

    $current_visits = get_transient($visit_key);
    if ($current_visits === false) {
        $current_visits = get_option($visit_key, 0);
    }

    $current_visits++;

    set_transient($visitor_key, true, DAY_IN_SECONDS);
    set_transient($visit_key, $current_visits, HOUR_IN_SECONDS);
    update_option($visit_key, $current_visits);
    $_SESSION[$visitor_key] = true;

    return $current_visits;
}

add_action('wp_ajax_aac_remove_from_cart', 'aac_remove_from_cart');
add_action('wp_ajax_nopriv_aac_remove_from_cart', 'aac_remove_from_cart');

function aac_remove_from_cart()
{
    if (!isset($_POST['cart_item_key'])) {
        wp_send_json_error(['message' => 'کلید آیتم موجود نیست']);
    }

    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);

    if (WC()->cart && $item = WC()->cart->get_cart_item($cart_item_key)) {
        WC()->cart->remove_cart_item($cart_item_key);


        wp_send_json_success([
            'redirect' => true
        ]);
    }

    wp_send_json_error(['message' => 'آیتم یافت نشد']);
}


function get_total_lessons_for_course($course_id)
{
    global $wpdb;


    $topic_ids = $wpdb->get_col($wpdb->prepare(
        "SELECT ID FROM {$wpdb->prefix}posts WHERE post_parent = %d AND post_type = 'topics'",
        $course_id
    ));

    $lessons_under_topics = 0;
    if (!empty($topic_ids)) {
        $topic_ids_placeholder = implode(',', array_map('intval', $topic_ids));
        $lessons_under_topics = (int) $wpdb->get_var(
            "SELECT COUNT(*) FROM {$wpdb->prefix}posts WHERE post_parent IN ($topic_ids_placeholder) AND post_type = 'lesson'"
        );
    }


    $direct_lessons = (int) $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM {$wpdb->prefix}posts WHERE post_parent = %d AND post_type = 'lesson'",
        $course_id
    ));

    return $lessons_under_topics + $direct_lessons;
}

add_action('init', function () {
    global $wpdb;

    $orphan_lessons = $wpdb->get_col("
		SELECT l.ID
		FROM {$wpdb->prefix}posts l
		LEFT JOIN {$wpdb->prefix}postmeta cm 
			ON l.ID = cm.post_id AND cm.meta_key = 'course_id'
		WHERE l.post_type = 'lesson'
		  AND l.post_status = 'publish'
		  AND cm.meta_id IS NULL
	");

    if (!empty($orphan_lessons)) {
        foreach ($orphan_lessons as $lesson_id) {
            wp_delete_post($lesson_id, true);
        }
    }
});

