<?php

namespace App\Providers;

use App\Repositories\Airport\AirportRepository;
use App\Repositories\Airport\IAirport;
use App\Repositories\Bol\BolRepository;
use App\Repositories\Bol\IBol;
use App\Repositories\Booking\BookingRepository;
use App\Repositories\Booking\IBooking;
use App\Repositories\Ensurefreight\EnsureRepository;
use App\Repositories\Ensurefreight\IEnsure;
use App\Repositories\Quotation\IQuotation;
use App\Repositories\Quotation\QuotationRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(IAirport::class, AirportRepository::class);
        $this->app->bind(IBooking::class, BookingRepository::class);
        $this->app->bind(IQuotation::class, QuotationRepository::class);
        $this->app->bind(IEnsure::class, EnsureRepository::class);
        $this->app->bind(IBol::class, BolRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
