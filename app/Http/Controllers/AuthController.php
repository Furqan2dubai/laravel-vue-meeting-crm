<?php

namespace App\Http\Controllers;
 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;
use App\Models\User;
use DB;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        
        // $validator = Validator::make($request->all(), [
        //     'name'=> 'required',
        //     'email'=> 'required|email',
        //     'password'=>'required' 
        //     ] );
        // $validated = $validator->validated();
        // print_r($validator->validator());die;
        // if($validator->failed()){
        //     $response = [
        //         'success'=> false,
        //         'message'=> $validator->error()
        //     ];
        //     return response()->json($response, 400);
        // }
        // print_r($validator->error());die;
        $input = $request->all();
        $input['password'] = bcrypt($input['password']); 
        // print_r($input);die;
        $user = User::create($input);

        $success['token'] = $user->createToken('MyApp')->plainTextToken;
        $success['user'] = $user;

        $response = [
            'success' => true,
            'data' => $success,
            'message' => 'User Register Successfully'
        ];

        return response()->json($response, 200);
    }

    public function login(request $request){
        if(Auth::attempt(['email'=> $request->email, 'password'=> $request->password])){
            $user = Auth::user();
            $success['token'] = $user->createToken('MyApp')->plainTextToken;
            $success['user'] = $user;
            $success['company'] = $query = DB::table("companies")->where(['id'=>1])->first();

            $response = [
                'success' => true,
                'data' => $success,
                'message' => 'User Login Successfully'
            ];

            return response()->json($response, 200);
        }
        else{
            $response = [
                'success' => false, 
                'message' => 'Unauthorized'
            ];
            return response()->json($response);
        }
    }
}
