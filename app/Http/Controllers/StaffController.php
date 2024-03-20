<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

class StaffController extends Controller
{

    private $tablename = "staff";
    private $title = "staff";

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
        
        $data['staff'] = DB::table($this->tablename)->where(['id'=>$id])->first();
        $response = [
            'success' => true,
            'data' => $data
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
        $staff = $input['staff']; 
        
        $staff['created_at'] = date('Y-m-d H:i:s');
        $staff['updated_at'] = date('Y-m-d H:i:s');
        
        $staff_id = DB::table($this->tablename)->insertGetId($staff); 

        

        $response = [
            'success' => true, 
            'message' => "$this->title added Successfully"
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id){
        
        $input = $request->all();
        $staff = $input['staff']; 
        $staff['updated_at'] = date('Y-m-d H:i:s');
        
        $query = DB::table($this->tablename)->where(['id'=>$id])->update($staff); 
         
       
        $response = [
            'success' => $query, 
            'message' => "$this->title Updated Successfully"
        ];

        return response()->json($response, 200); 
    }

    
}
