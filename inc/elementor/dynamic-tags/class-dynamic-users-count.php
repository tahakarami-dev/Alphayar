<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class AAC_Users_Count_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'aac_users_count';
    }

    public function get_title() {
        return 'تعداد کاربران';
    }

    public function get_group() {
        return 'site';
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    public function render() {
        $count = count_users();
        $total = isset($count['total_users']) ? intval($count['total_users']) : 0;
        echo number_format($total, 0, '.', '٬');
    }
    
}
