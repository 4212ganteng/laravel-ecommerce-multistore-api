<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //create order
    public function store(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:adresses,id',
            'seller_id' => 'required|exists:adresses,id',
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer',
            'shipping_cost' => 'required|integer',
            'shipping_service' => 'required|string',
        ]);

        $user = $request->user();

        $totalPrice = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $totalPrice += $product->price * $item['quantity'];
        }

        $grandTotal = $totalPrice + $request->shipping_cost;

        $order = Order::create([
            'user_id' => $user->id,
            'address_id' => $request->address_id,
            'seller_id' => $request->seller_id,
            'shipping_price' => $request->shipping_cost,
            'shipping_service' => $request->shipping_service,
            'status' => 'PENDING',
            'total_price' => $totalPrice,
            'grand_total' => $grandTotal,
            'transaction_number' => 'TRX' . time(),
        ]);

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);

           OrderItem::create([
               'order_id' => $order->id,
               'product_id' => $item['product_id'],
               'price' => $product->price,
               'quantity' => $item['quantity']
           ]);
        }


        return response()->json([
            'status' => 'success',
            'message' => 'Order berhasil dibuat',
            'data' => $order
        ], 201);
    }
}
