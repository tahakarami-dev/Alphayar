<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class AAC_New_Course_Announcement_Link_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'aac_new_course_link';
    }

    public function get_title() {
        return 'لینک اعلان دوره جدید';
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::URL_CATEGORY ];
    }

    public function render() {
        $announcement = aac_settings('new-course-announcement-link');
        if (!empty($announcement)) {
            echo esc_url($announcement);
        }
    }
}
