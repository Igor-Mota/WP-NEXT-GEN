@php
  /**
   * COMPONENTE FINAL - BUSCA IMAGEM E DIMENSÕES
   * @param string $fieldPrefix O prefixo do campo pai (Ex: 'home_banner').
   * @param array $attrs Atributos HTML extras (opcional).
   */

  $postId = get_option('page_on_front');

  if (!$postId && function_exists('get_the_ID')) {
    $postId = get_the_ID();
  }

  $fieldPrefix = $field_prefix;

  if (empty($fieldPrefix) || $postId === 0) {
    return;
  }
  $imageComplexKey = "{$fieldPrefix}images";
  $designComplexKey = "{$fieldPrefix}design_settings";


  $imageData = carbon_get_post_meta($postId, $imageComplexKey);
  $imageBlock = $imageData[0] ?? [];

  $defaultId = (int) ($imageBlock["{$fieldPrefix}default_banner"] ?? 0);
  $mobileId = (int) ($imageBlock["{$fieldPrefix}mobile_banner"] ?? 0);


  $imageIdToRender = $defaultId;

  if ($imageIdToRender === 0) {
    return;
  }

  $finalSettings = [];
  $imageSize = 'full';
  $finalAttrs = $attrs ?? [];

  $sizesData = carbon_get_post_meta($postId, $designComplexKey);
  $designBlock = $sizesData[0] ?? [];

  if (!empty($designBlock)) {
    $finalSettings['sizes'] = [

    'sm' => $designBlock["{$fieldPrefix}_size_mobile"] ?? 340,
    'md' => $designBlock["{$fieldPrefix}_size_tablet"] ?? 768,
    'lg' => $designBlock["{$fieldPrefix}_size_desktop"] ?? 1024,
    'xl' => $designBlock["{$fieldPrefix}_size_extra_large"] ?? 1280,
    ];
  }

  if ($mobileId > 0 && function_exists('wp_is_mobile') && wp_is_mobile()) {
    $imageIdToRender = $mobileId;
  }

@endphp


{!! ImageHelper::load($imageIdToRender, $finalSettings, $imageSize, $finalAttrs) !!}