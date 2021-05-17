<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Shop;
use App\Models\Supplier;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function getReport(){
        $total_shops = Shop::count();
        $total_customers = Customer::count();
        $total_suppliers = Supplier::count();

        return response()->json([
            'success' => true,
            'data' => [
                'total_customers' => $total_customers,
                'total_suppliers' => $total_suppliers,
                'total_shops' => $total_shops,
            ]
        ]);
    }
}
