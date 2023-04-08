<?php

namespace App\Providers;

use App\Contracts\AttachmentServiceInterface;
use App\Contracts\HttpWrapperInterface;
use App\Contracts\UserServiceInterface;
use App\Services\AttachmentService;
use App\Services\HttpWrapper;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application Services.
     */
    public function register(): void
    {
        //
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(HttpWrapperInterface::class, HttpWrapper::class);
        $this->app->bind(AttachmentServiceInterface::class, AttachmentService::class);

    }

    /**
     * Bootstrap any application Services.
     */
    public function boot(): void
    {
        //
    }
}
