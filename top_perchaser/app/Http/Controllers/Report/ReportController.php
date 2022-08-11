<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Services\Report\ReportService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function generateReport()
    {
        try {
            $dataSet = Http::get('https://raw.githubusercontent.com/Bit-Code-Technologies/mockapi/main/purchase.json');
            $twoDimensionArray = json_decode($dataSet, true);
            // dd($twoDimensionArray);

            date_default_timezone_set('Asia/Dhaka');

            if (empty(Order::count())) {
                $data = $this->reportService->getReport($twoDimensionArray);
                return view('report.index', $data);
            } else {
                Artisan::call('migrate:fresh');
                $data = $this->reportService->getReport($twoDimensionArray);
                return view('report.index', $data);
            }
        } catch (\Throwable $th) {
            throw $th;
        }










        // $topPurchasers = Order::with(['customer', 'product'])->select('customer_id', 'purchase_quantity', 'product_id', DB::raw('SUM(purchase_quantity) as total_quantity'))->groupBy('customer_id', 'purchase_quantity', 'product_id')->get()->all();

        // $topPurchasers = $this->reportService->getReport();

        // $topPurchasers = Order::with(['customer'])->get()->groupBy('customer.name')->all();

        // dd($topPurchasers);

        // $individualPurchaseQuantity = Order::with(['customer', 'product'])->select(DB::raw('SUM(purchase_quantity) as individual_purchase_quantity'))->groupBy('customer_id')->orderBy('individual_purchase_quantity', 'desc')->get();

        // $allCustomers = Order::with(['customer', 'product'])->get();

        // $totalPurchaseQuantity = Order::sum('purchase_quantity');

        // $grandTotal = Order::sum('total_price');

        // return view('report.index', compact('topPurchasers'));





        // $topPurchasers = Order::with(['customer', 'product'])->groupBy('customer_id', 'product_id')->selectRaw('sum(purchase_quantity) as total_quantity,customer_id,product_id')->orderBy('total_quantity', 'desc')->get()->all();

        // dd($topPurchasers);
    }
}
