<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rule;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data=[];
        $data['sale'] =Sale::with('product', 'client')->where('shop_id', auth('user-api')->user()->shop_id)->get();
        $data['product'] =Product::where('shop_id', auth('user-api')->user()->shop_id)->get();
        $data['client'] =Client::where('shop_id', auth('user-api')->user()->shop_id)->get();
        return $data;
    }

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'client_id' => 'required|numeric',
            'address' => 'required',
            'amount' => 'required|numeric',
            'advance_payment' => 'required|numeric',
            'next_payment' => 'required|numeric',
            'notes' => 'max:500',
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sales')->where(function($query){
                    $query->where('shop_id',auth('user-api')->user()->shop_id);
                })
            ],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        DB::beginTransaction();

        try {

            $sale = Sale::create([
                'shop_id' => $request->user()->shop->id,
                'product_id' => $request->product_id,
                'client_id' => $request->client_id,
                'address' => $request->address,
                'sku' => $request->sku,
                'amount' => $request->amount,
                'advance_payment' => $request->advance_payment,
                'notes' => $request->notes,
                'due_payment' => $request->due_payment,
                'websites' => $request->websites,
                'next_payment_date' => $request->next_payment_date,
                'next_payment' => $request->next_payment,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            return $e;
            // something went wrong
            return response()->json(['success' => false, 'message' => 'Something went wrong.',]);
        }

        return response()->json(['success' => true, 'message' => 'New Sale created successfully.',],Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $sale = Sale::with('invoiceLog', 'product', 'client')->where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if (!$sale){
            return response()->json(['success' => false, 'message' => 'No sale found.']);
        }
        return response()->json(['success' => true, 'sale_info' => $sale,]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'address' => 'required',
            'amount' => 'required|numeric',
            'client_id' => 'required|numeric',
            'sku' => '',
            'notes' => 'max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], 422);
        }
        $sale = Sale::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($sale){
            $sale->update([
                'shop_id' => $request->user()->shop->id,
                'product_id' => $request->product_id,
                'client_id' => $request->client_id,
                'address' => $request->address,
                'sku' => $request->sku,
                'amount' => $request->amount,
                'advance_payment' => $request->advance_payment,
                'notes' => $request->notes,
                'due_payment' => $request->due_payment,
                'websites' => $request->websites,
                'next_payment_date' => $request->next_payment_date,
                'next_payment' => $request->next_payment,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);
            return response()->json(['success' => true, 'message' => "Sale Updated successfully.",]);
        }
        return response()->json(['success' => false, 'message' => 'No Sale found.',]);
    }

    public function destroy($id)
    {
        $sale = Sale::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($sale){
            $sale->delete();
            return response()->json(['success' => true, 'message' => 'Sale deleted successfully.',]);
        }
        return response()->json(['success' => false, 'message' => 'No Sale found.',]);
    }
}
