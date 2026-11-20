<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Trust all proxies (essential for Coolify / Traefik / Cloudflare / LiteSpeed reverse proxies & SSL)
        $middleware->trustProxies(at: '*', headers: \Illuminate\Http\Request::HEADER_X_FORWARDED_FOR |
            \Illuminate\Http\Request::HEADER_X_FORWARDED_HOST |
            \Illuminate\Http\Request::HEADER_X_FORWARDED_PORT |
            \Illuminate\Http\Request::HEADER_X_FORWARDED_PROTO |
            \Illuminate\Http\Request::HEADER_X_FORWARDED_AWS_ELB
        );

        $middleware->validateCsrfTokens(except: [
            'seller/login',
            'seller/login/*',
            'admin/login',
            'admin/login/*',
            'customer/login',
            'customer/login/*',
            'cart/*',
            'cart*',
            'cart/checkout',
            'checkout',
            '*/checkout',
            'refresh-csrf',
        ]);

        $middleware->redirectGuestsTo(function (\Illuminate\Http\Request $request) {
            if ($request->is('admin*') || $request->is('super/admin*')) {
                return route('admin.login');
            }
            return route('seller.login');
        });
        $middleware->alias([
            'seller'          => \App\Http\Middleware\EnsureSeller::class,
            'seller.approved' => \App\Http\Middleware\EnsureSellerApproved::class,
            'seller.active'   => \App\Http\Middleware\EnsureSellerApproved::class,
            'superadmin'      => \App\Http\Middleware\EnsureSuperAdmin::class,
            'admin'           => \App\Http\Middleware\EnsureSuperAdmin::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // Gracefully handle 419 CSRF Token Mismatches / Expired Sessions
        $exceptions->render(function (\Illuminate\Session\TokenMismatchException $e, \Illuminate\Http\Request $request) {
            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'CSRF token mismatch or session expired. Please refresh the page and try again.',
                ], 419);
            }

            if ($request->is('seller*')) {
                return redirect()->route('seller.login')->with('warning', 'Your session expired. Please sign in again.');
            }
            if ($request->is('admin*') || $request->is('super/admin*')) {
                return redirect()->route('admin.login')->with('warning', 'Your session expired. Please sign in again.');
            }

            return redirect()->back()
                ->withInput($request->except(['_token', 'password', 'password_confirmation']))
                ->with('warning', 'Your session expired due to inactivity. Please submit again.');
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\HttpException $e, \Illuminate\Http\Request $request) {
            if ($e->getStatusCode() === 419) {
                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'message' => 'Session expired. Please refresh the page and try again.',
                    ], 419);
                }

                if ($request->is('seller*')) {
                    return redirect()->route('seller.login')->with('warning', 'Your session expired. Please sign in again.');
                }
                if ($request->is('admin*') || $request->is('super/admin*')) {
                    return redirect()->route('admin.login')->with('warning', 'Your session expired. Please sign in again.');
                }

                return redirect()->back()
                    ->withInput($request->except(['_token', 'password', 'password_confirmation']))
                    ->with('warning', 'Your session expired due to inactivity. Please submit again.');
            }
        });
    })->create();
