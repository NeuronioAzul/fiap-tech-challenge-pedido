<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use TechChallenge\Infra\DB\Eloquent\{Customer\Model as Customer, Category\Model as Category, Order\Model as Order, Product\Model as Product};


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
        Factory::guessFactoryNamesUsing(function ($modelName) {
            if ($modelName === Customer::class) {
                return 'Database\\Factories\\CustomerFactory';
            }

            if ($modelName === Category::class) {
                return 'Database\\Factories\\CategoryFactory';
            }

            if ($modelName === Order::class) {
                return 'Database\\Factories\\OrderFactory';
            }

            if ($modelName === Product::class) {
                return 'Database\\Factories\\ProductFactory';
            }

            return 'Database\\Factories\\' . class_basename($modelName) . 'Factory';
        });
    }
}
