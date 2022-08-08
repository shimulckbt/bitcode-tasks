<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Console\Input\Input;

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


    $twoDarrOld = json_decode($report, true);

    //////    Fetched Data     //////////

    // $singleArray = array();
    // foreach ($report as $key => $value) {
    //     $singleArray[$key] = $value['plan'];
    // }

    /////////     UNCOMMENT THIS PART     ////////

    $twoDarrNew = array(
        12 => array(
            "created_at" => "2022-08-02T06:35:16.704Z",
            "name" => "Shimul",
            "order_no" => 31383123,
            "user_phone" => "288-595-1866 s687",
            "product_code" => "f472e9e7-a197-4c6b-bafe-bed21ff5d707",
            "product_name" => "Chair",
            "product_price" => "860.00",
            "purchase_quantity" => 2,
        ),
        13 => array(
            "created_at" => "2022-08-02T06:35:16.704Z",
            "name" => "Palash",
            "order_no" => 313831234,
            "user_phone" => "288-595-1866 p687",
            "product_code" => "f472e9e7-a197-4c6b-bafe-bed21ff5d707",
            "product_name" => "Chair",
            "product_price" => "860.00",
            "purchase_quantity" => 2,
        ),
    );

    $twoDarr = array_merge($twoDarrOld, $twoDarrNew);

    dump(count($twoDarr));
    // dd($twoDarr);

    $arr_count = count($twoDarr);
    if (empty(DB::table('report')->count())) {
        for ($i = 0; $i < $arr_count; $i++) {
            $singleArray = $twoDarr[$i];
            $singleObject = (object)$singleArray;
            DB::table('report')->insert([
                'order_no' => $singleObject->order_no,
                'name' => $singleObject->name,
                'product_name' => $singleObject->product_name,
                'product_price' => $singleObject->product_price,
                'purchase_quantity' => $singleObject->purchase_quantity,
            ]);
        }
    } else {
        for ($i = 0; $i < $arr_count; $i++) {
            $singleArray = $twoDarr[$i];
            $singleObject = (object)$singleArray;
            $exists = DB::table('report')->where('order_no', $singleObject->order_no)->first();

            if ($exists) {
                continue;
            } else {
                DB::table('report')->insert([
                    'order_no' => $singleObject->order_no,
                    'name' => $singleObject->name,
                    'product_name' => $singleObject->product_name,
                    'product_price' => $singleObject->product_price,
                    'purchase_quantity' => $singleObject->purchase_quantity,
                ]);
            }
        }
    }

    // for ($i = 0; $i < $arr_count; $i++) {
    //     $singleArray = $twoDarr[$i];
    //     $singleObject = (object)$singleArray;
    //     DB::table('report')->insert([
    //         'order_no' => $singleObject->order_no,
    //         'name' => $singleObject->name,
    //         'product_name' => $singleObject->product_name,
    //         'product_price' => $singleObject->product_price,
    //         'purchase_quantity' => $singleObject->purchase_quantity,
    //     ]);
    //     dump($singleObject);
    //     // $singleArray = array_reduce($twoDarr, 'array_merge', array());
    //     // dump($singleArray);

    //     // for ($j = 0; $j < count($singleArray); $i++) {
    //     //     $singleArray = array_reduce($twoDarr, 'array_merge', array());
    //     //     dump($singleArray);
    //     // }
    // }

    /////////     UNCOMMENT THIS PART     ////////


    $top_purchaser = DB::table('report')
        ->select('name', DB::raw('SUM(product_price*purchase_quantity) as total_amount'))
        ->groupBy('name')
        ->orderBy('total_amount', 'desc')
        ->get();

    dd($top_purchaser);

    // return json_decode($report);
});
