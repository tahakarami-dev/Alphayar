<?php

namespace Elementor;

if (!defined('ABSPATH')) exit;

class AAC_Course_Lessons_Count_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'course_lessons_count';
    }

    public function get_title() {
        return 'تعداد جلسات دوره';
    }

    public function get_group() {
        return 'post';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    public function render() {
        global $post;

        if (!$post || get_post_type($post->ID) !== 'courses') {
            echo '';
            return;
        }

        echo get_total_lessons_for_course($post->ID) . ' جلسه';
    }
}
