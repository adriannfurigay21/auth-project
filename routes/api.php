<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\BusinessController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\MasterAdminController;
use App\Http\Controllers\TransactionController;



Route::group(['middleware' => ['guest']], function() {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
});


Route::middleware(['auth:user'])->group(function() {
    Route::prefix('auth')->group(function() {
        Route::post('/logout', [AuthController::class, 'logout']);
    });
  
    Route::prefix('masteradmin')->group(function() {
        Route::prefix('business')->group(function() {
            Route::post('/read', [MasterAdminController::class, 'read']);
            Route::post('/list', [MasterAdminController::class, 'list']);
            Route::post('/delete', [MasterAdminController::class, 'delete']);
        });

        Route::prefix('wallet')->group(function() {
            Route::post('/read', [MasterAdminController::class, 'readWallet']);
            Route::post('/list', [MasterAdminController::class, 'listWallet']);
            Route::post('/delete', [MasterAdminController::class, 'deleteWallet']);
        });
    });

    Route::prefix('user')->group(function() {
        Route::post('/create', [UserController::class, 'create']);
        Route::post('/read', [UserController::class, 'read']);
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/profile', [AuthController::class, 'profile']);
        Route::post('/list', [UserController::class, 'list']);
        Route::post('/delete', [UserController::class, 'delete']);
    });

    Route::prefix('client')->group(function() {
        Route::post('/register', [AuthController::class, 'register']);
    });

    Route::prefix('business')->group(function() {
        Route::post('/create', [BusinessController::class, 'create']);
        Route::post('/read', [BusinessController::class, 'read']);
        Route::post('/update', [BusinessController::class, 'update']);
        Route::post('/list', [BusinessController::class, 'list']);
        Route::post('/delete', [BusinessController::class, 'delete']);
    });
    
    Route::prefix('wallet')->group(function() {
        Route::post('/create', [WalletController::class, 'create']);
        Route::post('/read', [WalletController::class, 'read']);
        Route::post('/update', [WalletController::class, 'update']);
        Route::post('/list', [WalletController::class, 'list']);
        Route::post('/delete', [WalletController::class, 'delete']);
    });

    Route::prefix('transaction')->group(function() {
        Route::post('/create', [WalletController::class, 'create']);
        Route::post('/read', [WalletController::class, 'read']);
        Route::post('/update', [WalletController::class, 'update']);
        Route::post('/list', [WalletController::class, 'list']);
        Route::post('/delete', [WalletController::class, 'delete']);
    });
    
    



});
