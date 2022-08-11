<?php

namespace App\Services\Report;

use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Traits\Customer\HasCustomer;
use Illuminate\Support\Facades\DB;

class ReportService
{
	use HasCustomer;

	public function getReport($twoDimensionArray)
	{
		$arrayCount = count($twoDimensionArray);
		$allCustomersPhoneNumber = array_column($twoDimensionArray, 'user_phone');

		$uniqueCustomersPhoneNumber = array_unique($allCustomersPhoneNumber);

		for ($i = 0; $i < count($uniqueCustomersPhoneNumber); $i++) {
			$singleArray = $twoDimensionArray[array_keys($uniqueCustomersPhoneNumber)[$i]];
			$singleObject = (object)$singleArray;

			$created_at = date('Y-m-d H:i:s', strtotime($singleObject->created_at));

			DB::table('customers')->insert([
				'name' => $singleObject->name,
				'phone' => $singleObject->user_phone,
				'created_at' => $created_at,
			]);
		}

		$allProductsCode = array_column($twoDimensionArray, 'product_code');

		$uniqueProductsCode = array_unique($allProductsCode);

		for ($i = 0; $i < count($uniqueProductsCode); $i++) {
			$singleArray = $twoDimensionArray[array_keys($uniqueProductsCode)[$i]];
			$singleObject = (object)$singleArray;

			$created_at = date('Y-m-d H:i:s', strtotime($singleObject->created_at));

			DB::table('products')->insert([
				'product_name' => $singleObject->product_name,
				'product_code' => $singleObject->product_code,
				'product_price' => $singleObject->product_price,
				'created_at' => $created_at,
			]);
		}

		for ($i = 0; $i < $arrayCount; $i++) {
			$singleArray = $twoDimensionArray[$i];
			$singleObject = (object)$singleArray;
			$customer_id = DB::table('customers')->where('phone', $singleObject->user_phone)->first()->id;
			$product = DB::table('products')->where('product_code', $singleObject->product_code)->first();

			$created_at = date('Y-m-d H:i:s', strtotime($singleObject->created_at));

			DB::table('orders')->insert([
				'customer_id' => $customer_id,
				'product_id' => $product->id,
				'order_no' => $singleObject->order_no,
				'purchase_quantity' => $singleObject->purchase_quantity,
				'product_price' => $singleObject->product_price,
				'created_at' => $created_at,
			]);
		}

		$topPurchasers = Order::with(['customer', 'product'])->groupBy('customer_id', 'product_id')->selectRaw('sum(purchase_quantity*product_price) as total_purchase,customer_id,product_id')->orderBy('total_purchase', 'desc')->get()->all();

		$grossTotalQuantity = Order::all()->sum('purchase_quantity');
		$grossTotalProductPrice = Order::all()->sum('product_price');
		$grossTotalPurchaseAmount = Order::selectRaw('sum(product_price * purchase_quantity) as total_amount')->get()->first()->total_amount;
		$data = compact('topPurchasers', 'grossTotalQuantity', 'grossTotalProductPrice', 'grossTotalPurchaseAmount');
		// dd($tootalQuantity);

		return $data;
	}
}
