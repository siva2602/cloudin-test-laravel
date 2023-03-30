<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerRequest;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('customer')->where('type', 3)->get();
            $response = ['customer' => $users];
            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public function storeAddress(CustomerRequest $request, $userId)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($userId);
            $user->customer()->insert($this->basicDetails($request->all()));
            $response = ['customer' => $user];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public function show($userId)
    {
        try {
            $user = User::with('customer')->findOrFail($userId);
            $response = ['customer' => $user];
            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public function updateAddress(CustomerRequest $request, $userId)
    {
        DB::beginTransaction();
        try {
            $user = User::findOrFail($userId);
            $user->customer()->update($this->basicDetails($request->all()));
            $response = ['customer' => $user];
            DB::commit();

            return response($response, 200);
        } catch (\Exception $exception) {
            error_log($exception->getMessage());
        }
    }

    public static function basicDetails($request): array
    {
        return [
            'address1' => $request['address1'],
            'address2' => $request['address2'],
            'landmark' => $request['landmark'],
            'city' => $request['city'],
            'state' => $request['state'],
            'zipcode' => $request['zipcode']
        ];
    }
}
