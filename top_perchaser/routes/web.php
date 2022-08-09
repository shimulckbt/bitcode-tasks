<?php

use App\Http\Controllers\Report\ReportController;
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
});

Route::get('/report', [ReportController::class, 'generateReport']);


Route::get('/get-me', function () {
    $trelloHelper = new \App\Modules\Integrations\Trello\Trello();
    $trelloHelper->getUser();
});

Route::get('/get-all-boards', function () {
    $trelloHelper = new \App\Modules\Integrations\Trello\Trello();
    $trelloHelper->allBoards();
});

Route::get('/create-board', function () {
    $trelloHelper = new \App\Modules\Integrations\Trello\Trello();
    $trelloHelper->createBoard();
});
