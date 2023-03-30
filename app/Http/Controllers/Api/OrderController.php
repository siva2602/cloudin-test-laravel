<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index()
    {
        try {
            $orders = Order::with('order_items', 'order_items.product')->where('user_id', Auth::user()->id)->get();
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Order Retrieve Successfully',
                'data' => [
                    'order' => $orders
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            info($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function getAllOrders()
    {
        try {
            $orders = Order::with('user', 'user.customer', 'order_items', 'order_items.product')->get();
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Orders Retrieve Successfully',
                'data' => [
                    'orders' => $orders
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function store(OrderRequest $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->all();
            $order = Order::create([
                'bill_number' => $request['bill_number'],
                'user_id' => Auth::user()->id
            ]);
            $order->order_items()->createMany($request['order_items']);
            $order->update(['total_amount' => $order->order_items()->sum('total_amount')]);

            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Orders Stored Successfully',
                'data' => [
                    'orders' => Order::with('order_items')->findOrFail($order->id)
                ]
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function show($orderId)
    {
        try {
            $order = Order::with('order_items', 'order_items.product')->findOrFail($orderId);
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Orders Retrieve Successfully',
                'data' => [
                    'order' => $order
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function edit($orderId)
    {
        try {
            $order = Order::with('order_items', 'order_items.product')->findOrFail($orderId);
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Orders Edit Successfully',
                'data' => [
                    'order' => $order
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function update(OrderRequest $request, $orderId)
    {
        DB::beginTransaction();
        try {
            $request = $request->all();
            $order = Order::findOrFail($orderId);
            $order->order_items()->delete();
            $order->order_items()->createMany($request['order_items']);
            $order->update(['total_amount' => $order->order_items()->sum('total_amount')]);

            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Orders Stored Successfully',
                'data' => [
                    'orders' => Order::with('order_items', 'order_items.product')->findOrFail($order->id)
                ]
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function destroy($orderId)
    {
        DB::beginTransaction();
        try {
            $order = Order::findOrFail($orderId);
            $order->order_items()->delete();
            $order->delete();
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Product Deleted Successfully'
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }
}
