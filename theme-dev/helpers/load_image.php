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

        // 1. Definição dos Breakpoints Finais: Padrões customizados pelo init()
        $finalBreakpoints = self::$breakpoints;

        // 2. Mesclagem com Customizações Locais ($settings['sizes'])
        if (!empty($settings['sizes']) && is_array($settings['sizes'])) {
            // Mescla os defaults (que podem já estar customizados pelo init) com os locais
            $finalBreakpoints = array_merge($finalBreakpoints, $settings['sizes']);
        }

        // 3. Constroi a string 'sizes' (min-width)
        $customSizesString = self::buildSizesString($finalBreakpoints);

        // 4. Prepara os Atributos
        $finalAttrs = $attrs;
        if (!isset($finalAttrs['sizes'])) {
            $finalAttrs['sizes'] = $customSizesString;
        }

        // 5. Chamada Final do WordPress
        $img_html = wp_get_attachment_image($imageRef, $size, false, $finalAttrs);
        $imageHTML = preg_replace(
            '/(sizes=[\'"])(auto, )([^\'"]*)/i',
            '$1$3',
            $img_html
        );
        return $imageHTML;

    }

    // --------------------------------------------------------------------------------
    // LÓGICA DE CONSTRUÇÃO (Método privado)
    // --------------------------------------------------------------------------------

    /**
     * Constrói a string do atributo 'sizes' manualmente (min-width).
     * @param array $breakpoints Array com os valores de largura (ex: ['sm' => 375, ...]).
     * @return string A string formatada do atributo 'sizes'.
     */
    private static function buildSizesString(array $breakpoints): string
    {
        $md = $breakpoints['md'] ?? 768;
        $lg = $breakpoints['lg'] ?? 1024;
        $xl = $breakpoints['xl'] ?? 1280;
        $xxl = $breakpoints['2xl'] ?? 1366;
        $t3xl = $breakpoints['3xl'] ?? 1536;

        // Construção da string (min-width, ordem descendente)
        $responsiveRules = [
            "(min-width: {$t3xl}px) {$t3xl}px",
            "(min-width: {$xxl}px) {$xxl}px",
            "(min-width: {$xl}px) {$xl}px",
            "(min-width: {$lg}px) {$lg}px",
            "(min-width: {$md}px) {$md}px",
            "100vw" // Fallback
        ];

        return implode(', ', $responsiveRules);
    }

    private function verify_or_converter($image_id)
    {

        $META_KEY_FLAG = '_webp_cache_exists';
        $webp_exists_flag = get_post_meta($image_id, $META_KEY_FLAG, true);
        if ($webp_exists_flag === 'yes') {
            return true;
        }

        return false;
    }
}