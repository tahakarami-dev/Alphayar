<?php

defined('ABSPATH') || exit('NO Access');

$prefix = 'aac_settings';

CSF::createOptions($prefix, array(
    'parent_slug'   => 'al_dastyar',
    'menu_title'    => 'تنظیمات',
    'menu_hidden' => true,
    'menu_slug'     => 'aac_menu_settings',
    'framework_title' => 'تنظیمات دستیار هوشمند آلفایار',
));
CSF::createSection($prefix, array(
    'title'  => 'داشبورد',
    'fields' => array(
    )
));
CSF::createSection($prefix, array(
    'title'  => 'ماژول ها',
    'fields' => array(
        array(
            'id'    => 'support-module',
            'type'  => 'switcher',
            'title' => 'ماژول تیکت پشتیبانی تیوتر',
          ),
    )
));
CSF::createSection($prefix, array(
    'title'  => 'اطلاعیه',
    'fields' => array(
        array(
            'id'    => 'new-course-announcement',
            'type'  => 'text',
            'title' => 'اطلاعیه دوره جدید ',
            'default' => 'دورهٔ مبانی هوش مصنوعی از طاها کرمی منتشر شد!'
        ),

    )
));
CSF::createSection($prefix, array(
    'title'  => 'محتوا',
    'fields' => array(

        array(
            'id'         => 'number-of-students-manual',
            'type'       => 'switcher',
            'title'      => 'تعداد دانشجویان (خودکار)', 
            'default'    => true
          ),
        array(
            'id'    => 'number-of-students',
            'type'  => 'number',
            'title' => 'تعداد دانشجویان ',
            'dependency' => array( 'number-of-students-manual', '==', 'false' )
        ),
        array(
            'id'    => 'satisfaction-percentage',
            'type'  => 'number',
            'title' => 'درصد رضایت پلتفرم',
            'default' => '96'
        ),
        array(
            'id'         => 'number-of-users-manual',
            'type'       => 'switcher',
            'title'      => '  تعداد کاربران  (خودکار)', 
            'default'    => true
          ),
        array(
            'id'    => 'number-of-users',
            'type'  => 'number',
            'title' => 'تعداد کاربران ',
            'dependency' => array( 'number-of-users-manual', '==', 'false' )

        ),
        array(
            'id'         => 'daily-visit-manual',
            'type'       => 'switcher',
            'title'      => 'بازدید روزانه (خودکار)', 
            'default'    => true
          ),
        array(
            'id'    => 'daily-visit',
            'type'  => 'number',
            'title' => 'بازدید روزانه',
            'dependency' => array( 'daily-visit-manual', '==', 'false' )

        ),


    )
));


