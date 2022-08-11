<?php

use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Trello\Authorization\AuthorizationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/generate-report', [ReportController::class, 'generateReport'])->name('report.generate');

Route::get('/authorizing-a-client', [AuthorizationController::class, 'show'])->name('authorization.form');
Route::post('/authorizing-a-client-request', [AuthorizationController::class, 'getAuthorized'])->name('authorization.request');
Route::get('/boards', [AuthorizationController::class, 'getAllBoards'])->name('all.boards');

Route::get('/create-board', [AuthorizationController::class, 'createBoard'])->name('create.board');
Route::post('/store-board', [AuthorizationController::class, 'storeBoard'])->name('store.board');

Route::get('/edit-board/{id}', [AuthorizationController::class, 'editBoard'])->name('edit.board');
Route::post('/update-board/{id}', [AuthorizationController::class, 'updateBoard'])->name('update.board');
Route::get('/delete-board/{id}', [AuthorizationController::class, 'deleteBoard'])->name('delete.board');

Route::get('/boards/all-lists/{id}', [AuthorizationController::class, 'getAllLists'])->name('all.lists');
Route::get('/boards/lists/create-list', [AuthorizationController::class, 'createList'])->name('create.list');
Route::post('/boards/lists/store-list', [AuthorizationController::class, 'storeList'])->name('store.list');

Route::get('/boards/lists/all-cards/{id}', [AuthorizationController::class, 'getAllCards'])->name('all.cards');
Route::get('/boards/lists/show-card/{id}', [AuthorizationController::class, 'getSingleCard'])->name('show.card');
Route::get('/boards/lists/create-card', [AuthorizationController::class, 'createCard'])->name('create.card');
Route::post('/boards/lists/store-card', [AuthorizationController::class, 'storeCard'])->name('store.card');

Route::get('/logout', [AuthorizationController::class, 'logout'])->name('logout');
