<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request; 
use DB; 
use Validator;
use App\Models\FileUpload;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{

    private $tablename = "file_uploads";
    private $title = "Files";

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

    public function view($id){
        $query = DB::table($this->tablename)->select('path')->where(['id'=>$id])->first(); 
        $response = [
            'success' => true,
            'data' => $query
        ]; 

        return response()->json($response, 200);
    }

    public function delete($id){
        
        $query = DB::table($this->tablename)->where(['id'=>$id]);
        $file = $query->first();
        $name = $file->name;
        $parent = $file->parent;
        $path = "public/$parent/$name"; 
        $status = Storage::delete($path);
        if($status){
            $query->delete();
        }
        $response = [
            'success' => $status,
            'message' => "$this->title Delete Successfully"
        ];

        return response()->json($response, 200);
    }

    public function add(Request $request){
       
       
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
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
        $input = $request->all();
        $data['updated_at'] = date('Y-m-d H:i:s');
        $data['title'] = $input['title'];
        $data['parent'] = $input['parent'];
        $data['ref_no'] = $input['ref_no'];
        $data['description'] = $input['description'];
        // print_r($data);die;
        $query = DB::table($this->tablename)->where(['id'=>$id])->update($data); 

        $response = [
            'success' => $query, 
            'message' => "$this->title Updated Successfully"
        ];

        return response()->json($response, 200); 
    }

    public function upload(Request $request){
            
        // $request->validate([
        //    'upload_files' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
        // ]);   
        if($request->file('upload_files')) {
            foreach($request->upload_files as $index=>$file){

                $file_title = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $file_name = time().'_'.$file->getClientOriginalName();
                $file_type = $file->getClientOriginalExtension();
                $file_path = $request->file('upload_files')[$index]->storeAs($request->parent, $file_name, 'public');
                $fileUpload = new FileUpload;
                $fileUpload->name = time().'_'.$file->getClientOriginalName();
                $fileUpload->path = '/storage/' . $file_path;
                $fileUpload->title = $file_title;
                $fileUpload->type = $file_type;
                $fileUpload->description = $request->description;
                $fileUpload->parent = $request->parent;
                if($fileUpload->ref_id){
                    $fileUpload->ref_id = $request->ref_id;
                }
                $fileUpload->ref_no = $request->ref_no;
                $fileUpload->save();
            }

            $response = [
                'success' => true, 
                'message' => "File uploaded successfully"
            ];
    
            return response()->json($response, 200);  
        }
        return response()->json(['failed'=>'File not upload successfully.']);
   }
}
