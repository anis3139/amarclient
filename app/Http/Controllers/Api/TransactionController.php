<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Models\Customer;
use App\Models\Expense;
use App\Models\Supplier;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $transactions = Transaction::where('shop_id', auth('user-api')->user()->shop_id)->get();
        return \response()->json([
            'success' => true,
            'data' => TransactionResource::collection($transactions),
        ]);
    }

    public function store(Request $request)
    {
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'type' => ['string',Rule::in(['customer','supplier'])],
            'id' => 'integer',
            'given' => 'nullable|numeric|required_without:taken',
            'taken' => 'nullable|numeric|required_without:given',
            'date' => '',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $transaction = Transaction::create([
            'shop_id' => $request->user()->shop->id,
            'transaction_type' => $request->type == 'customer' ? Customer::class : Supplier::class,
            'transaction_id' => $request->id,
            'given' => $request->given,
            'taken' => $request->taken,
            'date' => $request->date,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'New Transaction created successfully.',
        ],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = Transaction::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if (!$transaction){
            return response()->json(['success' => false, 'message' => 'No Transaction found.']);
        }
        return response()->json(['success' => true, 'transaction_info' => $transaction]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'given' => 'numeric|required_without:taken',
            'taken' => 'numeric|required_without:given',
            'date' => '',
            'description' => 'max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], 422);
        }
        $transaction = Transaction::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($transaction){
            $transaction->update([
                'given' => $request->given,
                'taken' => $request->taken,
                'date' => $request->date,
            ]);
            return response()->json(['success' => true, 'message' => "Transaction Updated successfully.",]);
        }
        return response()->json(['success' => false, 'message' => 'No Transaction found.',]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = Transaction::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($transaction){
            $transaction->delete();
            return response()->json(['success' => true, 'message' => 'Transaction deleted successfully.',]);
        }
        return response()->json(['success' => false, 'message' => 'No Transaction found.',]);
    }
}
