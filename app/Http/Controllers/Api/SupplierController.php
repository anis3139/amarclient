<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class SupplierController extends Controller
{
    public function index()
    {
        return Supplier::where('shop_id', auth('user-api')->user()->shop_id)->get();
    }

    public function store(Request $request)
    {
//        return $request->user()->shop->id;
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('suppliers')->where(function($query){
                    $query->where('shop_id',auth('user-api')->user()->shop_id);
                })
            ],
            'phone_number' => 'numeric|nullable',
            'previous_due' => 'numeric|nullable',
            'description' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], 322);
        }
        DB::beginTransaction();

        try {
            $supplier = Supplier::create([
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

        return response()->json(['success' => true, 'message' => 'Supplier created successfully.',],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $supplier = Supplier::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($supplier){
            return response()->json([
                'success' => true,
                'supplier_info' => $supplier,
            ]);
        }
        return response()->json(['success' => false, 'message' => 'No Supplier found.',]);
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
                Rule::unique('suppliers')->ignore($id,'id')->where(function($query){
                    $query->where('shop_id',auth('user-api')->user()->shop_id);
                })
            ],
            'phone_number' => 'numeric|nullable',
            'description' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),],422);
        }
        $supplier = Supplier::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($supplier){
            $supplier->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'description' => $request->description,
            ]);
            return response()->json(['success' => true, 'message' => 'supplier Updated successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No supplier found.',]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $supplier = Supplier::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($supplier){
            $supplier->delete();
            return response()->json(['success' => true, 'message' => 'Supplier deleted successfully.',]);
        }
        return response()->json(['success' => false, 'message' => 'No Supplier found.',]);
    }
}
