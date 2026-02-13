<?php

namespace App\Providers;

use App\Events\OrderCompleted;
use App\Events\PaymentConfirmed;
use App\Events\sendOtp;
use App\Events\vendorRegister;
use App\Listeners\SendOrderEmail;
use App\Listeners\SendOTPEmail;
use App\Listeners\SendPaymentConfirmeEmail;
use App\Listeners\SendVendorWelcomeEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;

class AppServiceProvider extends ServiceProvider
{
    protected function configureRateLimiting(): void
{
    RateLimiter::for('winorder', function (\Illuminate\Http\Request $request) {
        return Limit::perMinute(30)   // adjust if needed
            ->by(
                $request->header('app-key')
                ?? $request->ip()
            );
    });
}
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
        $this->configureRateLimiting();
        Event::listen(sendOtp::class, SendOTPEmail::class);
        Event::listen(vendorRegister::class, SendVendorWelcomeEmail::class);
        Event::listen(OrderCompleted::class, SendOrderEmail::class);
        Event::listen(PaymentConfirmed::class, SendPaymentConfirmeEmail::class);
    }
}
