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

// The Vercel PHP runtime can bypass Laravel's normal provider bootstrap.
// Load the config repository first, then register the core providers that the
// application needs before the request kernel starts.
$config = new \Illuminate\Config\Repository();
foreach (glob($app->basePath('config').'/*.php') ?: [] as $configFile) {
    $config->set(
        basename($configFile, '.php'),
        require $configFile,
    );
}
$app->instance('config', $config);

foreach ([
    \Illuminate\Auth\AuthServiceProvider::class,
    \Illuminate\Broadcasting\BroadcastServiceProvider::class,
    \Illuminate\Bus\BusServiceProvider::class,
    \Illuminate\Cache\CacheServiceProvider::class,
    \Illuminate\Cookie\CookieServiceProvider::class,
    \Illuminate\Database\DatabaseServiceProvider::class,
    \Illuminate\Encryption\EncryptionServiceProvider::class,
    \Illuminate\Filesystem\FilesystemServiceProvider::class,
    \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    \Illuminate\Hashing\HashServiceProvider::class,
    \Illuminate\Mail\MailServiceProvider::class,
    \Illuminate\Notifications\NotificationServiceProvider::class,
    \Illuminate\Pagination\PaginationServiceProvider::class,
    \Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
    \Illuminate\Pipeline\PipelineServiceProvider::class,
    \Illuminate\Queue\QueueServiceProvider::class,
    \Illuminate\Redis\RedisServiceProvider::class,
    \Illuminate\Session\SessionServiceProvider::class,
    \Illuminate\Translation\TranslationServiceProvider::class,
    \Illuminate\Validation\ValidationServiceProvider::class,
    \Illuminate\View\ViewServiceProvider::class,
    \Laravel\Sanctum\SanctumServiceProvider::class,
    \App\Providers\AppServiceProvider::class,
] as $provider) {
    $app->register($provider);
}

return $app;
