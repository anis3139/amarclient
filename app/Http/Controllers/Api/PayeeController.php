<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PayeeController extends Controller
{
    public function index()
    {
        return Payee::where('shop_id', auth('user-api')->user()->shop_id)->get();
    }

    public function store(Request $request)
    {
//        return $request->all();
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('payees')->where(function($query){
                    $query->where('shop_id',auth('user-api')->user()->shop_id);
                })
            ],
            'email' => 'required|email',
            'phone_number_1' => 'numeric|nullable',
            'phone_number_2' => 'numeric|nullable',
            'notes' => 'nullable|string|max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()],422);
        }
        DB::beginTransaction();

        try {
            $payee = Payee::create([
                'shop_id' => $request->user()->shop->id,
                'name' => $request->name,
                'company' => $request->company,
                'phone_number_1' => $request->phone_number_1,
                'phone_number_2' => $request->phone_number_2,
                'email' => $request->email,
                'notes' => $request->notes,
                'address' => $request->address,
                'website' => $request->website,
                'country_id' => $request->country_id,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'upazila_id' => $request->upazila_id,
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return response()->json(['success' => true, 'message' => 'Payee created successfully.',],Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $payee = Payee::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if (!$payee){
            return response()->json(['success' => false, 'message' => 'No payee found.']);
        }
        return response()->json(['success' => true, 'payee_info' => $payee]);
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
                Rule::unique('payees')->ignore($id,'id')->where(function($query){
                    $query->where('shop_id',auth('user-api')->user()->shop_id);
                })
            ],
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], 422);
        }
        $payee = Payee::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($payee){
            $payee->update([
                'name' => $request->name,
                'company' => $request->company,
                'phone_number_1' => $request->phone_number_1,
                'phone_number_2' => $request->phone_number_2,
                'email' => $request->email,
                'notes' => $request->notes,
                'address' => $request->address,
                'website' => $request->website,
                'country_id' => $request->country_id,
                'division_id' => $request->division_id,
                'district_id' => $request->district_id,
                'upazila_id' => $request->upazila_id,
            ]);
            return response()->json(['success' => true, 'message' => "Payee Updated successfully.",]);
        }
        return response()->json(['success' => false, 'message' => 'No payee found.',]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $payee = Payee::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($payee){
            $payee->delete();
            return response()->json(['success' => true, 'message' => 'Payee deleted successfully.',]);
        }
        return response()->json(['success' => false, 'message' => 'No payee found.',]);
    }
}
