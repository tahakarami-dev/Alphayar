<?php 

class AAC_Menu {
    public function __construct() {
        add_action('admin_menu', array($this, 'add_menu'));
    }

    public function add_menu() {
        $logo_url = AAC_ADMIN_ASSETS . '/images/logo.svg';
        add_menu_page(
            'آلفایار',
            'آلفایار',
            'manage_options', 
            'dashboard-dastyar', 
            array($this, 'main_menu_page'), 
            $logo_url,
            2 
        );

        
        add_submenu_page(
            'dashboard-dastyar', 
            'تنظیمات  ', 
            'تنظیمات', 
            'manage_options', 
            'aac_menu_settings',
            array($this, 'settings_page')
        );
       
    }

    public function main_menu_page() {
        // require_once AAC_VIEWS_PATH . 'admin/dashboard/dashboard.php';
    }

    public function settings_page() {
        // محتوای صفحه تنظیمات
        echo '<div class="wrap"><h1>تنظیمات دستیار هوشمند آلفاپیکو</h1>';
        if (function_exists('csf_init')) {
            do_action('csf_aac_menu_settings'); 
        } else {
            echo '<div class="notice notice-error"><p>خطا در بارگذاری تنظیمات.</p></div>';
        }
        echo '</div>';
    }

  
}

