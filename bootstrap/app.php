<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectTo(
            guests: fn($request) => $request->is('admin*') ? route('admin.login') : route('login'),
            users: function ($request) {
                if (auth('admin')->check())
                    return route('admin.dashboard');
                if (auth('company')->check())
                    return route('company.dashboard');
                return route('profile');
            }
        );

        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
            'permission' => \App\Http\Middleware\CheckPermission::class,
            'employer' => \App\Http\Middleware\EnsureUserIsEmployer::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
