<?php
function wp_next_gen_enqueue()
{

    $dist_uri = get_template_directory_uri() . '/dist/';
    $dist_path = get_template_directory() . '/dist/';

    $css_version = filemtime($dist_path . 'css/app.min.css');

    $js_path_rel = 'js/';
    $vendors_handle = 'vendors-js';
    $vendors_path_rel = $js_path_rel . 'vendors.js';
    $vendors_path_abs = $dist_path . $vendors_path_rel;


    wp_enqueue_style(
        'wp-next-gen-css',
        $dist_uri . 'css/app.min.css',
        [],
        $css_version
    );


    if (file_exists($vendors_path_abs)) {
        wp_enqueue_script(
            $vendors_handle,
            $dist_uri . $vendors_path_rel,
            [], // Sem dependências primárias
            filemtime($vendors_path_abs),
            true // <--- CRUCIAL: Carrega no footer (fim do body)
        );
    }

    $template_slug = false;

    if (is_front_page() || is_home()) {
        $template_slug = 'home';
    } elseif (is_page()) {
        $template_file = get_page_template_slug();
        if ($template_file) {
            $template_slug = basename($template_file, '.php');
        } else {

            $template_slug = get_post(get_the_ID())->post_name;
        }
    }

    if ($template_slug) {
        $script_handle = $template_slug . '-js';
        $page_script_path_rel = $js_path_rel . $template_slug . '.js';
        $page_script_path_abs = $dist_path . $page_script_path_rel;
        if (file_exists($page_script_path_abs)) {
            wp_enqueue_script(
                $script_handle,
                $dist_uri . $page_script_path_rel,
                [$vendors_handle], // <--- Depende do vendors.js para rodar Alpine/Swiper
                filemtime($page_script_path_abs),
                true // <--- CRUCIAL: Carrega no footer (fim do body)
            );
        }
    }


}

add_action('wp_enqueue_scripts', 'wp_next_gen_enqueue');