<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SponsorshipType;
use Illuminate\Support\Facades\Validator;
use App\Models\UserRegistration as ModelsUserRegistration;
use Illuminate\Validation\Rule;

class SponserApiController extends Controller
{
    public function getall_sponsership(){
        $data = SponsorshipType::select('id','name')->where('status','active')->orderBy('id','ASC')->get();
        if(count($data)>0){
            return response()->json([
                'status'=> true,
                'message'=> 'Data fetched successfully!',
                'data'=>$data,
            ],200
            );
        }else{
            return response()->json([

                'status'=> false,
                'message'=>'Failed to fetch',
            ],400
            );
        }

    }
    public function store(Request $request){
        $post_data=$request->all();

        // dd('hi');
        try{
            $rule=[
                // 'user_uuid' => ['required','array'],
                // 'user_uuid.*'=>'required',
                // 'event_ids'=>'required',
                // 'accomodation'=>'required',
                // 'terms_condition'=>'required',
                'full_name'=>['required',
                function ($attribute, $value, $fail) {
                    $name_parts = preg_split('/\s+/', trim($value));

                    $full_name_size = sizeof($name_parts);

                    if ($full_name_size < 2) {
                        $fail($attribute . ' is invalid.');
                    }
                },],
                // 'sex.*'=>'required',
                // 'religion.*'=>'required',
                'phone'=>['required','regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                'email'=>['required','email'],
                'country_id'=>'required',
                'city_new_name'=>'required',
                'street'=>'required',
                'zip_code'=>['required','string','regex:/^\d{5}(-\d{4})?$/'],
                // 'visa.*'=>'required',
            ];
            // dd(count($post_data['sex']));
            $validator=Validator::make($post_data,$rule);
            if($validator->fails()){
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validator->errors(),
                    ],
                    404,
                );
            }
        }catch(\Throwable $e){
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to Register',
                    'error'=>$e->getMessage(),
                ],
                500,
            );
        }

    }
}
