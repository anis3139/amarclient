<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{

    public function index()
    {
        return Employee::where('shop_id', auth('user-api')->user()->shop_id)->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()],422);
        }
        DB::beginTransaction();

        try {
            $employee = Employee::create([
                'shop_id' => $request->user()->shop->id,
                'name' => $request->name,
                'employee_type' => $request->employee_type,
                'salary_type' => $request->salary_type,
                'amount' => $request->amount,
                'salary_circle' => $request->salary_circle,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'dob' => $request->dob,
                'job_id' => $request->job_id,
                'job_title' => $request->job_title,
                'holiday' => $request->holiday,
                'from' => $request->from,
                'to' => $request->to,
            ]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

        return response()->json(['success' => true, 'message' => 'Employee created successfully.',],Response::HTTP_CREATED);

    }


    public function show($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
