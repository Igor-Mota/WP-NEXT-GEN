<?php

/**
 * Gerencia o carregamento e a otimização de imagens no WordPress com breakpoints customizados.
 * Estrutura estática para facilitar o acesso global no tema WP NEXT GEN.
 */
class ImageHelper
{
    // Propriedade ESTÁTICA para armazenar os breakpoints.
    // É o único lugar onde o método estático load() pode buscar os defaults/customizações.
    protected static array $breakpoints = [
        'sm' => 375,
        'md' => 768,
        'lg' => 1024,
        'xl' => 1280,
        '2xl' => 1366,
        '3xl' => 1536
    ];

    public const CACHE_DIR_NAME = 'webp-cache';
    public const META_KEY_FLAG = '_webp_cache_exists';

    /**
     * Permite que o desenvolvedor customizar os breakpoints antes de usar a classe.
     * Deve ser chamado uma vez no setup do tema (functions.php).
     * @param array $customBreakpoints Array de breakpoints para mesclar com os defaults.
     */
    public static function init(array $customBreakpoints): void
    {
        // Mescla os novos breakpoints com os padrões, garantindo que os novos sobrescrevam.
        self::$breakpoints = array_merge(self::$breakpoints, $customBreakpoints);
    }

    // --------------------------------------------------------------------------------
    // MÉTODO ESTÁTICO PRINCIPAL
    // --------------------------------------------------------------------------------

    /**
     * Retorna o HTML completo da tag <img> otimizada com atributo 'sizes'.
     * @param int $imageRef O ID do anexo (retornado pelo Carbon Fields).
     * @param array $settings Array de configurações da imagem (opcional).
     * @param string|array $size Tamanho base para o corte ('full', 'large', ou [largura, altura]).
     * @param array $attrs Array de atributos extras para a tag <img>.
     * @return string O HTML completo da tag <img> ou uma string vazia.
     */
    public static function load(int $imageRef, array $settings = [], $size = 'full', array $attrs = []): string
    {
        if (empty($imageRef)) {
            return '';
        }

        $finalBreakpoints = self::$breakpoints;

        if (!empty($settings['sizes']) && is_array($settings['sizes'])) {

            $finalBreakpoints = array_merge($finalBreakpoints, $settings['sizes']);
        }

        $customSizesString = self::buildSizesString($finalBreakpoints);

        $finalAttrs = $attrs;
       
        $image_src = wp_get_attachment_image_src($imageRef, $size);
        $img_width = 0;
        $img_height = 0;

        if ($image_src) {
            $img_width = $image_src[1];
            $img_height = $image_src[2];
        }
       
        if (!isset($finalAttrs['sizes'])) {
            $finalAttrs['sizes'] = $customSizesString;
        }

        if (!isset($finalAttrs['load'])) {
            $finalAttrs['fetchpriority'] = 'high';
            $finalAttrs['decoding'] = 'async';
            $finalAttrs['width'] = $img_width;
            $finalAttrs['height'] = $img_height;
        }


        $img_html = wp_get_attachment_image($imageRef, $size, false, $finalAttrs);

        $imageHTML = preg_replace(
            '/(sizes=[\'"])(auto, )([^\'"]*)/i',
            '$1$3',
            $img_html
        );

        return $imageHTML;
    }

    /**
     * Constrói a string do atributo 'sizes' manualmente (min-width).
     * @param array $breakpoints Array com os valores de largura (ex: ['sm' => 375, ...]).
     * @return string A string formatada do atributo 'sizes'.
     */
    private static function buildSizesString(array $breakpoints): string
    {   
        $sm = $breakpoints['sm'] ?? 375;
        $md = $breakpoints['md'] ?? 768;
        $lg = $breakpoints['lg'] ?? 1024;
        $xl = $breakpoints['xl'] ?? 1280;
        $xxl = $breakpoints['2xl'] ?? 1366;
        $t3xl = $breakpoints['3xl'] ?? 1536;

        $responsiveRules = [
            "(min-width: {$t3xl}px) {$t3xl}px",
            "(min-width: {$xxl}px) {$xxl}px",
            "(min-width: {$xl}px) {$xl}px",
            "(min-width: {$lg}px) {$lg}px",
            "(min-width: {$md}px) {$md}px",
            "(min-width: {$sm}px) {$sm}px" ,
        ];
  
        $responsiveRules[] = '100vw';
        return implode(', ', $responsiveRules);
    }

    private static function convert_and_cache($image_id)
    {

        $attachment_id = $image_id;

        $original_url = wp_get_attachment_url($image_id);

        $webp_exists_flag = get_post_meta($image_id, self::META_KEY_FLAG, true);

        $upload_dir = wp_upload_dir();

        $relative_path = str_replace($upload_dir['baseurl'], '', $original_url);

        $source_path = $upload_dir['basedir'] . $relative_path;

        if (!$source_path || !file_exists($source_path)) {
            return $original_url;
        }

        $webp_filename = basename($source_path) . '.webp';
        $cached_file_path = trailingslashit($upload_dir['basedir']) . self::CACHE_DIR_NAME . '/' . $webp_filename;

        if ($attachment_id && get_post_meta($attachment_id, self::META_KEY_FLAG, true) === 'yes') {
            if (file_exists($cached_file_path)) {
                return trailingslashit($upload_dir['baseurl']) . self::CACHE_DIR_NAME . '/' . $webp_filename;
            }
        }

        if (webpConverter::createWebp($source_path, $cached_file_path)) {

            if ($attachment_id) {
                update_post_meta($attachment_id, self::META_KEY_FLAG, 'yes');
            }

            return trailingslashit($upload_dir['baseurl']) . self::CACHE_DIR_NAME . '/' . $webp_filename;
        }

        return $original_url;
    }


    private static function adaptSrcsetForWebp(string $original_srcset_string): string
    {
        $upload_dir = wp_upload_dir();
        $parts = explode(', ', $original_srcset_string);
        $webp_sources = [];

        foreach ($parts as $part) {
            // Separa a URL da largura (ex: 'url-media.jpg 768w')
            if (!strpos($part, ' '))
                continue;
            list($url, $width) = explode(' ', trim($part), 2);

            // Converte a URL do JPG/PNG para a URL WebP usando o WebpConverter
            $webp_url = WebpConverter::getWebpUrlFromOriginal($url, $upload_dir);

            // O WebpConverter::processWebpConversion() precisa ser chamado para CADA tamanho 
            // para garantir que o arquivo WebP exista ANTES de servir o srcset.
            // Isso será feito pelo ImageHelper::load antes de construir a string.

            $webp_sources[] = "{$webp_url} {$width}";
        }

        return implode(', ', $webp_sources);
    }
}