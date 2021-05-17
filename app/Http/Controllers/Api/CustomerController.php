<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function index()
    {
        return Customer::where('shop_id', auth('user-api')->user()->shop_id)->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customers')->where(function($query){
                    $query->where('shop_id',auth('user-api')->user()->shop_id);
                })
            ],
            'phone_number' => 'numeric|nullable',
            'previous_due' => 'numeric|nullable',
            'description' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()],422);
        }
        DB::beginTransaction();

        try {
            $customer = Customer::create([
                'shop_id' => $request->user()->shop->id,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'image' => $request->image,
                'previous_due' => $request->previous_due,
                'description' => $request->description,
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return response()->json(['success' => true, 'message' => 'Customer created successfully.',],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $customer = Customer::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if (!$customer){
            return response()->json(['success' => false, 'message' => 'No customer found.']);
        }
        return response()->json(['success' => true, 'customer_info' => $customer,]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('customers')->ignore($id,'id')->where(function($query){
                    $query->where('shop_id',auth('user-api')->user()->shop_id);
                })
            ],
            'phone_number' => 'numeric|nullable',
            'description' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], 422);
        }
        $customer = Customer::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($customer){
            $customer->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'description' => $request->description,
            ]);
            return response()->json(['success' => true, 'message' => "Customer Updated successfully.",]);
        }
        return response()->json(['success' => false, 'message' => 'No customer found.',]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $customer = Customer::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($customer){
            $customer->delete();
            return response()->json(['success' => true, 'message' => 'Customer deleted successfully.',]);
        }
        return response()->json(['success' => false, 'message' => 'No customer found.',]);
    }
}
