<?php


add_action('after_setup_theme', function () {
    \Carbon_Fields\Carbon_Fields::boot();
});


add_action('carbon_fields_register_fields', function () {

    $fields_files = glob(__DIR__ . '/../source/fields/*.php');

    foreach ($fields_files as $file) {
        require_once $file;
    }
});