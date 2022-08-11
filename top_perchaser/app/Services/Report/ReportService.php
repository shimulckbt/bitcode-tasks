<?php

namespace App\Services\Report;

use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Traits\Customer\HasCustomer;
use Illuminate\Support\Facades\DB;

class ReportService
{
	use HasCustomer;

	public function getReport($responseBody)
	{
		$totalPurchasedOrder = count($responseBody);

		$allCustomersPhoneNumber = array_column($responseBody, 'user_phone');

		$uniqueCustomersPhoneNumber = array_unique($allCustomersPhoneNumber);

		for ($i = 0; $i < count($uniqueCustomersPhoneNumber); $i++) {
			$singleCustomerArray = $responseBody[array_keys($uniqueCustomersPhoneNumber)[$i]];
			$singleCustomerObject = (object)$singleCustomerArray;

			$created_at = date('Y-m-d H:i:s', strtotime($singleCustomerObject->created_at));

			DB::table('customers')->insert([
				'name' => $singleCustomerObject->name,
				'phone' => $singleCustomerObject->user_phone,
				'created_at' => $created_at,
			]);
		}

		$allProductCodes = array_column($responseBody, 'product_code');

		$uniqueProductCodes = array_unique($allProductCodes);

		for ($i = 0; $i < count($uniqueProductCodes); $i++) {
			$singleProductArray = $responseBody[array_keys($uniqueProductCodes)[$i]];
			$singleProductObject = (object)$singleProductArray;

			$created_at = date('Y-m-d H:i:s', strtotime($singleProductObject->created_at));

			DB::table('products')->insert([
				'product_name' => $singleProductObject->product_name,
				'product_code' => $singleProductObject->product_code,
				'product_price' => $singleProductObject->product_price,
				'created_at' => $created_at,
			]);
		}

		for ($i = 0; $i < $totalPurchasedOrder; $i++) {
			$singleOrderArray = $responseBody[$i];
			$singleOrderObject = (object)$singleOrderArray;
			$customer_id = DB::table('customers')->where('phone', $singleOrderObject->user_phone)->first()->id;
			$product = DB::table('products')->where('product_code', $singleOrderObject->product_code)->first();

			$created_at = date('Y-m-d H:i:s', strtotime($singleOrderObject->created_at));

			DB::table('orders')->insert([
				'customer_id' => $customer_id,
				'product_id' => $product->id,
				'order_no' => $singleOrderObject->order_no,
				'purchase_quantity' => $singleOrderObject->purchase_quantity,
				'product_price' => $singleOrderObject->product_price,
				'created_at' => $created_at,
			]);
		}

		$topPurchasers = Order::with(['customer', 'product'])->groupBy('customer_id', 'product_id')->selectRaw('sum(purchase_quantity*product_price) as total_purchase,customer_id,product_id')->orderBy('total_purchase', 'desc')->get()->all();

		$grossTotalQuantity = Order::all()->sum('purchase_quantity');
		$grossTotalProductPrice = Order::all()->sum('product_price');
		$grossTotalPurchaseAmount = Order::selectRaw('sum(product_price * purchase_quantity) as total_amount')->get()->first()->total_amount;
		$data = compact('topPurchasers', 'grossTotalQuantity', 'grossTotalProductPrice', 'grossTotalPurchaseAmount');


		$top_purchaser = DB::table('report')
			->select('name', DB::raw('SUM(product_price*purchase_quantity) as total_amount'))
			->groupBy('name')
			->orderBy('total_amount', 'desc')
			->get();
		// dd($tootalQuantity);

		return $data;
	}
}
