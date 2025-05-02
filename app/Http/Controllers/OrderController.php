<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\Order;
use App\Http\Resources\orderResource;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = order::all();
        return new orderResource($orders, 'Data order ditemukan', 'success');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'buyer_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'order_date' => 'required|date',
        ]);

        if ($validator->fails()) {
            return new orderResource(null, 'Failed', $validator->errors());
        }

        $buyerResponse = Http::get("http://127.0.0.1:8000/api/buyers/{$request->buyer_id}");
        if (!$buyerResponse->ok() || !$buyerResponse['data']) {
            return new orderResource(null, 'error', 'Buyer tidak ditemukan');
        }
        $buyer = $buyerResponse['data'];

        $productResponse = Http::get("http://127.0.0.1:8002/api/products/{$request->product_id}");
        if (!$productResponse->ok() || !$productResponse['data']) {
            return new orderResource(null, 'error', 'Product tidak ditemukan');
        }
        $product = $productResponse['data'];

        $total_price = $product['price'] * $request->quantity;
        
        $order = Order::create([
            'buyer_id'      => $request->buyer_id,
            'product_id'   => $request->product_id,
            'name'         => $buyer['name'],
            'phone'        => $buyer['phone'],
            'product_name' => $product['name'],
            'size'  => $product['size'],
            'quantity'     => $request->quantity,
            'total_price'  => $total_price,
            'order_date'   => $request->order_date,
        ]);

        return new orderResource($order, 'Success', 'Order created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = order::find($id);

        if ($order) {
            return new orderResource($order, 'Data pembelian Ditemukan', 'success');
        } else {
            return new orderResource(null, 'Data Pembelian tidak ditemukan', 'error');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
