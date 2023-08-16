<?php

use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ItemController;
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



Route::POST('register', [UserController::class,'register'])->name('register');
Route::post('login', [UserController::class,'login'])->name('login');

Route::middleware('jwt.verify')->group(function () {
    Route::get('checklist', [ChecklistController::class,'lists'])->name('checklist.lists');
    Route::post('checklist', [ChecklistController::class,'create'])->name('checklist.create');
    Route::delete('/checklist/{id}', [ChecklistController::class,'destroy'])->name('checklist.delete');

    Route::post('checklist/{id}/item', [ItemController::class,'create'])->name('item.create');
});
