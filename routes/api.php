<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryProductController;
use App\Http\Controllers\Api\ImageController;
use App\Http\Controllers\Api\ProductImageController;

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

        //product
        Route::get('product', [ProductController::class, 'index']);
        Route::get('product/{id}', [ProductController::class, 'show']);
        Route::post('product/create', [ProductController::class, 'create']);
        Route::post('product/update/{id}', [ProductController::class, 'update']);
        Route::delete('product/{id}', [ProductController::class, 'delete']);

        //category product
        Route::get('categoryproduct', [CategoryProductController::class, 'index']);
        Route::get('categoryproduct/{id}', [CategoryProductController::class, 'show']);
        Route::post('categoryproduct/create', [CategoryProductController::class, 'create']);
        Route::post('categoryproduct/update/{id}', [CategoryProductController::class, 'update']);
        Route::delete('categoryproduct/{id}', [CategoryProductController::class, 'delete']);

        //image
        Route::get('image', [ImageController::class, 'index']);
        Route::get('image/{id}', [ImageController::class, 'show']);
        Route::post('image/create', [ImageController::class, 'create']);
        Route::post('image/update/{id}', [ImageController::class, 'update']);
        Route::delete('image/{id}', [ImageController::class, 'delete']);

        //product image
        Route::get('productimage', [ProductImageController::class, 'index']);
        Route::get('productimage/{id}', [ProductImageController::class, 'show']);
        Route::post('productimage/create', [ProductImageController::class, 'create']);
        Route::post('productimage/update/{id}', [ProductImageController::class, 'update']);
        Route::delete('productimage/{id}', [ProductImageController::class, 'delete']);

        //product with image and category
        Route::get('products', [ProductController::class, 'allProducts']);
        Route::get('products/{id}', [ProductController::class, 'showAllProducts']);
        Route::post('products/create', [ProductController::class, 'createAllProducts']);
        Route::post('products/update/{id}', [ProductController::class, 'updateAllProducts']);
        Route::delete('products/{id}', [ProductController::class, 'deleteAllProducts']);

	});
});


