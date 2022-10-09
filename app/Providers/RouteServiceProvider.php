<?php

namespace App\Providers;

use App\Models\Administration\Trip;
use App\Repositories\Interfaces\ReservationRepositoryInterface;
use App\Repositories\Interfaces\StationRepositoryInterface;
use App\Repositories\Interfaces\TripRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\ReservationRepository;
use App\Repositories\StationRepository;
use App\Repositories\TripRepository;
use App\Repositories\UserRepository;
use App\Services\Interfaces\ReservationServiceInterface;
use App\Services\Interfaces\StationServiceInterface;
use App\Services\Interfaces\TripServiceInterface;
use App\Services\ReservationService;
use App\Services\StationService;
use App\Services\TripService;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });


        $this->app->bind(TripServiceInterface::class, TripService::class);
        $this->app->bind(TripRepositoryInterface::class, TripRepository::class);

        $this->app->bind(ReservationServiceInterface::class, ReservationService::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);

        $this->app->bind(StationServiceInterface::class, StationService::class);
        $this->app->bind(StationRepositoryInterface::class, StationRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
