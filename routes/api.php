<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ItemsController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CustomersController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\GeneralController; 
use App\Http\Controllers\RegionsController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\FilesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::controller(AuthController::class)->group(function(){
    Route::post("login","login");
    Route::post("register","register");
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(AuthController::class)->group(function(){
    Route::post("login","login");
    Route::post("register","register");
});

Route::controller(CompaniesController::class)->group(function(){
    Route::get("companies","list"); 
    Route::get("companies/{id}","get"); 
    Route::post("companies","add"); 
    Route::post("companies/{id}","update");  
    Route::delete("companies/{id}","delete"); 
    Route::post("account/{id}","account_update");  
});
Route::controller(UsersController::class)->group(function(){
    Route::get("users/page/{page}","list"); 
    Route::get("users/{id}","get"); 
    Route::post("users","add"); 
    Route::post("users/{id}","update");  
    Route::delete("users/{id}","delete"); 
});
Route::controller(meetingController::class)->group(function(){
    Route::get("meeting/page/{page}","list"); 
    Route::get("meeting/{id}","get"); 
    Route::post("meeting","add"); 
    Route::post("meeting/{id}","update");  
    Route::delete("meeting/{id}","delete");  
    Route::get("meeting/items/{id}","get_items");  
    Route::get("meeting/view/{id}","print"); 
    Route::get("meeting/email/{id}","email"); 
}); 

Route::controller(ItemsController::class)->group(function(){
    Route::get("items/page/{page}","list"); 
    Route::get("items/{id}","get"); 
    Route::post("items","add"); 
    Route::post("items/{id}","update");  
    Route::delete("items/{id}","delete"); 
});
Route::controller(CategoriesController::class)->group(function(){
    Route::get("categories/page/{page}","list"); 
    Route::get("categories/{id}","get"); 
    Route::post("categories","add"); 
    Route::post("categories/{id}","update");  
    Route::delete("categories/{id}","delete"); 
});
Route::controller(RegionsController::class)->group(function(){
    Route::get("regions/page/{page}","list"); 
    Route::get("regions/{id}","get"); 
    Route::post("regions","add"); 
    Route::post("regions/{id}","update");  
    Route::delete("regions/{id}","delete");  
});
Route::controller(FilesController::class)->group(function(){
    Route::get("files/page/{page}","list"); 
    Route::get("files/{id}","get");
    // Route::post("files","add"); 
    Route::post("files/{id}","update");
    Route::delete("files/{id}","delete");
    Route::post('upload', "upload");
});
Route::controller(CustomersController::class)->group(function(){
    Route::get("customers/page/{page}","list"); 
    Route::get("customers/{id}","get"); 
    Route::get("customers/log/{id}","logs");  
    Route::post("customers","add"); 
    Route::post("customers/{id}","update");  
    Route::delete("customers/{id}","delete");  
});
Route::controller(StaffController::class)->group(function(){
    Route::get("staff/page/{page}","list"); 
    Route::get("staff/{id}","get"); 
    Route::get("staff/log/{id}/{date?}","logs");  
    Route::post("staff","add"); 
    Route::post("staff/{id}","update");  
    Route::delete("staff/{id}","delete");  
});
Route::controller(PaymentsController::class)->group(function(){
    Route::get("payments/page/{page}","list"); 
    Route::get("payments/{id}","get"); 
    Route::get("payments/receipt/{id}","receipt"); 
    Route::post("payments","add"); 
    Route::post("payments/{id}","update");  
    Route::delete("payments/{id}","delete");   
});

Route::controller(GeneralController::class)->group(function(){
    Route::post("search/{any}","search_table");   
    Route::post("get_data/{table}/{page}","get_data");   
    Route::post("get_info","get_info");   
});

Route::controller(ReportsController::class)->group(function(){
    Route::get("summary/{type}/{table}/{id}/{start?}/{end?}","summary");  
    Route::get("credit_sheet","credit_sheet");  
    Route::get("load_sheet","load_sheet");  
});

// Route::get('/companies', [CompaniesController::class, 'list']);
