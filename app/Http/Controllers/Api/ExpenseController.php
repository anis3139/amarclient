<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Sale;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Expense::with('category', 'subCategory')->where('shop_id', auth('user-api')->user()->shop_id)->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'sub_category_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'notes' => 'max:500',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        DB::beginTransaction();

        try {
            $expense = Expense::create([
                'shop_id' => $request->user()->shop->id,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'amount' => $request->amount,
                'notes' => $request->notes,
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return response()->json([
            'success' => true,
            'message' => 'New Expense created successfully.',
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
        $expense = Expense::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if (!$expense){
            return response()->json(['success' => false, 'message' => 'No Expense found.']);
        }
        return response()->json(['success' => true, 'expense_info' => $expense]);
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
            'category_id' => 'required|numeric',
            'sub_category_id' => 'required|numeric',
            'amount' => 'required|numeric',
            'notes' => 'max:500',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], 422);
        }
        $expense = Expense::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($expense){
            $expense->update([
                'shop_id' => $request->user()->shop->id,
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'amount' => $request->amount,
                'notes' => $request->notes,
            ]);
            return response()->json(['success' => true, 'message' => "Expense Updated successfully.",]);
        }
        return response()->json(['success' => false, 'message' => 'No Expense found.',]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::where('shop_id', auth('user-api')->user()->shop_id)->find($id);
        if ($expense){
            $expense->delete();
            return response()->json(['success' => true, 'message' => 'Expense deleted successfully.',]);
        }
        return response()->json(['success' => false, 'message' => 'No Expense found.',]);
    }

    public function getCategories(){
        return Category::all();
    }
    public function getSubCategories($category_id){
        return SubCategory::where('category_id',$category_id)->get();
    }
}
