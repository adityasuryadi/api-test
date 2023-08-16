<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{
    public function create($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'itemName'      => 'required',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $checklist = Item::create(['name'=>$request->itemName,'cheklist_id'=>$id]);
            if($checklist) {
                return response()->json(['response_code'=>200,'response_status'=>"OK",'data'=>[]], 200);
            }

            return response()->json(['response_code'=>409,'response_status'=>"CONFLICT",'data'=>[]], 409);
        } catch (\Throwable $th) {
            return response()->json(['response_code'=>500,'response_status'=>"INTERNAL SERVER ERROR",'data'=>$th->getMessage()], 500);
        }
    }
}
