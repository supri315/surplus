<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('locale')->group(function () {
	Route::group(['prefix' => '/{locale}'], function()
	{
        //category
        Route::get('category', [CategoryController::class, 'index']);
        Route::get('category/{id}', [CategoryController::class, 'show']);
        Route::post('category/create', [CategoryController::class, 'create']);
        Route::post('category/update/{id}', [CategoryController::class, 'update']);
        Route::delete('category/{id}', [CategoryController::class, 'delete']);

	});
});


