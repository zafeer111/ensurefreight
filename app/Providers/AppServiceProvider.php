<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Customer;
use App\Models\CustomerUser;
use App\Observers\CustomerObserver;
use App\Observers\CustomerUserObserver;
use App\Services\PolarisApiService;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(PolarisApiService::class, function ($app) {
            $polarisUrl = Config::get('constants.polaris.url');
            $apiKey = Config::get('constants.polaris.key');

            return new PolarisApiService($polarisUrl, $apiKey);
        });
    }
    protected $widgets = [
        InquiryWidget::class,
        // Add other widgets here
    ];

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Customer::observe(CustomerObserver::class);
        CustomerUser::observe(CustomerUserObserver::class);
    }
}