<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
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

Route::get('/report', function () {
    $report = Http::get('https://raw.githubusercontent.com/Bit-Code-Technologies/mockapi/main/purchase.json');

    $twoDarr = json_decode($report, true);

    // $singleArray = array();
    // foreach ($report as $key => $value) {
    //     $singleArray[$key] = $value['plan'];
    // }

    dump(count($twoDarr));

    $arr_count = count($twoDarr);

    for ($i = 0; $i < $arr_count; $i++) {
        $singleArray = $twoDarr[$i];
        $singleObject = (object)$singleArray;
        DB::table('report')->insert([
            'name' => $singleObject->name,
            'product_name' => $singleObject->product_name,
            'product_price' => $singleObject->product_price,
            'purchase_quantity' => $singleObject->purchase_quantity,
        ]);
        dump($singleObject);
        // $singleArray = array_reduce($twoDarr, 'array_merge', array());
        // dump($singleArray);

        // for ($j = 0; $j < count($singleArray); $i++) {
        //     $singleArray = array_reduce($twoDarr, 'array_merge', array());
        //     dump($singleArray);
        // }
    }

    dd();

    $first_obj = (object)$report[0];

    DB::table('report')->insert([
        'name' => $first_obj->name,
        'product_name' => $first_obj->product_name,
        'product_price' => $first_obj->product_price,
        'purchase_quantity' => $first_obj->purchase_quantity,
    ]);

    dump($first_obj);
    dump($first_obj->created_at);
    dump($report[0]['name']);
    dd('json:', $report->json());
    // dump(count($report));
    // return $report->json();
    dump($report[0]->name);
    return json_decode($report);
});
