<?php

declare(strict_types=1);

namespace Quotation\Converter\Providers;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\ServiceProvider;
use Quotation\Converter\Converter;

class QuotationServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register Converter as a singleton, resolved via the view factory
        $this->app->singleton(Converter::class, function ($app) {
            return new Converter($app->make(ViewFactory::class));
        });
    }

    public function boot(): void
    {
        // Load package views under the 'quotation-pkg' namespace
        $this->loadViewsFrom(
            dirname(__DIR__, 2) . '/resources/views',
            'quotation-pkg'
        );

        // Allow host applications to publish/override the views
        $this->publishes([
            dirname(__DIR__, 2) . '/resources/views' => resource_path('views/vendor/quotation-pkg'),
        ], 'quotation-views');
    }
}
