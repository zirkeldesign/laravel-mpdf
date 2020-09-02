<?php

namespace Meneses\LaravelMpdf;

use Illuminate\Support\ServiceProvider;

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
                    __DIR__.'/../config/pdf.php' => config_path('pdf.php'),
                ],
                ['config', 'pdf']
            );
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/pdf.php',
            'pdf'
        );

        $this->app->bind(
            'mpdf.wrapper',
            function () {
                return new LaravelMpdfWrapper();
            }
        );
    }
}
