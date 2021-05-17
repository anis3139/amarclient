<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return SubCategory::with('category')->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|numeric',
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        DB::beginTransaction();

        try {
            $expense = SubCategory::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return response()->json([
            'success' => true,
            'message' => 'Sub Category created successfully.',
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
        $expense = SubCategory::find($id);
        if (!$expense){
            return response()->json(['success' => false, 'message' => 'No Category found.']);
        }
        return response()->json(['success' => true, 'category_info' => $expense]);
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
            'name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors(),], 422);
        }
        $expense = SubCategory::find($id);
        if ($expense){
            $expense->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
            ]);
            return response()->json(['success' => true, 'message' => "Category Updated successfully.",]);
        }
        return response()->json(['success' => false, 'message' => 'No Category found.',]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = SubCategory::find($id);
        if ($expense){
            $expense->delete();
            return response()->json(['success' => true, 'message' => 'Category deleted successfully.',]);
        }
        return response()->json(['success' => false, 'message' => 'No Category found.',]);
    }
}
