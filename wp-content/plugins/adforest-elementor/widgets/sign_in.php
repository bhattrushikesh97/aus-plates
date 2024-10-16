<?php

namespace Elementor;

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

class Widget_sign_in extends Widget_Base {

    public function get_name() {
        return 'login_short_base';
    }

    public function get_title() {
        return __('Sign In', 'adforest-elementor');
    }

    public function get_icon() {
        return 'fa fa-audio-description';
    }

    public function get_categories() {
        return ['adforest_elementor'];
    }

    protected function register_controls() {

        $this->start_controls_section(
                'general_sett', [
            'label' => esc_html__('Form Setting', 'adforest-elementor'),
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
                'description', [
            'label' => __('Short Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );
        $this->end_controls_section();
          $this->start_controls_section(
                'general_sett2', [
            'label' => esc_html__('Other section settings', 'adforest-elementor'),
                ]
        );

        
         $this->add_control(
                'section_title_2', [
            'label' => __('Section Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',
            'description' => __('For color {color}warp text within this tag{/color}', 'adforest-elementor'),
            'title' => __('Section Title', 'adforest-elementor'),
                ]
        );
        
          $this->add_control(
                'description_2', [
            'label' => __('Short Description', 'adforest-elementor'),
            'type' => \Elementor\Controls_Manager::TEXTAREA,
            'title' => '',
            'rows' => 3,
            'placeholder' => '',
                ]
        );
            
        $this->add_control(
             'bg_img', array(
            'label' => __('Section Image', 'adforest-elementor'),
            'type' => Controls_Manager::MEDIA,
            'default' => [
                'url' => \Elementor\Utils::get_placeholder_image_src(),
            ],
          
                )
        );
        
        $this->add_control(
             'button_title', [
            'label' => __('Button  Title', 'adforest-elementor'),
            'type' => Controls_Manager::TEXT,
            'default' => '',          
            'title' => __('Button Title', 'adforest-elementor'),
                ]
        );
          $this->add_control(
             'button_link', [
            'label' => __('Button link', 'adforest-elementor'),
            'type' => Controls_Manager::URL,
                   
            'title' => __('Button Link', 'adforest-elementor'),
                ]
        );
        $this->end_controls_section();
    }

    protected function render() {
        $atts = $this->get_settings_for_display();
        $params = array();
        $params['adforest_elementor'] = true;
        $params['description'] = isset($atts['description']) ? $atts['description'] : "";
        $params['section_title'] = isset($atts['section_title']) ? $atts['section_title'] : "";
        $params['button_link'] = isset($atts['button_link']) ? $atts['button_link'] : "";
        $params['bg_img'] = isset($atts['bg_img']) ? $atts['bg_img'] : "";
        $params['description_2'] = isset($atts['description_2']) ? $atts['description_2'] : ""; 
       $params['button_title'] = isset($atts['button_title']) ? $atts['button_title'] : "";       
       $params['section_title_2']   =   isset($atts['section_title_2']) ? $atts['section_title_2'] : "";  
       echo login_short_base_func($params);
    }
}
