<?php

namespace Meneses\LaravelMpdf\Providers;

use Illuminate\Support\ServiceProvider;
use Meneses\LaravelMpdf\LaravelMpdfWrapper;

class LaravelMpdfServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__ . '/../../config/pdf.php' => config_path('pdf.php'),
                ],
                ['config', 'pdf']
            );
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/pdf.php', 'pdf');

        $this->app->bind(
            'mpdf.wrapper',
            function () {
                return new LaravelMpdfWrapper();
            }
        );
    }
}
