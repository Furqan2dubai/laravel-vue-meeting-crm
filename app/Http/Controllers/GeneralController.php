<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Storage;
 

class GeneralController extends Controller
{

     

    // public function duplicate_entry_check($table, $fieldArray){
        
    //     $query = DB::table($table)->where($fieldArray)->get(); 

    //     return response()->json($query, 200);
    // }
    protected function today_date(){
        return date('Y-m-d');
    }

    public function search_table($table, Request $request){
        $input = $request->all();
        $field = $input['field'];
        $keyword = $input['keyword'];
        
        $query = DB::table($table)->where($field,'like', "%$keyword%");
        if(isset($input['field2'])){
            $field2 = $input['field2'];
            $keyword2 = $input['keyword2'];
            $query = $query->where($field2,'like', "%$keyword2%");
        }
        $query = $query->limit(5)->get(); 
        // $query = DB::table($table)->where($field,'like', "%$keyword")->get(); 
        $response = [
            'success' => true,
            'data' => $query
        ];
        return response()->json($response, 200);
    }

    public function get_info(Request $request){
        $data = 123;
        $input = $request->all();
        $staff_id = $input['staff_id'];
        $date = $input['date'];
        $data = DB::table("staff_daily_logs_view")->where(["staff_id"=>$staff_id, "date"=>$date])->first();

        $response = [
            'success' => true,
            'data' => $data, 
            'loadmore'=> true
        ]; 

        return response()->json($response, 200);
    }

    public function get_data($table, $page = 0, Request $request){
        $page = $page - 1;
        $offset = $page * 25;  

        $input = $request->all();
        
        $field1 = $input['field1'];
        $keyword1 = $input['keyword1']; 
        $date = $input['date'];  
        if($date=="" || $field1==""){
            return false;
        }
        $query = DB::table("$table")->where($field1, $keyword1)->whereDate("created_at", $date); 
        $data = $query->orderBy('created_at', 'desc')->offset($offset)->limit(25)->get();
        
        $response = [
            'success' => true,
            'data' => $data,
            'page' => $page,
            'loadmore'=> true
        ];
        if($page==0){ 
            $response['total'] =  $query->count();
        }

        return response()->json($response, 200);
    }
 
    protected function receivable_add($amount, $customer_id, $company_id, $staff_id){
        DB::table("customers")->where(['id'=>$customer_id])->increment('receivable', $amount); 
        DB::table("staff")->where(['id'=>$staff_id])->increment('receivable', $amount); 
        DB::table("companies")->where(['id'=>$company_id])->increment('receivable', $amount);  
    }

    protected function receivable_minus($amount, $customer_id, $company_id, $staff_id){
        DB::table("customers")->where(['id'=>$customer_id])->increment('receivable', $amount); 
        DB::table("staff")->where(['id'=>$staff_id])->increment('receivable', $amount); 
        DB::table("companies")->where(['id'=>$company_id])->increment('receivable', $amount); 
    }

    protected function payable_add($amount, $customer_id, $company_id, $staff_id){
        DB::table("customers")->where(['id'=>$customer_id])->decrement('payable', $amount); 
        DB::table("staff")->where(['id'=>$staff_id])->decrement('payable', $amount); 
        DB::table("companies")->where(['id'=>$company_id])->decrement('payable', $amount); 
    }

    protected function payable_minus($amount, $customer_id, $company_id, $staff_id){
        DB::table("customers")->where(['id'=>$customer_id])->decrement('payable', $amount); 
        DB::table("staff")->where(['id'=>$staff_id])->decrement('payable', $amount); 
        DB::table("companies")->where(['id'=>$company_id])->decrement('payable', $amount); 
    }

    protected function customer_log_adds($customer_id){
        $today_date = $this->today_date();
        DB::table("customers")->where(['id'=>$customer_id,'Meeting_date'=>$today_date])->get('payable', $amount); 
        DB::table("staff")->where(['id'=>$staff_id])->decrement('payable', $amount); 
        DB::table("companies")->where(['id'=>$company_id])->decrement('payable', $amount); 
    }

    protected function upload_files($request, $data){
        foreach($request->upload_files as $index=>$file){

            $file_title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $file_name = time().'_'.$file->getClientOriginalName();
            $file_type = $file->getClientOriginalExtension();
            $file_path = $request->file('upload_files')[$index]->storeAs($data->parent, $file_name, 'public');
            $fileUpload = new FileUpload;
            $fileUpload->name = time().'_'.$file->getClientOriginalName();
            $fileUpload->path = '/storage/' . $file_path;
            $fileUpload->title = $file_title;
            $fileUpload->type = $file_type;
            $fileUpload->description = $data->description;
            $fileUpload->parent = $data->parent;
            if($data->ref_id){
                $fileUpload->ref_id = $data->ref_id; 
            }
            $fileUpload->ref_no = $data->ref_no;
            $fileUpload->save(); 
            return $fileUpload->path;
        }
    }
     
}
