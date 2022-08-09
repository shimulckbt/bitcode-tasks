<?php

namespace App\Services\Report;

use App\Models\Customer\Customer;
use App\Traits\Customer\HasCustomer;
use Illuminate\Support\Facades\DB;

class ReportService
{
	use HasCustomer;

	public function getReport($report)
	{
		$twoDimensionArray = json_decode($report, true);

		$arrayCount = count($twoDimensionArray);
		$allCustomersPhoneNumber = array_column($twoDimensionArray, 'user_phone');

		$uniqueCustomer = array_unique($allCustomersPhoneNumber);

		// dd(array_keys($uniqueCustomer));

		date_default_timezone_set('Asia/Dhaka');
		// dd(Customer::count());

		if (empty(Customer::count())) {
			for ($i = 0; $i < count($uniqueCustomer); $i++) {
				$singleArray = $twoDimensionArray[array_keys($uniqueCustomer)[$i]];
				$singleObject = (object)$singleArray;

				$created_at = date('Y-m-d H:i:s', strtotime($singleObject->created_at));
				DB::table('customers')->insert([
					'name' => $singleObject->name,
					'phone' => $singleObject->user_phone,
					'created_at' => $created_at,
				]);
			}
		} else {
			for ($i = 0; $i < $uniqueCustomer; $i++) {
				$singleArray = $twoDimensionArray[$i];
				$singleObject = (object)$singleArray;

				$customerExists = DB::table('customers')->where('phone', $singleObject->user_phone)->first();

				if ($customerExists) {
					continue;
				} else {
					$created_at = date('Y-m-d H:i:s', strtotime($singleObject->created_at));
					DB::table('customers')->insert([
						'name' => $singleObject->name,
						'phone' => $singleObject->user_phone,
						'created_at' => $created_at,
					]);
				}
			}
		}

		dd($uniqueCustomer);

		if (empty(DB::table('orders ')->count())) {
			for ($i = 0; $i < $arrayCount; $i++) {
				$singleArray = $twoDimensionArray[$i];
				$singleObject = (object)$singleArray;
				DB::table('orders')->insert([
					// 'customer_id' => $customer_id,
					// 'product_id' => $product_id,
					'order_no' => $singleObject->order_no,
					'name' => $singleObject->name,
					'product_name' => $singleObject->product_name,
					'product_price' => $singleObject->product_price,
					'purchase_quantity' => $singleObject->purchase_quantity,
				]);
			}
		} else {
			for ($i = 0; $i < $arrayCount; $i++) {
				$singleArray = $twoDimensionArray[$i];
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
	}
}
