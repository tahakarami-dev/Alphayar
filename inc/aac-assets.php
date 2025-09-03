<?php

defined('ABSPATH') || exit('NO Access');

class AAC_ASSETS
{

    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'front_assets'], 999);
        add_action('admin_enqueue_scripts', [$this, 'admin_assets'],);
    }
    public function admin_assets()
    {
        //css
        wp_enqueue_style('AAC-admin-style', AAC_ADMIN_ASSETS . 'css/style.css');


        //script
        wp_enqueue_media();
        wp_enqueue_script('AAC-main', AAC_ADMIN_ASSETS . 'js/main.js', ['jquery'], AAC_VER, true);


        wp_localize_script('AAC-main', 'AAC_DATA', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }

    public function front_assets()
    {

        // css
        wp_enqueue_style('AAC-style-front', AAC_FRONT_ASSETS . 'css/style.css', '', AAC_VER);
        if (is_page('dashboard')) {
            wp_enqueue_style('AAC-style-support-modules', AAC_INC_PATH . 'modules/support-ticket/assets/css/style.css', '', AAC_VER);
        }
       
        // scripts
        wp_enqueue_script('aac-main-scripts', AAC_FRONT_ASSETS . 'js/app.js', ['jquery'], null, true);
        wp_enqueue_script('aac-support-modules', AAC_INC_PATH .  'modules/support-ticket/assets/js/app.js', ['jquery'], null, true);


        wp_localize_script('aac-main-scripts', 'aac_ajax_object', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('aac_cart_nonce')
        ]);

        
    
    }
}
