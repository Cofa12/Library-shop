<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\LibraryRepositoryInterface;
use App\Repositories\LibraryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            LibraryRepositoryInterface::class,
            LibraryRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Illuminate\Http\Resources\Json\JsonResource::withoutWrapping();
    }
}
