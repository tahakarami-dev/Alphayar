<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class AAC_New_Course_Announcement_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'aac_new_course';
    }

    public function get_title() {
        return 'اعلان دوره جدید';
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    public function render() {
        $announcement = aac_settings('new-course-announcement');
        echo !empty($announcement) ? esc_html($announcement) : '';
    }
}
