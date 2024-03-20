<?php

namespace App\Http\Controllers;

use App\Http\Controllers\GeneralController;
use Illuminate\Http\Request;
use Validator;
use DB;
use Illuminate\Support\Facades\Mail;

class MeetingController extends GeneralController
{

    private $tablename = "meetings";
    private $title = "Meeting";

    public function list($page = 0){
        $page = $page - 1;
        $offset = $page * 25;  
        $query = DB::table($this->tablename);
        $data = $query->orderBy('id', 'desc')->offset($offset)->limit(25)->get();
        $response = [
            'success' => true,
            'data' => $data,
            'page' => $page,
            'loadmore'=> true
        ];
        if($page==0 && $query->count()>25){ 
            $response['total'] =  $query->count() - 25;
        }

        return response()->json($response, 200);
    }

    public function get($id){ 
        
        $meeting = DB::table($this->tablename)->where(['id'=>$id])->get(); 
        $response = [
            'success' => true,
            'data' => $meeting
        ]; 

        return response()->json($response, 200);
    }

    
    public function print($id){
        
        $data['Meeting'] = DB::table($this->tablename)->where(['id'=>$id])->first();
        $data['files'] = DB::table('file_uploads')->where(['parent'=>'meeting', 'ref_id'=>$id])->get();
        $customer_id = $data['Meeting']->customer_id;
        $data['customer'] = DB::table("customers")->select("tel","email","city","state","address")->where(['id'=>$customer_id])->first();;
        $response = [
            'success' => true,
            'data' => $data
        ]; 

        return response()->json($response, 200);
    }
    public function email($id){
        // mail("furqan2dubai@gmail.com","hello","d");
        // Mail::to($request->user())->send(new OrderShipped($order));
        Mail::to("furqan@gmail.com")->send("helloe");
        // Mail::send('errors.503', [], function ($message) { $message->to('abcd@xyz.com')->subject('this works!'); });
        // $data['Meeting'] = DB::table($this->tablename)->where(['id'=>$id])->first();
        // $data['files'] = DB::table('file_uploads')->where(['parent'=>'meeting', 'ref_id'=>$id])->get();
        // $data['items'] = DB::table("Meeting_items")->where(['Meeting_id'=>$id])->get();;
        // $customer_id = $data['Meeting']->customer_id;
        // $data['customer'] = DB::table("customers")->select("tel","email","city","state","address")->where(['id'=>$customer_id])->first();;
        $response = [
            'success' => true 
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
          
        $form_data = json_decode($request->form); 
        $input = $form_data;
        // print_r($input);die;
        $meeting_data =  (array) $input->Meeting; 
        $meeting_data['created_at'] = date('Y-m-d H:i:s');
        $meeting_data['updated_at'] = date('Y-m-d H:i:s'); 
        $meeting_id = DB::table($this->tablename)->insertGetId($meeting_data);  

           

        if($request->upload_files){
            if($meeting_id){

                $upload_data =  (object) array(
                    "parent" => "meeting",
                    "description" => "meeting",
                    "ref_id" => $meeting_id, 
                    "ref_no" => $meeting_data['Meeting_no']
                );
                $this->upload_files($request, $upload_data); 
            }
        } 
         
        $response = [
            'success' => true, 
            'message' => "$this->title added Successfully",
            'Meeting_id' => $meeting_id
        ];

        return response()->json($response, 200);
    }

    public function update(Request $request, $id){
        $input = $request->all();

        $meeting_data = $input['Meeting']; 
        
        $meeting_data['updated_at'] = date('Y-m-d H:i:s');
        $meeting = DB::table($this->tablename)->where(['id'=>$id])->update($meeting_data ); 
  
        
        $response = [
            'success' => true, 
            'message' => "$this->title Updated Successfully"
        ];

        return response()->json($response, 200); 
    }
 
     
 

    
}
