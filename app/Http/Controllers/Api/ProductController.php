<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getAllProducts()
    {
        try {
            $products = Product::all();
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Product Retrieve Successfully',
                'data' => [
                    'products' => $products
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            info($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function store(ProductRequest $request)
    {
        DB::beginTransaction();
        try {
            $product = Product::create(Product::getBasicDetails($request->all()));
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Product Stored Successfully',
                'data' => [
                    'product' => $product
                ]
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function show($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Product Retrieve Successfully',
                'data' => [
                    'product' => $product
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function edit($productId)
    {
        try {
            $product = Product::findOrFail($productId);
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Product Retrieve Successfully',
                'data' => [
                    'product' => $product
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function update(ProductRequest $request, $productId)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($productId);
            $product->update(Product::getBasicDetails($request->all()));
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Product Updated Successfully',
                'data' => [
                    'product' => $product
                ]
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function destroy($productId)
    {
        DB::beginTransaction();
        try {
            $product = Product::findOrFail($productId);
            $product->delete();
            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Product Deleted Successfully'
            ];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }

    public function searchProduct(Request $request)
    {
        try {
            $request = $request->all();
            $products = Product::where('name', 'like', "%{$request['search']}%")
                ->orWhere('code', 'like', "%{$request['search']}%")
                ->get();

            $response = [
                'success' => true,
                'code' => 200,
                'message' => 'Product Search Successfully',
                'data' => [
                    'product' => $products
                ]
            ];

            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
            return response(getServerErrorMessage(), 500);
        }
    }
}


