<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Validator;
class StudentController extends Controller
{
    function index($id = null){
        $students = $id ? Student::where('id',$id)->first() : Student::all() ;
        return $students;
    }

    function create(Request $req){
        
        $validator = Validator::make($req->all(),[
            'name' => 'required',
            'mobile_no' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'address' => 'required'
        ]);
        if($validator->fails()){
            return response()->json(['message' => 'data not save' , 'data' => false, 'result' => $req->input() , 'errors' => $validator->errors()],401);
        }else{
            $st = new Student();
            $st->name = $req->name;
            $st->mobile_no = $req->mobile_no;
            $st->email = $req->email;
            $st->gender = $req->gender;
            $st->address = $req->address;
            $st->save();
            return ['message' => "data successfully inserted",'data' => true , 'result' => $st ];
        }

    }

    function destroy($id){
        $st = Student::find($id);
        $st->delete();
        return ['message' => 'data successfully deleted' ,'data' => true , 'result' => $st ];
    }

    function update(Request $req){
        $validator = Validator::make($req->all(),[
            'id' => 'required',
            'name' => 'required',
            'mobile_no' => 'required | min:10 | max:10',
            'email' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ]);
        if($validator->fails()){
            return response()->json([
                'message' => 'data not edit', 'data' => false , 'result' => $req->input() , 'errors' => $validator->errors()
            ],401);
        }else{
            $st = Student::find($req->id);
            $st->name = $req->name;
            $st->mobile_no = $req->mobile_no;
            $st->email = $req->email;
            $st->gender = $req->gender;
            $st->address = $req->address;
            $st->save();
            return ['message' => 'data successfully update',"data" => true , 'result' => $st];
        }
    }
}
