<?php

use App\Http\Controllers\CadastralParcelController;
use App\Http\Resources\CadastralParcelResource;
use App\Http\Resources\OwnerResource;
use App\Http\Resources\UserResource;
use App\Models\CadastralParcel;
use App\Models\Owner;
use App\Models\User;
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

});


    // Export API 
    Route::prefix('export')->name('v1.app.')->group(function () {
        Route::get("/users", function(){
            return UserResource::collection(User::all());
        })->name('export_users');
        Route::get("/owners", function(){
            return OwnerResource::collection(Owner::all());
        })->name('export_owners');
        Route::get("/cadastral_parcel/{id}", function(string $id){
            return new CadastralParcelResource(CadastralParcel::findOrFail($id));
        })->name('cadastral_parcels');
    });
