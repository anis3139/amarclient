<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Models\InvoiceLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class InvoiceLogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return 1;

        return InvoiceLog::where('shop_id', auth('user-api')->user()->shop_id)->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {



    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'paymentAmount' => 'required',
            'sale_id' => 'required|numeric',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }

        $result=new InvoiceLog();
        $result->shop_id=$request->user()->shop->id;
        $result->sale_id=$request->sale_id;
        $result->payment_method=$request->paymentMethod;
        $result->note=$request->internalPaymentNote;
        $result->payment_amount=$request->paymentAmount;
        $result->payment_date=$request->paymentDate;
        $result->save();

        return response()->json([
            'message' => 'Invoice Log successfully Store',
            'result' =>  $result
        ], 201);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoiceLog  $invoiceLog
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceLog $invoiceLog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoiceLog  $invoiceLog
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceLog $invoiceLog)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoiceLog  $invoiceLog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoiceLog $invoiceLog)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoiceLog  $invoiceLog
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceLog $invoiceLog)
    {
        //
    }
}
