<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;

class AdminShopController extends Controller
{
    public function index(){
        return Shop::with('users')->get();
    }
    public function destroy($id){
        $shop = Shop::find($id);
        if ($shop){
            $shop->delete();
            return response()->json(['success' => true, 'message' => 'Shop deleted successfully.']);
        }
        return response()->json(['success' => false, 'message' => 'No shop found.']);
    }
}
