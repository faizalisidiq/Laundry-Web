<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Show Warnings
    |--------------------------------------------------------------------------
    | Throw an Exception on warnings from dompdf
    */
    'show_warnings' => false,

    /*
    |--------------------------------------------------------------------------
    | Public Path
    |--------------------------------------------------------------------------
    | Override the public path if needed
    */
    'public_path' => public_path(),

    /*
    |--------------------------------------------------------------------------
    | Convert Entities
    |--------------------------------------------------------------------------
    | Dejavu Sans font is missing glyphs for converted entities, 
    | turn it off if you need to show € and £.
    */
    'convert_entities' => true,

    /*
    |--------------------------------------------------------------------------
    | Options
    |--------------------------------------------------------------------------
    */
    'options' => [
        /**
         * Font Directory
         * The location of the DOMPDF font directory
         */
        'font_dir' => storage_path('fonts'),

        /**
         * Font Cache Directory
         * This directory contains the cached font metrics
         */
        'font_cache' => storage_path('fonts'),

        /**
         * Temporary Directory
         * The directory must be writeable by the webserver process
         */
        'temp_dir' => sys_get_temp_dir(),

        /**
         * Chroot
         * Prevents dompdf from accessing system files
         * IMPORTANT: Set to base_path() for Laravel hosting compatibility
         */
        'chroot' => realpath(base_path()),

        /**
         * Protocol Whitelist
         * Protocols allowed in URIs
         */
        'allowed_protocols' => [
            'file://' => ['rules' => []],
            'http://' => ['rules' => []],
            'https://' => ['rules' => []],
        ],

        /**
         * Artifact Path Validation
         */
        'artifactPathValidation' => null,

        /**
         * Log Output File
         */
        'log_output_file' => null,

        /**
         * Enable Font Subsetting
         */
        'enable_font_subsetting' => false,

        /**
         * PDF Backend
         * Valid: 'PDFLib', 'CPDF', 'GD', 'auto'
         */
        'pdf_backend' => 'CPDF',

        /**
         * Default Media Type
         */
        'default_media_type' => 'screen',

        /**
         * Default Paper Size
         */
        'default_paper_size' => 'a4',

        /**
         * Default Paper Orientation
         */
        'default_paper_orientation' => 'portrait',

        /**
         * Default Font
         * Must exist in the font folder
         */
        'default_font' => 'serif',

        /**
         * Image DPI Setting
         */
        'dpi' => 96,

        /**
         * Enable Embedded PHP
         * SECURITY: Keep this FALSE for untrusted documents
         */
        'enable_php' => false,

        /**
         * Enable JavaScript
         * This is PDF-based JavaScript, not browser JavaScript
         */
        'enable_javascript' => false,

        /**
         * Enable Remote File Access
         * SECURITY: Set to true only if you need to load remote images/CSS
         */
        'enable_remote' => false,

        /**
         * Allowed Remote Hosts
         * Leave NULL to allow any host (if enable_remote is true)
         */
        'allowed_remote_hosts' => null,

        /**
         * Font Height Ratio
         */
        'font_height_ratio' => 1.1,

        /**
         * Enable HTML5 Parser
         */
        'enable_html5_parser' => true,
    ],

];
