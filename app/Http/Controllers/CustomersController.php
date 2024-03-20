<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class CustomersController extends Controller
{

    private $tablename = "customers";
    private $title = "Customer";

    public function list($page = 0){
        $page = $page - 1;
        $offset = $page * 25; 
        $query = DB::table($this->tablename)->orderBy('id', 'desc')->offset($offset)->limit(25)->get();
        $response = [
            'success' => true,
            'data' => $query,
            'page' => $page,
            'loadmore'=> true
        ];
        if($page==0){ 
            $response['total'] =  DB::table($this->tablename)->count() - 25;
        }

        return response()->json($response, 200);
    }

    public function get($id){
        
        $query = DB::table($this->tablename)->where(['id'=>$id])->first();
        $response = [
            'success' => true,
            'data' => $query
        ]; 

        return response()->json($response, 200);
    }

    public function delete($id){
        
        $query = DB::table($this->tablename)->where(['id'=>$id])->delete();
        $response = [
            'success' => true,
            'message' => "$this->title Delete Successfully"
        ];

        return response()->json($response, 200);
    }

    public function add(Request $request){
        $input = $request->all();
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');
        
        // print_r($input);die;
        $query = DB::table($this->tablename)->insert($input); 
        
        $response = [
            'success' => $query, 
            'message' => "$this->title added Successfully"
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id){ 
        
        $input = $request->all();
        // $id = $request->input('id');
        $input['updated_at'] = date('Y-m-d H:i:s');
        
        $query = DB::table($this->tablename)->where(['id'=>$id])->update($input); 

        $response = [
            'success' => $query, 
            'message' => "$this->title Updated Successfully"
        ];

        return response()->json($response, 200); 
    }

    public function logs($id){
        $query = DB::table("customers_transaction_log")->where(['customer_id'=>$id])->limit(10)->get(); 
        $response = [
            'success' => true,
            'data' => $query
        ]; 

        return response()->json($response, 200);
    }
}
