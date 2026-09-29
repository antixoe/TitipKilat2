<?php

return [

    'paths' => [
        resource_path('views'),
    ],

    // Vercel's deployment filesystem is read-only; /tmp is writable per
    // function instance and is suitable for compiled Blade templates.
    'compiled' => env(
        'VIEW_COMPILED_PATH',
        env('VERCEL') ? sys_get_temp_dir().'/titipkilat-views' : storage_path('framework/views')
    ),

];
