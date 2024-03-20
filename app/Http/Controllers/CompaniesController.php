<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GeneralController;
use Illuminate\Http\Request;
use Validator;
use DB;
 

class CompaniesController extends GeneralController
{

    private $tablename = "companies";
    private $title = "Company";

    public function list(){
        
        $query = DB::table($this->tablename)->orderBy('id', 'desc')->get();
        $response = [
            'success' => true,
            'data' => $query
        ];
         
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
        $query = DB::table($this->tablename)->insert($input); 

        $response = [
            'success' => $query, 
            'message' => "$this->title added Successfully"
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id){
        
        $input = $request->all();  
        $input['updated_at'] = date('Y-m-d H:i:s');
        
        $query = DB::table($this->tablename)->where(['id'=>$id])->update($input); 

        $response = [
            'success' => $query, 
            'message' => "$this->title Updated Successfully"
        ];

        return response()->json($response, 200); 
    }

    public function account_update(Request $request, $id){
        // echo 123;
        // print_r($request->upload_files);die;
        $company_data = (array) json_decode($request->company_data); 

        if($request->upload_files){

            $upload_data =  (object) array(
                "parent" => "companies",
                "description" => "Company Updated Logo",
                "ref_id" => $id, 
                "ref_no" => "_updated_logo" //date('Y-m-D').
            );
            $file_path = $this->upload_files($request, $upload_data); 
            $company_data['logo'] = $file_path;
        }

        if($request->company_data){ 
            $company_data['updated_at'] = date('Y-m-d H:i:s');
            // print_r($company_data);die;

            $query = DB::table($this->tablename)->where(['id'=>$id])->update($company_data); 
    
            $response = [
                'success' => $query, 
                'message' => "$this->title Updated Successfully"
            ];
    
            return response()->json($response, 200); 
        }
    }
}
