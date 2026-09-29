<?php

// Blade compiles templates at runtime. Vercel only provides a writable /tmp.
$compiledViews = sys_get_temp_dir().'/titipkilat-views';
if (! is_dir($compiledViews)) {
    mkdir($compiledViews, 0755, true);
}

// Keep the public directory as Laravel's only web entrypoint.
require dirname(__DIR__).'/public/index.php';
