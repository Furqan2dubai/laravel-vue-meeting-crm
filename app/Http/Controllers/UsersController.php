<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\User;

class UsersController extends Controller
{

    private $tablename = "users";
    private $title = "User";

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
        $query = DB::table($this->tablename)->where(['id'=>$id])->get();
        if(count($query)>0){ $query[0]->password = ""; }
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
        
        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required|email' 
            ] ); 

        if($validator->failed()){
            $response = [
                'success'=> false,
                'message'=> $validator->error()
            ];
            return response()->json($response, 400);
        }
       
        $input = $request->all();
        $input['password'] = bcrypt($input['password']); 
        $input['role'] = "Admin";
        $user = User::create($input);
        $input['created_at'] = date('Y-m-d H:i:s');
        $input['updated_at'] = date('Y-m-d H:i:s');
         
        // $query = DB::table($this->tablename)->insert($input); 

        $response = [
            // 'token'   => $user->createToken('MyApp')->plainTextToken,
            'success' => $user, 
            'message' => "$this->title added Successfully"
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name'=> 'required',
            'email'=> 'required|email' 
            ] ); 

        if($validator->failed()){
            $response = [
                'success'=> false,
                'message'=> $validator->error()
            ];
            return response()->json($response, 400);
        }
        
        $input = $request->all();
        if(!empty($input['password'])){ 
            $input['password'] = bcrypt($input['password']);
         }
         else{
            unset($input['password']);
         }
        // $id = $request->input('id'); 
        $input['updated_at'] = date('Y-m-d H:i:s');
        
        $query = DB::table($this->tablename)->where(['id'=>$id])->update($input); 

        $response = [
            'success' => $query, 
            'message' => "$this->title Updated Successfully"
        ];

        return response()->json($response, 200); 
    }
}
