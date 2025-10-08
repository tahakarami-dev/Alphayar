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
        array(
            'id'    => 'new-course-announcement-link',
            'type'  => 'text',
            'title' => 'لینک دوره جدید ',
        ),

    )
));
CSF::createSection($prefix, array(
    'title'  => 'محتوا',
    'fields' => array(

        array(
            'id'    => 'satisfaction-percentage',
            'type'  => 'number',
            'title' => 'درصد رضایت پلتفرم',
            'default' => '96'
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


