<?php
/*
Plugin Name:  آلفایار
Description:  افزونه‌ای کاربردی برای افزودن یک دستیار هوشمند به وردپرس، با هدف بهبود تجربه کاربری، افزایش تعامل و دسترسی سریع‌تر کاربران به محتوا
Version: 1.1.3
Author: طاها کرمی
*/


defined('ABSPATH') || exit('NO Access');


class Core
{

    private static $_instance = null;

    const MINIUM_PHP_VERSION = '7.2';

    public static function instance()
    {

        if (is_null(self::$_instance)) {

            self::$_instance = new self();
        }

        return  self::$_instance;
    }

    public function __construct()
    {

        if (version_compare(PHP_VERSION, self::MINIUM_PHP_VERSION, '<')) {
            add_action('admin_notices', [$this, 'admin_php_notice']);
            return;
        }

        $this->constant();
        $this->init();
    }


    public function constant()
    {

        if (!function_exists('get_plugin_data')) {

            require_once(ABSPATH . 'wp-admin/includes/plugin.php');
        }

        define('AAC_BASE_FILE', __FILE__);
        define('AAC_PATH', trailingslashit(plugin_dir_path(AAC_BASE_FILE)));
        define('AAC_URL', trailingslashit(plugin_dir_url(AAC_BASE_FILE)));
        define('AAC_ADMIN_ASSETS', trailingslashit(AAC_URL . 'assets/admin'));
        define('AAC_FRONT_ASSETS', trailingslashit(AAC_URL . 'assets/front'));
        define('AAC_ASSETS', trailingslashit(AAC_URL . 'assets/'));
        define('AAC_INC_PATH', trailingslashit(AAC_PATH . 'inc'));
        define('AAC_VIEWS_PATH', trailingslashit(AAC_PATH . 'views'));





        $AAC_plugin_data =  get_plugin_data(AAC_BASE_FILE, '<');
        define('AAC_VER',  $AAC_plugin_data['Version']);
    }

    public function init()
    {
       
        require_once AAC_PATH . 'vendor/autoload.php';
        require_once AAC_INC_PATH . 'admin/codestar/codestar-framework.php';
        require_once AAC_INC_PATH . 'admin/aac-settings.php';
        require_once  AAC_INC_PATH . 'functions.php';
        if(aac_settings('support-module')){
            require_once AAC_INC_PATH . 'modules/support-ticket/functions/helpers.php';
        }
        require_once  AAC_INC_PATH . '/admin/content-loader.php';
        require_once  AAC_VIEWS_PATH . 'front/templates/user-drop-down.php';
        require_once  AAC_VIEWS_PATH . 'front/templates/cart-drop-down.php';
        require_once  AAC_VIEWS_PATH . 'front/templates/podcast-player.php';





        register_activation_hook(AAC_BASE_FILE, [$this, 'active']);
        register_deactivation_hook(AAC_BASE_FILE, [$this, 'deactive']);
        add_action('wp_footer', [$this, 'render_user_dropdown']);




        aac_settings();


        new AAC_ASSETS();


        if (is_admin()) {

            new AAC_Menu();
        } else {
        }



        add_action('elementor/dynamic_tags/register_tags', function ($dynamic_tags) {

            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-published-posts.php';
            $dynamic_tags->register(new \Elementor\AAC_Published_Posts_Tag());
        
            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-users-count.php';
            $dynamic_tags->register(new \Elementor\AAC_Users_Count_Tag());
        
            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-published-courses.php';
            $dynamic_tags->register(new \Elementor\AAC_Published_Courses_Tag());
        
            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-teaching-hours.php';
            $dynamic_tags->register(new \Elementor\AAC_Teaching_Hours_Tag());
        
            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-satisfaction.php';
            $dynamic_tags->register(new \Elementor\AAC_Satisfaction_Percentage_Tag());
        
            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-tutor-enrolled.php';
            $dynamic_tags->register(new \Elementor\AAC_Tutor_Enrolled_Tag());
        
            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-daily-visits.php';
            $dynamic_tags->register(new \Elementor\AAC_Daily_Visits_Tag());
        
            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-new-course-announcement.php';
            $dynamic_tags->register(new \Elementor\AAC_New_Course_Announcement_Tag());

            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-new-course-announcement-link.php';
            $dynamic_tags->register(new \Elementor\AAC_New_Course_Announcement_Link_Tag());
            
            require_once AAC_INC_PATH . 'elementor/dynamic-tags/class-dynamic-course-lessons-count.php';
            $dynamic_tags->register(new \Elementor\AAC_Course_Lessons_Count_Tag());
        });
        
    }

    public function active()
    {

        // AAC_DB::create_table();

    }



    public function deactive() {}

    public function render_user_dropdown()
    {

        require_once AAC_VIEWS_PATH . 'front/templates/user-drop-down.php';
        require_once AAC_VIEWS_PATH . 'front/templates/cart-drop-down.php';
        require_once AAC_VIEWS_PATH . 'front/templates/podcast-player.php';

    }



    public function admin_php_notice()
    { ?>
        <div class="notice notice-error">
            <p>افزونه دستیار هوشمند آلفاپیکو برای اجرا صحیح نیاز به نسخه 7.2 به بالا دارد لطفا نسخه php هاست خود را ارتقا دهید
            </p>
        </div>
<?php
    }
}

Core::instance();
