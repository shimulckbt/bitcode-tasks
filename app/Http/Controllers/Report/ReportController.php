<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Services\Report\ReportService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Artisan;

class ReportController extends Controller
{
    private $reportService;


    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * generateReport
     *
     * @return view
     */
    public function generateReport()
    {
        try {
            $response = Http::get('https://raw.githubusercontent.com/Bit-Code-Technologies/mockapi/main/purchase.json');
            $responseBody = json_decode($response, true);

            date_default_timezone_set('Asia/Dhaka');

            if (empty(Order::count())) {
                $data = $this->reportService->getReport($responseBody);
                return view('report.index', $data);
            } else {
                Artisan::call('migrate:fresh');
                $data = $this->reportService->getReport($responseBody);
                return view('report.index', $data);
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
