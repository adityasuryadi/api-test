<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChecklistController extends Controller
{
    public function lists()
    {
        try {

            $checklists = Checklist::all();
            return response()->json(['response_code'=>200,'response_status'=>"OK",'data'=>$checklists], 200);

        } catch (\Throwable $th) {
            return response()->json(['response_code'=>500,'response_status'=>"INTERNAL SERVER ERROR",'data'=>$th->getMessage()], 500);
        }
    }

    public function create(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name'      => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $checklist = Checklist::create($request->all());
            if($checklist) {
                return response()->json(['response_code'=>200,'response_status'=>"OK",'data'=>[]], 200);
            }

            return response()->json(['response_code'=>409,'response_status'=>"CONFLICT",'data'=>[]], 409);
        } catch (\Throwable $th) {
            return response()->json(['response_code'=>500,'response_status'=>"INTERNAL SERVER ERROR",'data'=>$th->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $checklist =  Checklist::find($id);
            if(!$checklist) {
                return response()->json(['response_code'=>404,'response_status'=>"NOT FOUND",'data'=>[]], 404);
            }

            $checklist->delete();
            return response()->json(['response_code'=>200,'response_status'=>"OK",'data'=>[]], 200);
        } catch (\Throwable $th) {
            return response()->json(['response_code'=>500,'response_status'=>"INTERNAL SERVER ERROR",'data'=>$th->getMessage()], 500);
        }
    }
}
