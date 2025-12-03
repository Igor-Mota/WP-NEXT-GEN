<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Home')
    ->where('post_id', '=', get_option('page_on_front'))
    ->add_tab('Hero', [

        Field::make('image', 'home_banner', 'Banner')
            ->set_width(50), 
        Field::make('complex', 'hero_design_settings', 'Dimensoes')
            ->set_layout('tabbed-horizontal') 
            ->set_max(1)
            ->set_width(50)
            ->add_fields('settings_block', 'Tamanhos', [
                Field::make('text', 'banner_size_mobile', 'Size (Mobile)')
                ->set_default_value('340'),
                Field::make('text', 'banner_size_tablet', 'Size (Tablet)')
                ->set_default_value('768'),
                Field::make('text', 'banner_size_desktop', 'Size (Desktop)')
                ->set_default_value('1024'),
                Field::make('text', 'banner_size_extra_large', 'Size (XL)')
                ->set_default_value('1280'),
            ]),
        Field::make('text', 'home_title', 'Título da Home'),
        Field::make('textarea', 'home_subtitle', 'Subtítulo da Home'),
        Field::make('text', 'cta_text', 'Texto do Botão (CTA)')
            ->set_width(50), 
        Field::make('text', 'cta_url', 'URL do Botão (CTA)')
            ->set_width(50)
    ]);