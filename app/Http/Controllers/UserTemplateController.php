<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\UserTemplate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserTemplateController extends Controller
{

    public function index()
    {

    }

    public function create()
    {

    }


    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'username' => 'required|string|max:255',
                'type_id' => 'required|integer',
                'email' => 'required|string|email|max:255|unique:user_templates',
                'phone' => 'required|string|max:20',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'false',
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $data = new UserTemplate();
            $data->username = $request->username;
            $data->type_id = $request->type_id;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->save();

            return response()->json([
                'status' => 'true',
                'message' => 'Details are Stored',
            ]);
        } catch (Exception $e) {
            Log::error("Error occurred: " . $e->getMessage());
        }

    }


    public function show(UserTemplate $userTemplate)
    {
        $show=UserTemplate::pluck('username','email');
        return response()->json($show);
    }


    public function edit(UserTemplate $userTemplate)
    {

    }


    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:user_templates,id',
            'username' => 'required|string|max:255',
            'type_id' => 'required|integer',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('user_templates')->ignore($request->id),
            ],
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'false',
                'message' => $validator->errors()->first(),
            ], 422);
        }
        $result= UserTemplate::find($request->id);
        if($result){

            $result->username = $request->username;
            $result->type_id = $request->type_id;
            $result->email = $request->email;
            $result->phone = $request->phone;
            $result->save();
            return response()->json([
                'status'=>'true',
                'message'=>'Details are edited',
            ]);
        }
    }


    public function destroy(Request $request)
    {
        $delete=UserTemplate::find($request->id);
        if($delete){
            $delete->delete();
            return response()->json([
                'status'=>'true',
                'message'=>'Details are deleted',
            ]);
        }
    }
}
