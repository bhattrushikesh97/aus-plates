<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_product_cat_tabs extends Widget_Base {

    public function get_name() {
        return 'product_cat_tabs';
    }

    public function get_title() {
        return __('Products Category Tabs', 'adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'basic', [
            'label' => esc_html__('Basic', 'adforest-elementor'),
                ]
        );

       

        $this->add_control(
                'section_title', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}', 'adforest-elementor'),
            'title' => __('Section Title', 'adforest-elementor'),
    ]
        );

        $this->add_control(
            'banner_img', array(
                'label' => __('Banner  Image', 'adforest-elementor'),
                'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ],
                "description" => __("285x395", 'adforest-elementor'),
            )
        );
           $this->add_control(
                'banner_postion', array(
            'label' => __('Banner position','adforest-elementor'),
            'type' => Controls_Manager::SELECT,
            'options' => array(
                'left' => __('Left','adforest-elementor'),
                'right' => __('Right','adforest-elementor'),
            ),
                )
        );

        $this->add_control(
                'max_limit',
                [
                    'label' => __('Select Number of Product', 'adforest-elementor'),
                    'type' => \Elementor\Controls_Manager::NUMBER,
                    'min' => 1,
                    'max' => 1000,
                    'step' => 1,
                    'default' => 4,
                ]
        );
        $this->end_controls_section();
        $this->start_controls_section(
                'category_settings', [
            'label' => esc_html__('Categories', 'adforest-elementor'),
                ]
        );
        $this->add_control(
            'woo_products', array(
            'label' => __('Select Category', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::SELECT2,
            'multiple' => true,
            'default' => 'all',
            'placeholder' => 'Select Options',
            'options' => apply_filters('adforest_elementor_get_product_categories', 'product_cat'),
                )
        );
        $this->end_controls_section();
    }
    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['banner_postion'] = isset($atts['banner_postion']) ? $atts['banner_postion'] : "";
        $params['banner_img'] = isset($atts['banner_img']) ? $atts['banner_img'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['section_description'] = isset($atts['section_description']) ? $atts['section_description'] : "";
        $params['max_limit'] = isset($atts['max_limit']) ? $atts['max_limit'] : "";
        $params['woo_products'] = isset($atts['woo_products']) ? $atts['woo_products'] : "";
        echo  products_cats_tabs5_short_base_func($params);        
    }
}