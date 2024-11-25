<?php

use App\Http\Controllers\TodosConroller;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/all' , [TodosConroller::class , 'index']);
Route::get('/all/{todo}' , [TodosConroller::class , 'single']);
Route::post('/store' , [TodosConroller::class , 'store']);
Route::delete('/suppr/{todo}' , [TodosConroller::class , 'fafaina']);
Route::put('/updt/{todo}' , [TodosConroller::class , 'update']);


Route::post('/registration' , [UserController::class , 'registration']);
Route::post('/login' , [UserController::class , 'login']);


