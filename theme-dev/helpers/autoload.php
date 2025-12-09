<?php

/**
 * Autoload de todos os arquivos de funções helper.
 * Garante que todas as funções sejam carregadas antes da execução do tema.
 */
function autoload_theme_helpers() {
    $helper_dir = get_template_directory() . '/helpers/';

    $helper_files = glob( $helper_dir . '*.php' );

    foreach ( $helper_files as $filename ) {
        if ( file_exists( $filename ) ) {
            require_once $filename;
        }
    }
}

add_action( 'after_setup_theme', 'autoload_theme_helpers' );