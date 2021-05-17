<?php

use App\Http\Controllers\Api\Admin\AdminReportController;
use App\Http\Controllers\Api\Admin\AdminShopController;
use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\CategoryController;
use App\Http\Controllers\Api\Admin\SubCategoryController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\NoticeBoardController;
use App\Http\Controllers\Api\MeetingController;
use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\EmiController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\PayeeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchaseController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\SaleController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\Api\TransactionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\InvoiceLogController;
use App\Http\Controllers\Api\User\AuthController as UserAuthController;
use Illuminate\Support\Facades\Route;


Route::get('v1/get-countries', [ClientController::class, 'getAllCountries'])->name('get-countries');
Route::get('v1/get-divisions', [ClientController::class, 'getAllDivisions'])->name('get-divisions');
Route::get('v1/get-districts/{division_id}', [ClientController::class, 'getAllDistricts'])->name('get-districts');
Route::get('v1/get-upazilas/{district_id}', [ClientController::class, 'getAllUpazilas'])->name('get-upazilas');
//admin routes
Route::group(['prefix' => 'v1/admin','as'=>'admin.'],function (){
    Route::post('login',[AdminAuthController::class,'login'])->name('login');

    Route::group(['middleware' => ['auth:admin-api','scope:admin']],function (){
        Route::post('logout',[AdminAuthController::class,'logout'])->name('logout');
        Route::get('admins',[AdminAuthController::class,'getAllAdmins'])->name('get.admins');
        Route::get('my-info',[AdminAuthController::class,'getLoggedUserDetails'])->name('get.myInfo');

        Route::get('report',[AdminReportController::class,'getReport'])->name('get.report');
        Route::apiResource('shop',AdminShopController::class);
        Route::apiResource('category',CategoryController::class);
        Route::apiResource('sub-category',SubCategoryController::class);
    });
});

//user shop routes
Route::group(['prefix' => 'v1/shop','as'=>'shop.'],function (){
    Route::post('register',[UserAuthController::class,'register'])->name('register');
    Route::post('verify',[UserAuthController::class,'verifyEmail'])->name('api.email.verify');
    Route::post('verify/resend',[UserAuthController::class,'codeResend'])->name('api.code.resend');
    Route::post('login',[UserAuthController::class,'login'])->name('login');
    Route::get('my-info',[UserAuthController::class,'getLoggedUserDetails'])->name('get.myInfo');

    Route::group(['middleware' => ['auth:user-api','scope:user']],function (){
        Route::post('logout',[UserAuthController::class,'logout'])->name('logout');

        Route::apiResource('client',ClientController::class);
        Route::apiResource('payee',PayeeController::class);
        Route::apiResource('sale',SaleController::class);
        Route::apiResource('expense',ExpenseController::class);
        Route::apiResource('product',ProductController::class);
        Route::apiResource('employee',EmployeeController::class);
        Route::apiResource('leave',LeaveController::class);
        Route::apiResource('meeting',MeetingController::class);
        Route::apiResource('notice-board',NoticeBoardController::class);
        Route::apiResource('invoice-log',InvoiceLogController::class);
        Route::get('get-categories',[ExpenseController::class,'getCategories']);
        Route::get('get-sub-categories/{categoryId}',[ExpenseController::class,'getSubCategories']);

        Route::get('report',[ReportController::class, 'report']);
        Route::get('report/transaction',[ReportController::class, 'transaction']);
    });
});


