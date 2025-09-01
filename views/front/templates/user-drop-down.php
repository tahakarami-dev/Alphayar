<?php
function aac_user_menu_shortcode()
{
    if (!is_user_logged_in()) {
        return '';
    }

    ob_start();

    $current_user = wp_get_current_user();
    $user_mobile = get_user_meta($current_user->ID, 'mobile_number', true);
    $avatar_url = get_avatar_url($current_user->ID);
    $default_avatar = AAC_FRONT_ASSETS . '/images/user-avatar.jpg';

    if (strpos($avatar_url, 'default') !== false || !$avatar_url) {
        $avatar_url = $default_avatar;
    }
?>
    <div class="user-menu-wrapper">
        <div class="user-avatar-button user-box-icon">
            <img src="<?php echo AAC_FRONT_ASSETS . '/images/user.svg'; ?>" alt="">
        </div>
        <div class="user-dropdown-card">
            <div class="user-dropdown-header">
                <div class="header-avatar">
                    <img onerror="this.src='<?php echo esc_url($default_avatar); ?>'; this.onerror=null;" src="<?php echo esc_url($avatar_url); ?>" alt="User Avatar" />
                </div>
                <div class="header-info">
                    <h3 class="user-name"><?php echo esc_html($current_user->display_name); ?></h3>
                    <p class="user-meta"><?php echo esc_html($user_mobile); ?></p>
                </div>
            </div>

            <div class="user-dropdown-body">
                <a href="https://alphapico.ir/dashboard/" class="menu-item">
                    <span class="menu-icon"><img src="<?php echo AAC_FRONT_ASSETS . '/images/house-chimney.svg'; ?>" alt=""></span>
                    <span class="menu-text">داشبورد</span>
                    <span class="menu-badge">جدید</span>
                </a>
                <a href="https://alphapico.ir/dashboard/enrolled-courses" class="menu-item">
                    <span class="menu-icon"><img src="<?php echo AAC_FRONT_ASSETS . '/images/lesson.svg'; ?>" alt=""></span>
                    <span class="menu-text">دوره‌های من</span>
                </a>
                <a href="https://alphapico.ir/dashboard/my-quiz-attempts/" class="menu-item">
                    <span class="menu-icon"><img src="<?php echo AAC_FRONT_ASSETS . '/images/to-do-alt.svg'; ?>" alt=""></span>
                    <span class="menu-text">آزمون‌ها</span>
                </a>
            </div>

            <div class="user-dropdown-footer">
                <a href="https://alphapico.ir/dashboard/settings" class="footer-item">
                    <span class="footer-icon"><img src="<?php echo AAC_FRONT_ASSETS . '/images/user-pen.svg'; ?>" alt=""></span>
                    <span class="footer-text">ویرایش حساب</span>
                </a>
                <a href="https://alphapico.ir/dashboard/logout" class="footer-item logout">
                    <span class="footer-icon"><img src="<?php echo AAC_FRONT_ASSETS . '/images/sign-out-alt.svg'; ?>" alt=""></span>
                    <span class="footer-text">خروج </span>
                </a>
            </div>
        </div>
    </div>
<?php
    return ob_get_clean();
}
add_shortcode('aac_user_menu', 'aac_user_menu_shortcode');
