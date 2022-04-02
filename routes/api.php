<?php

use App\Http\Controllers\DicaController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\ModeloController;
use App\Http\Controllers\TipoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VeiculoController;
use App\Http\Controllers\VersaoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['middleware' => ['cors']], function () {
    Route::post('login', [UserController::class, 'login'])->name('user.login');
    Route::post('user', [UserController::class, 'store'])->name('user.store');
    Route::post('tip/search', [DicaController::class, 'search'])->name('tip.search');
});


Route::group(['middleware' => ['cors', 'jwt.verify']], function () {
    //Users
    Route::apiResource('user', UserController::class, ['except' => 'store']);
    Route::post('logout', [UserController::class, 'logout'])->name('user.logout');

    //Type
    Route::apiResource('type', TipoController::class);
    Route::post('type/search', [TipoController::class, 'search'])->name('type.search');

    //Brand
    Route::apiResource('brand', MarcaController::class);
    Route::post('brand/search', [MarcaController::class, 'search'])->name('brand.search');

    //Model
    Route::apiResource('model', ModeloController::class);
    Route::post('model/search', [ModeloController::class, 'search'])->name('model.search');

    //Version
    Route::apiResource('version', VersaoController::class);
    Route::post('version/search', [VersaoController::class, 'search'])->name('version.search');

    //Vehicle
    Route::apiResource('vehicle', VeiculoController::class);
    Route::post('vehicle/search', [VeiculoController::class, 'search'])->name('vehicle.search');

    //Tip
    Route::apiResource('tip', DicaController::class);
});
