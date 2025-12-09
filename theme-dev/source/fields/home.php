<?php

use Carbon_Fields\Container;
use Carbon_Fields\Field;

Container::make('post_meta', 'Home')
    ->where('post_id', '=', get_option('page_on_front'))
    ->add_tab('Hero', [
        
        ...carbon_image('home_banner'),
        
        Field::make('text', 'home_headline', 'Head line'),
        Field::make('text', 'home_title', 'Título da Home'),
        Field::make('textarea', 'home_subtitle', 'Subtítulo da Home'),
        Field::make('text', 'cta_text', 'Texto do Botão (CTA)')
            ->set_width(50), 
        Field::make('text', 'cta_url', 'URL do Botão (CTA)')
            ->set_width(50)
    ]);