<?php

use Illuminate\Support\Facades\Route;
use TechChallenge\Api\Customer\Customer;
use TechChallenge\Api\Product\Product;
use TechChallenge\Api\Category\Category;
use TechChallenge\Api\Order\Order;

Route::controller(Product::class)
    ->prefix('/product')
    ->group(function () {
        Route::get('/', [Product::class, "index"]);
        Route::get('/{id}', [Product::class, "show"]);
    });

Route::controller(Customer::class)
    ->prefix('/customer')
    ->group(function () {
        Route::get('/{id}', [Customer::class, "show"]);
        Route::get('/cpf/{cpf}', [Customer::class, "showByCfp"]);    
    });

Route::controller(Category::class)
    ->prefix('/category')
    ->group(function () {
        Route::get('/', [Category::class, "index"]);
        Route::get('/{id}', [Category::class, "show"]);
    });

Route::controller(Order::class)
    ->prefix('/order')
    ->group(function () {
        Route::get('/', [Order::class, "index"]);
        Route::get('/{id}', [Order::class, "show"]);
        Route::post('/', [Order::class, "store"]);
        Route::put('/{id}', [Order::class, "update"]);
        Route::delete('/{id}', [Order::class, "delete"]);
        Route::post('/checkout/{id}', [Order::class, "checkout"]);
        Route::post('/status/{id}', [Order::class, "changeStatus"]);
        Route::post('/webhook', [Order::class, "webhook"]);
    });

    /*
    ************Rodar teste*****************
    php artisan test
    php artisan test --filter=CustomerTest
    php artisan test --filter=ProductTest
    php artisan test --filter=CategoryTest
    php artisan test --filter=OrderTest    
    */