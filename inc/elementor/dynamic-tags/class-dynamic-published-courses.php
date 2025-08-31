<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class AAC_Published_Courses_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'aac_published_courses';
    }

    public function get_title() {
        return 'تعداد دوره‌ها';
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    public function render() {
        echo aac_get_published_courses_count();
    }
}
