<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class AAC_Daily_Visits_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'daily_visit';
    }

    public function get_title() {
        return 'بازدید روزانه';
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    public function render() {
        $count = aac_get_daily_visits();
        echo number_format($count, 0, '.', '٬');
    }
}
