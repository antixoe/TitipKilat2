<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['role' => \App\Http\Middleware\RoleMiddleware::class]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();

// Vercel's PHP runtime may load Laravel's config cache before the normal
// provider merge runs. Register the core providers directly so services such
// as view, database, sessions, and validation are always available.
foreach ([
    \Illuminate\Auth\AuthServiceProvider::class,
    \Illuminate\Cache\CacheServiceProvider::class,
    \Illuminate\Cookie\CookieServiceProvider::class,
    \Illuminate\Database\DatabaseServiceProvider::class,
    \Illuminate\Encryption\EncryptionServiceProvider::class,
    \Illuminate\Filesystem\FilesystemServiceProvider::class,
    \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    \Illuminate\Hashing\HashServiceProvider::class,
    \Illuminate\Pagination\PaginationServiceProvider::class,
    \Illuminate\Queue\QueueServiceProvider::class,
    \Illuminate\Session\SessionServiceProvider::class,
    \Illuminate\Translation\TranslationServiceProvider::class,
    \Illuminate\Validation\ValidationServiceProvider::class,
    \Illuminate\View\ViewServiceProvider::class,
] as $provider) {
    $app->register($provider);
}

return $app;
