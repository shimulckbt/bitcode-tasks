<?php

use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Trello\Authorization\AuthorizationController;
use App\Http\Controllers\Trello\Board\BoardController;
use App\Http\Controllers\Trello\Card\CardController;
use App\Http\Controllers\Trello\List\ListController;
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

Route::get('/authorizing-a-client', [AuthorizationController::class, 'showForm'])->name('authorization.form');
Route::post('/authorizing-a-client-request', [AuthorizationController::class, 'getAuthorized'])->name('authorization.request');

Route::group(
    ['middleware' => ['user.auth', 'prevent.back.history']],
    function () {
        Route::get('/logout', [AuthorizationController::class, 'logout'])->name('logout');

        Route::get('/boards', [BoardController::class, 'getAllBoards'])->name('all.boards');
        Route::get('/create-board', [BoardController::class, 'createBoard'])->name('create.board');
        Route::post('/store-board', [BoardController::class, 'storeBoard'])->name('store.board');
        Route::get('/edit-board/{id}', [BoardController::class, 'editBoard'])->name('edit.board');
        Route::post('/update-board/{id}', [BoardController::class, 'updateBoard'])->name('update.board');
        Route::get('/delete-board/{id}', [BoardController::class, 'deleteBoard'])->name('delete.board');

        Route::get('/boards/all-lists/{id}', [ListController::class, 'getAllLists'])->name('all.lists');
        Route::get('/boards/lists/create-list', [ListController::class, 'createList'])->name('create.list');
        Route::post('/boards/lists/store-list', [ListController::class, 'storeList'])->name('store.list');

        Route::get('/boards/lists/all-cards/{listID}/{boardID}', [CardController::class, 'getAllCards'])->name('all.cards');
        Route::get('/boards/lists/show-card/{id}', [CardController::class, 'getSingleCard'])->name('show.card');
        Route::get('/boards/lists/create-card', [CardController::class, 'createCard'])->name('create.card');
        Route::post('/boards/lists/store-card', [CardController::class, 'storeCard'])->name('store.card');
    }
);
