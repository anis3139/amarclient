<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        return Product::where('shop_id', auth('user-api')->user()->shop_id)->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'sku' => 'string|unique:products,sku',
            'price' => 'required|numeric|nullable',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()],422);
        }
        DB::beginTransaction();

        try {
            $customer = Product::create([
                'shop_id' => $request->user()->shop->id,
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return response()->json(['success' => true, 'message' => 'Product created successfully.',],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $customer = Product::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if (!$customer){
            return response()->json(['success' => false, 'message' => 'No product found.']);
        }
        return response()->json(['success' => true, 'product_info' => $customer,]);
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
            'name' => 'required|string|max:255',
            'sku' => 'string|nullable',
            'price' => 'integer|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], 422);
        }
        $customer = Product::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($customer){
            $customer->update([
                'name' => $request->name,
                'sku' => $request->sku,
                'price' => $request->price,
            ]);
            return response()->json(['success' => true, 'message' => "Product Updated successfully.",]);
        }
        return response()->json(['success' => false, 'message' => 'No Product found.',]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $customer = Product::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($customer){
            $customer->delete();
            return response()->json(['success' => true, 'message' => 'Product deleted successfully.',]);
        }
        return response()->json(['success' => false, 'message' => 'No Product found.',]);
    }
}
