<?php
namespace Elementor;

if (!defined('ABSPATH')) exit;

class AAC_Satisfaction_Percentage_Tag extends \Elementor\Core\DynamicTags\Tag {

    public function get_name() {
        return 'aac_satisfaction_percentage';
    }

    public function get_title() {
        return 'درصد رضایت کاربران';
    }

    public function get_group() {
        return 'site';  
    }

    public function get_categories() {
        return [ \Elementor\Modules\DynamicTags\Module::TEXT_CATEGORY ];
    }

    protected function register_controls() {
       
    }

    public function render() {
       
        $percent = function_exists('aac_settings') ? aac_settings('satisfaction-percentage') : 0;

        echo ! empty( $percent ) ? esc_html( intval( $percent ) . '%' ) : '0%';
    }
}
