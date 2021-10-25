<?php

use App\Http\Controllers\CadastralParcelController;
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

Route::name('api.')->group(function () {
    Route::middleware('auth:api')->get('/user', function (Request $request) {
        return $request->user();
    })->name('user');

    //    Route::prefix('cadastral-parcels')->name('cadastral_parcels.')->group(function () {
    //        Route::prefix('researches')->name('researches.')->group(function () {
    //            Route::post('/shapefile', [CadastralParcelController::class, 'researchesShapefile'])->name('shapefile');
    //        });
    //    });
});
