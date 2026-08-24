<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WorkerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


//public routes
Route::post('/login', [AuthController::class, 'login']);


//authenticated routes
Route::middleware('auth:api-token')->group(function () {
//    route responsible for loggint the user out
    Route::post('logout', [AuthController::class, 'logout']);

//    managing customers
    Route::prefix('customers')->group(function () {
        Route::post('', [CustomerController::class, 'store']);
        Route::get('', [CustomerController::class, 'index']);
        Route::get('{model}', [CustomerController::class, 'show']);
        Route::put('{model}', [CustomerController::class, 'update']);
        Route::delete('{model}', [CustomerController::class, 'destroy']);
    });
//    managing workers
    Route::prefix('workers')->group(function () {
        Route::post('', [WorkerController::class, 'store']);
        Route::get('', [WorkerController::class, 'index']);
        Route::get('{model}', [WorkerController::class, 'show']);
        Route::put('{model}', [WorkerController::class, 'update']);
        Route::delete('{model}', [WorkerController::class, 'destroy']);
    });

//    managing plans
    Route::prefix('plans')->group(function () {
        Route::post('', [PlanController::class, 'store']);
        Route::get('', [PlanController::class, 'index']);
        Route::get('{model}', [PlanController::class, 'show']);
        Route::put('{model}', [PlanController::class, 'update']);
        Route::delete('{model}', [PlanController::class, 'destroy']);
    });

//    managing subscriptions
    Route::prefix('subscriptions')->group(function () {
        Route::post('', [SubscriptionController::class, 'store']);
        Route::get('', [SubscriptionController::class, 'index']);
        Route::get('{model}', [SubscriptionController::class, 'show']);
        Route::put('{model}', [SubscriptionController::class, 'update']);
        Route::delete('{model}', [SubscriptionController::class, 'destroy']);
        Route::delete('{model}/suspend', [SubscriptionController::class, 'suspend']);
    });

//    automatically creating transactions
    Route::prefix('transactions')->group(function () {
        Route::get('', [TransactionController::class, 'index']);
        Route::put('{transaction}', [TransactionController::class, 'update']);
        Route::post('{transaction}/mark-as-paid', [TransactionController::class, 'paid']);
    });
});
