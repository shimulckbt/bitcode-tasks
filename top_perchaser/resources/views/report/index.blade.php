@extends('layouts.app')
@section('content')
    <div class="container pt-5">
        <div class="items-center">
            <div class="table-responsive">
                <table class="table table-bordered border-primary">
                    <thead class="table-primary">
                        <tr>
                            {{-- <th scope="col">#</th> --}}
                            <th scope="col">Product Name</th>
                            <th scope="col">Customer Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topPurchasers as $topPurchaser)
                            <tr>
                                {{-- <th scope="row">{{ $loop->iteration }} </th> --}}
                                <td>{{ $topPurchaser->product->product_name }}</td>
                                <td>{{ $topPurchaser->customer->name }}</td>
                                <td>{{ $topPurchaser->total_purchase_quantity }}</td>
                                <td>{{ $topPurchaser->product->product_price }}</td>
                                <td>{{ $topPurchaser->total_purchase }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="2" class="text-end">Gross Total</td>
                            <td>{{ $grossTotalPurchaseQuantity }}</td>
                            <td>{{ number_format($grossTotalProductPrice, 2) }}</td>
                            <td>{{ number_format($grossTotalPurchaseAmount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
