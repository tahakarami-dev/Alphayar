<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class AAC_Tutor_Enrolled_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'tutor_enrolled_count';
    }

    public function get_title() {
        return 'دانشجویان ثبت‌نامی';
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    public function render() {
        echo aac_get_tutor_enrolled_count();
    }
}
