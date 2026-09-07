<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use App\Models\SeoSetting;
use App\Models\PageSeo;
use App\Models\ActivityLog;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register custom Cloudflare R2 driver
        \Illuminate\Support\Facades\Storage::extend('r2', function ($app, $config) {
            $key = $config['key'] ?? null;
            $secret = $config['secret'] ?? null;

            // If 32-character S3 Access Key ID is provided, use standard S3 client
            if (!empty($key) && strlen($key) === 32 && !empty($secret) && class_exists(\Aws\S3\S3Client::class)) {
                $s3Config = [
                    'version' => 'latest',
                    'region' => $config['region'] ?? 'auto',
                    'endpoint' => $config['endpoint'] ?? null,
                    'use_path_style_endpoint' => $config['use_path_style_endpoint'] ?? false,
                    'credentials' => [
                        'key' => $key,
                        'secret' => $secret,
                    ],
                ];
                $client = new \Aws\S3\S3Client($s3Config);
                $adapter = new \League\Flysystem\AwsS3V3\AwsS3V3Adapter($client, $config['bucket'], $config['root'] ?? '', null, null, $config['options'] ?? []);
                return new \Illuminate\Filesystem\FilesystemAdapter(new \League\Flysystem\Filesystem($adapter, $config), $adapter, $config);
            }

            // High-speed native Cloudflare R2 REST Adapter using API Token
            $accountId = $config['account_id'] ?? env('CLOUDFLARE_R2_ACCOUNT_ID', '9c88e6b05ab607d28ec4fba866c126c0');
            $token = $config['token'] ?? env('CLOUDFLARE_R2_TOKEN', '');
            $bucket = $config['bucket'] ?? env('CLOUDFLARE_R2_BUCKET', 'inaquired-r2');

            $adapter = new \App\Services\CloudflareR2Adapter($accountId, $token, $bucket);
            $filesystem = new \League\Flysystem\Filesystem($adapter, $config);

            return new \Illuminate\Filesystem\FilesystemAdapter($filesystem, $adapter, $config);
        });

        // Force HTTPS in production or on Railway
        if (config('app.env') === 'production' || str_contains(request()->getHost(), 'railway.app')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
            
            // Ensure the request itself is treated as secure if coming through a proxy
            if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
                request()->server->set('HTTPS', 'on');
            } elseif (config('app.env') === 'production') {
                // Hard force for production
                request()->server->set('HTTPS', 'on');
            }
        }

        // Share SEO settings and attempt to auto-resolve page-level SEO for all views
        View::composer('*', function ($view) {
            $viewName = $view->getName();
            // Do not run SEO logic on exception or error views to prevent infinite loops and DB connection errors during failure
            if (str_contains($viewName, 'errors::') || str_contains($viewName, 'laravel-exceptions-renderer::') || str_contains($viewName, 'exception')) {
                return;
            }

            try {
                $seoSettings = \App\Models\SeoSetting::getGlobalSettings();
                $view->with('seoSettings', $seoSettings);
            } catch (\Throwable $e) {
                $view->with('seoSettings', []);
            }

            // If a view already has an explicit `pageSeo`, don't override it
            if ($view->offsetExists('pageSeo') && $view->getData()['pageSeo']) {
                return;
            }

            $pageSeo = null;

            try {
                $route = request()->route();
                if ($route) {
                    $params = $route->parameters();

                    // Common model bindings: job, post, company, category
                    if (isset($params['job'])) {
                        $jobId = is_object($params['job']) ? ($params['job']->id ?? null) : $params['job'];
                        if ($jobId) {
                            $pageSeo = \App\Models\PageSeo::where('page_type', 'job')->where('page_id', $jobId)->first();
                        }
                    } elseif (isset($params['post'])) {
                        $postId = is_object($params['post']) ? ($params['post']->id ?? null) : $params['post'];
                        if ($postId) {
                            $pageSeo = \App\Models\PageSeo::where('page_type', 'post')->where('page_id', $postId)->first();
                        }
                    } elseif (isset($params['company'])) {
                        $companyId = is_object($params['company']) ? ($params['company']->id ?? null) : $params['company'];
                        if ($companyId) {
                            $pageSeo = \App\Models\PageSeo::where('page_type', 'company')->where('page_id', $companyId)->first();
                        }
                    } elseif (isset($params['category'])) {
                        $categoryId = is_object($params['category']) ? ($params['category']->id ?? null) : $params['category'];
                        if ($categoryId) {
                            $pageSeo = \App\Models\PageSeo::where('page_type', 'category')->where('page_id', $categoryId)->first();
                        }
                    } elseif (isset($params['pageSeo'])) {
                        // Route model binding to PageSeo
                        $pageSeoObj = $params['pageSeo'];
                        if (is_object($pageSeoObj) && $pageSeoObj->id) {
                            $pageSeo = $pageSeoObj;
                        }
                    } elseif (isset($params['slug'])) {
                        $slug = $params['slug'];
                        $pageSeo = \App\Models\PageSeo::getSeoForSlug($slug);
                    }
                }

                // If still not found, try matching by current path as a static slug
                if (!$pageSeo) {
                    $path = trim(request()->path(), '/');
                    if ($path && !str_contains($path, 'cms')) {
                        $pageSeo = \App\Models\PageSeo::getSeoForSlug($path);
                    }
                }
            } catch (\Exception $e) {
                // Fail silently — SEO settings should not break page rendering
                $pageSeo = null;
            }

            $view->with('pageSeo', $pageSeo);
        });

        // Track CMS Logins and Logouts dynamically
        Event::listen(Login::class, function (Login $event) {
            if ($event->guard === 'admin') {
                ActivityLog::create([
                    'admin_user_id' => $event->user->id,
                    'action'        => 'Logged In',
                    'target_name'   => 'System Session',
                    'target_type'   => 'Session',
                    'ip_address'    => request()->ip()
                ]);
            }
        });

        Event::listen(Logout::class, function (Logout $event) {
            if ($event->guard === 'admin' && $event->user) {
                ActivityLog::create([
                    'admin_user_id' => $event->user->id,
                    'action'        => 'Logged Out',
                    'target_name'   => 'System Session',
                    'target_type'   => 'Session',
                    'ip_address'    => request()->ip()
                ]);
            }
        });

        // Pass Recent Activities to CMS Layout safely
        View::composer('layouts.cms', function ($view) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('activity_logs')) {
                    $view->with('recentActivities', ActivityLog::with('adminUser')->latest()->take(15)->get());
                } else {
                    $view->with('recentActivities', collect());
                }
            } catch (\Exception $e) {
                $view->with('recentActivities', collect());
            }
        });
    }
}
