<?php
use Carbon_Fields\Field;

/**
 * Retorna um array de Carbon Fields para Imagens e Dimensões.
 * Aplica o prefixo a TODOS os nomes de campos (pai e filhos).
 * * @param string $prefix Prefixo a ser aplicado (ex: 'ng_hero_').
 * @return array Um array de objetos Field.
 */
function carbon_image(string $prefix = ''): array
{

  $p = $prefix;

  return [
    Field::make('complex', "{$p}images", 'Imagens')
      ->set_layout('tabbed-horizontal')
      ->set_max(1)
      ->set_width(50)
      ->add_fields([

        Field::make('image', "{$p}default_banner", 'Imagem Padrão')
          ->set_width(50),

        Field::make('image', "{$p}mobile_banner", 'Imagem Mobile')
          ->set_width(50),
      ]),

    Field::make('complex', "{$p}design_settings", 'Dimensões')
      ->set_layout('tabbed-horizontal')
      ->set_max(1)
      ->set_width(50)
      ->add_fields('settings_block', 'Tamanhos', [
        Field::make('text', "{$p}size_mobile", 'Size (Mobile)') 
          ->set_default_value('340'),
        Field::make('text', "{$p}size_tablet", 'Size (Tablet)')
          ->set_default_value('768'),
        Field::make('text', "{$p}size_desktop", 'Size (Desktop)')
          ->set_default_value('1024'),
        Field::make('text', "{$p}size_extra_large", 'Size (XL)')
          ->set_default_value('1280'),
      ]),
  ];
}