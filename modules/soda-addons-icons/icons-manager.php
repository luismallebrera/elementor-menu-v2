<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

class Soda_Icons_Manager {

    public static function init() {
        add_filter('elementor/icons_manager/additional_tabs', [__CLASS__, 'add_soda_icons_tab']);
    }

    public static function add_soda_icons_tab($tabs) {
        $plugin_url = plugin_dir_url(dirname(dirname(__FILE__)));
        
        $tabs['soda-addons-icons'] = [
            'name'          => 'soda-addons-icons',
            'label'         => __('Soda Icons', 'elementor-menu-widget-v2'),
            'url'           => $plugin_url . 'assets/css/soda-addons-icons.min.css',
            'enqueue'       => [$plugin_url . 'assets/css/soda-addons-icons.min.css'],
            'prefix'        => 'xi-',
            'displayPrefix' => 'xi',
            'labelIcon'     => 'xi xi-soda',
            'ver'           => Elementor_Menu_Widget_V2::VERSION,
            'fetchJson'     => $plugin_url . 'modules/soda-addons-icons/soda-addons-icons.json?v=' . Elementor_Menu_Widget_V2::VERSION,
            'native'        => false,
        ];

        return $tabs;
    }
}

Soda_Icons_Manager::init();
