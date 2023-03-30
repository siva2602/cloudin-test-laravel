<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AddToCart;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AddToCartController extends Controller
{
    public function index()
    {
        try {
            $addToCart = AddToCart::with('product')->where('user_id', Auth::user()->id)->get();
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Cart Retrieve Successfully',
                'data' => [
                    'cart' => $addToCart
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            info($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request = $request->all();
            $cart = AddToCart::create([
                'product_id' => $request['product_id'],
                'quantity' => $request['quantity'],
                'user_id' => Auth::user()->id
            ]);

            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Cart Stored Successfully',
                'data' => [
                    'cart' => AddToCart::with('product')->findOrFail($cart->id)
                ]
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function update(Request $request, $cartId)
    {
        DB::beginTransaction();
        try {
            $request = $request->all();
            $cart = AddToCart::findOrFail($cartId);
            $cart->update(['quantity' => $request['quantity']]);

            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Cart Stored Successfully',
                'data' => [
                    'cart' => AddToCart::with('product')->findOrFail($cart->id)
                ]
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function destroy($cartId)
    {
        DB::beginTransaction();
        try {
            $cart = AddToCart::findOrFail($cartId);
            $cart->delete();

            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Cart Deleted Successfully'
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }
}
