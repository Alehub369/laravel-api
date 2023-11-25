<?php

use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RecipeController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::get('login', [LoginController::class, 'store']);


Route::middleware('auth:sanctum')->group(function () {
    Route::get('categories',             [CategoryController::class, 'index']);
    Route::get('categories/{category}',  [CategoryController::class, 'show']);

    Route::apiResource('recipes', RecipeController::class);

    Route::get('tags',                   [TagController::class, 'index']);
    Route::get('tags/{tag}',             [TagController::class, 'show']);
});
    







// Codigo largo que resume apiResource solo para saber
/* 

Route::get('recipes',                [RecipeController::class, 'index']);
Route::post('recipes',                [RecipeController::class, 'store']);
Route::get('recipes/{recipe}',       [RecipeController::class, 'show']);
Route::put('recipes/{recipe}',       [RecipeController::class, 'update']);
Route::delete('recipes/{recipe}',       [RecipeController::class, 'destroy']);
 */

// Codigo corto mismo resultado