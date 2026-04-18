<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Class Namespace
    |--------------------------------------------------------------------------
    |
    | This value sets the root namespace for Livewire component classes in
    | your application. This value affects component discovery and code
    | generation. Change this value with caution.
    |
    */

    'class_namespace' => 'App\\Http\\Livewire',

    /*
    |--------------------------------------------------------------------------
    | View Path
    |--------------------------------------------------------------------------
    |
    | This value sets the path where Livewire component views are stored.
    | This value affects component discovery and code generation.
    |
    */

    'view_path' => resource_path('views/livewire'),

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | The default layout view that will be used when rendering a component via
    | a direct POST request. Change this only if you know what you're doing.
    |
    */

    'layout' => 'components.layouts.app',

    /*
    |--------------------------------------------------------------------------
    | Inject Assets
    |--------------------------------------------------------------------------
    |
    | If the following is true, Livewire will automatically inject its assets
    | (JavaScript and CSS) into the view template.
    |
    */

    'inject_assets' => true,

    /*
    |--------------------------------------------------------------------------
    | Navigate
    |--------------------------------------------------------------------------
    |
    | Whether Livewire should enable the Navigate feature for SPA-like behavior
    |
    */

    'navigate' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Morphdom
    |--------------------------------------------------------------------------
    |
    | Livewire uses the morphdom library to efficiently update the DOM. This
    | is a JavaScript library that is included by default.
    |
    */

    'morphdom' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Loading States
    |--------------------------------------------------------------------------
    |
    | Below you can configure loading state directives and classes.
    |
    */

    'loading_delay' => 200,
    'loading_min_delay' => 0,

    /*
    |--------------------------------------------------------------------------
    | Polling
    |--------------------------------------------------------------------------
    |
    | Below you can configure Livewire's polling engine.
    |
    */

    'poll' => [
        'enabled' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Testing
    |--------------------------------------------------------------------------
    |
    | The options below are used when testing Livewire components.
    |
    */

    'testing' => [
        'enabled' => true,
    ],
];
