<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MembershipModel;
use App\Models\User;
use App\Models\UserRegistration as ModelsUserRegistration;
use App\Rules\UniqueEmailsIgnoringCurrentRecords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class UserRegistration extends Controller
{
    //
/**
 * @method to post user data in user table and post event registration detail
 * @author roshan
 */
public function event_registration(Request $request){
    $post_data=$request->all();
    try{
        $rule=[
            'event_ids.*'=>'required',
            'accomodation'=>'required',
            'terms_condition'=>'required',
            'full_name.*'=>['required',
            function ($attribute, $value, $fail) {
                $name_parts = preg_split('/\s+/', trim($value));

                $full_name_size = sizeof($name_parts);

                if ($full_name_size < 2) {
                    $fail($attribute . ' is invalid.');
                }
            },],
            'sex.*'=>'required',
            'religion.*'=>'required',
            'phone.*'=>['required','regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
            'email'=>[
                function ($attribute, $value, $fail) {
                // Remove duplicate values from the array
                $uniqueValues = array_unique($value);

                // Check if the original array size is the same as the unique array size
                if (count($value) !== count($uniqueValues)) {
                    $fail($attribute. ' contains duplicate values.');
                }
            }],
            'email.*'=>['required','email'],
            'country_id.*'=>'required',
            'city_new_name.*'=>'required',
            'street.*'=>'required',
            'zip_code.*'=>['required','string','regex:/^\d{5}(-\d{4})?$/'],
            'visa.*'=>'required',
        ];
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
        // dd(count($post_data['sex']));
        for($i=0; $i<count($post_data['sex']); $i++){
            $check_user_detail[$i]=ModelsUserRegistration::where('email',$post_data['email'][$i])->first();
            // dd($check_user_detail[$i]);
            // if($check_user_detail[$i])
            
            if($check_user_detail[$i]==null){
                $user_uuid[$i]=\Ramsey\Uuid\Uuid::uuid4()->toString();
                $post_data['user_uuid'][$i]=$user_uuid[$i];
                $user_detail[$i]=[
                    'id'=> $user_uuid[$i],
                    'full_name'=>$post_data['full_name'][$i],
                    'email'=>$post_data['email'][$i],
                    'religion'=>$post_data['religion'][$i],
                    'sex'=>$post_data['sex'][$i],
                    'phone'=>$post_data['phone'][$i],
                    'password'=>null,
                    'country_id'=>$post_data['country_id'][$i],
                    'state_id'=>$post_data['state_id'][$i],
                    'city'=>$post_data['city_new_name'][$i],
                    'street'=>$post_data['street'][$i],
                    'zip_code'=>$post_data['zip_code'][$i],
                    'token'=>null,
                    'status'=>'pending'
                ];
    
                $inserted_data[$i]=ModelsUserRegistration::create($user_detail[$i]);
            }else{
                $check_user_id_in_event_api[$i]=$this->check_event_api($check_user_detail[$i]['id']);
            // dd($check_user_detail[$i]);

            if($check_user_id_in_event_api[$i]==200){
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'User has already been registered as participant using email: '.$post_data['email'][$i],
                        // 'application_id'=>$application_id
                    ],
                    500,
                );
            }
                // $user_uuid[$i]=\Ramsey\Uuid\Uuid::uuid4()->toString();
                $post_data['user_uuid'][$i]=$check_user_detail[$i]['id'];
                $user_detail[$i]=[
                    // 'test'=>'test',
                    // 'id'=> $user_uuid[$i],
                    'full_name'=>$post_data['full_name'][$i],
                    'email'=>$post_data['email'][$i],
                    'sex'=>$post_data['sex'][$i],
                    'religion'=>$post_data['religion'][$i],
                    'phone'=>$post_data['phone'][$i],
                    'password'=>null,
                    'country_id'=>$post_data['country_id'][$i],
                    'state_id'=>$post_data['state_id'][$i],
                    'city'=>$post_data['city_new_name'][$i],
                    'street'=>$post_data['street'][$i],
                    'zip_code'=>$post_data['zip_code'][$i],
                    'token'=>null,
                    'status'=>'pending'
                ];
    
                $updated_data[$i]=ModelsUserRegistration::where('id',$check_user_detail[$i]['id'])->update($user_detail[$i]);
            }
            
            // dd($check_user_id_in_event_api[$i]);
        }
        // dd($check_user_detail);
        // $event_api_url=env('Event_URL');
        $response=$this->event_api_post($post_data);
       
        if($response!==false){
            $result=json_decode($response);
            // dd($response);
            if (property_exists($result, 'status')) {
                $status = $result->status;
                $application_id = $result->application_id;
                if($status===true){
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Participant registered Successfully',
                            'application_id'=>$application_id
                        ],
                        200,
                    );
                }else{
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'Participant failed to Registered',
                        ],
                        200,
                    );
                }
                   
            
              
            } 

        }else{
            return response()->json(
                        [
                            'status' => false,
                            'message' => 'Failed to Register',
                            // 'errormessage'=>$errorMessage
                        ],
                        404,
                    );
                }
            //          return response()->json(
            //     [
            //         'status' => true,
            //         'message' => 'Participant registered Successfully',
            //         'application_id'=>'1',
            //     ],
            //     200,
            // );
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
/**
 * @method to update registration detail
 */
public function update_event_registration(Request $request,$application_id){
    $post_data=$request->all();
    try{
        $rule=[
            'user_uuid' => ['required','array'],
            'user_uuid.*'=>'required',
            'event_ids.*'=>'required',
            'accomodation'=>'required',
            'terms_condition'=>'required',
            'full_name.*'=>['required',
            function ($attribute, $value, $fail) {
                $name_parts = preg_split('/\s+/', trim($value));

                $full_name_size = sizeof($name_parts);

                if ($full_name_size < 2) {
                    $fail($attribute . ' is invalid.');
                }
            },],
            'sex.*'=>'required',
            'religion.*'=>'required',
            'phone.*'=>['required','regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
            'email'=>[
                function ($attribute, $value, $fail) {
                // Remove duplicate values from the array
                $uniqueValues = array_unique($value);

                // Check if the original array size is the same as the unique array size
                if (count($value) !== count($uniqueValues)) {
                    $fail($attribute. ' contains duplicate values.');
                }
            },
            'array',

            // new UniqueEmailsIgnoringCurrentRecords('usertbl', 'user_uuid.*', 'email.*'),
        ],
            // 'email.*'=>['required','email',Rule::unique('usertbl', 'email')->ignore($post_data['user_uuid'])],
            'email.*'=>['required',
                        'email',
                        function ($attribute, $value, $fail) use ($post_data) {
                            $index = str_replace('email.', '', $attribute);
                            $existingEmails = ModelsUserRegistration::select('email')
                            // ->except($index) // Exclude the current email being checked
                            ->where('id','!=', $post_data['user_uuid'][$index])
                            ->pluck('email')
                            ->toArray();
                        // dd($existingEmails,$value);
                        if (in_array($value, $existingEmails)) {
                            $fail($attribute . ' has already been taken for this user.');
                        }
                        },
                    ],
            'country_id.*'=>'required',
            'city_new_name.*'=>'required',
            'street.*'=>'required',
            'zip_code.*'=>['required','string','regex:/^\d{5}(-\d{4})?$/'],
            'visa.*'=>'required',
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
        // dd(count($post_data['sex']));
        for($i=0; $i<count($post_data['sex']); $i++){
            // $user_uuid[$i]=\Ramsey\Uuid\Uuid::uuid4()->toString();
            // $post_data['user_uuid'][$i]=$user_uuid[$i];
            $user_detail[$i]=[
                // 'id'=> $post_data['user_uuid'][$i],
                'full_name'=>$post_data['full_name'][$i],
                'email'=>$post_data['email'][$i],
                'religion'=>$post_data['religion'][$i],
                'sex'=>$post_data['sex'][$i],
                'phone'=>$post_data['phone'][$i],
                'password'=>null,
                'country_id'=>$post_data['country_id'][$i],
                'state_id'=>$post_data['state_id'][$i],
                'city'=>$post_data['city_new_name'][$i],
                'street'=>$post_data['street'][$i],
                'zip_code'=>$post_data['zip_code'][$i],
                'token'=>null,
                'status'=>'pending'
            ];

            $updated_data[$i]=ModelsUserRegistration::where('id',$post_data['user_uuid'][$i])->update($user_detail[$i]);
        }
        // dd($post_data);
        // if($this->update_event_api_post($post_data));
        $response=$this->update_event_api_post($post_data,$application_id);
       
        if($response!==false){
            $result=json_decode($response);
            if (property_exists($result, 'application_id')) {
                $application_id = $result->application_id;
                      return response()->json(
                [
                    'status' => true,
                    'message' => 'Participant Registered Successfully',
                    'application_id'=>$application_id
                ],
                200,
            );
            
              
            } 

        }else{
            return response()->json(
                        [
                            'status' => false,
                            'message' => 'Failed to Register',
                            // 'errormessage'=>$errorMessage
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
public function test_test(){

    $test=ModelsUserRegistration::all();
    dd($test);
}
public function check_email(Request $request){
    try{
        $data=$request->all();
        if(isset($data['email'])){
        $email=ModelsUserRegistration::select('id','full_name','email','sex','phone','country_id','state_id','city','street','zip_code','status')->where('email',$data['email'])->get();
        // dd($email);
        if(count($email)>0){
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Fetch Data Successfully',
                    'email' => $email,
                ],
                200,
            );
        }else{
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Email does not exist',
                ],
                400,
            );
        }
    }{
        return response()->json(
            [
                'status' => false,
                'message' => 'Email not found',
            ],
            400,
        );
    }
        // dd($data['email']);

}catch(\Throwable $e){
    return response()->json(
        [
            'status' => false,
            'message' => 'Failed to check',
            'error'=>$e->getMessage(),
        ],
        500,
    );
}
}
/**
 * @method to generate token
 * @author roshan
 */
public function generate_token(){
    // $str_result = '123456789';
       
    $val = true;
    while ($val) {
        $random_str = Str::random(60);
        // echo $random_str;echo '<br/>';
        $codes = ModelsUserRegistration::where('token',$random_str)->first();
        // dd($codes);
        if ($codes==null) {
            $val = false;
        }

        $val;
    }

    return $random_str;
}
/**
 * @method to send email to activate the user account
 * @author roshan
 * 
 */
public function send_email_to_activate_user($user_id){
//    $token=str_random(60);
$user_detail=ModelsUserRegistration::where('id',$user_id)->where('status','pending')->first();
if($user_detail!=null){

    //    $token=Str::random(60);
    $token=$this->generate_token();

       $subject='[Dharma Ideal Campaign] Account Activation';
    

    
    
    $maildata=[
        'name'=>$user_detail['full_name'],
        'subject'=>$subject,
        'to'=>$user_detail['email'],
        // 'message'=>$message,
        'token'=>url('reset_password/'.$token.'/'.$user_detail['email']),
        // 'from'=>,
    ];
    $mail_send = Mail::send('email.activate-user-account-mail',$maildata,function ($message) use ($maildata){
        $mail_sender = config('app.mail_username');
        $message->from($mail_sender,'Dharma Ideal Campaign');
        $message->to($maildata['to']);
        $message->subject($maildata['subject']);
    });

    if($mail_send) {
        Log::info('email sent to '.$maildata['to']);
        ModelsUserRegistration::where('id',$user_id)->update(['token'=>$token]);
        return response()->json([
            'status'=> true,
            'message'=> 'Email send Successfully to '.$maildata['to'],
        ],200);
    }
    // return view('email.activate-user-account-mail',['maildata'=>$maildata]);
}else{
    return response()->json([
        'status'=> true,
        'message'=> 'user is already active'
    ],200);
}
}


public function event_api_post($postData){
        // API Endpoint URL
        $event_api_url=env('Event_URL');
        $apiUrl = $event_api_url;

        // Data to be sent in the POST request
        // $postData = array(
        //     'key1' => 'value1',
        //     'key2' => 'value2',
        //     // Add other data as needed
        // );

        // Initialize cURL session
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $apiUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // Execute cURL session
        $response = curl_exec($ch);

        // Check for cURL errors
        if (curl_errno($ch)) {
            // Handle the error here
            echo 'cURL error: ' . curl_error($ch);
        }

        // Close cURL session
        curl_close($ch);

        // Process the API response
        if ($response !== false) {
            // Decode JSON response if applicable
            $responseData = json_decode($response, true);
            
            // Process the response data as needed
            // var_dump($responseData);
            return $response;
        } else {
            // Handle the case where there was an issue with the request
            // echo 'Error sending request.';
            return false;
        }
    
}


public function update_event_api_post($postData,$application_id){
    // API Endpoint URL
    $event_api_url=env('Event_update_URL');
    $apiUrl = $event_api_url.'/'.$application_id;

    // Data to be sent in the POST request
    // $postData = array(
    //     'key1' => 'value1',
    //     'key2' => 'value2',
    //     // Add other data as needed
    // );

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        // Handle the error here
        echo 'cURL error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Process the API response
    if ($response !== false) {
        // Decode JSON response if applicable
        $responseData = json_decode($response, true);
        
        // Process the response data as needed
        // var_dump($responseData);
        return $response;
    } else {
        // Handle the case where there was an issue with the request
        // echo 'Error sending request.';
        return false;
    }

}
public function check_event_api($user_id){
    // API Endpoint URL
    $event_api_url=env('Check_Event_URL').'/'.$user_id;
    $apiUrl = $event_api_url;
    // dd($apiUrl);

// Initialize cURL session
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

// Execute cURL session
$response = curl_exec($ch);

// Check for cURL errors
if (curl_errno($ch)) {
    // Handle the error here
    echo 'cURL error: ' . curl_error($ch);
} else {
    // Process the API response
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
// return $httpCode;
    if ($httpCode == 200) {
        // Decode JSON response if applicable
        $responseData = json_decode($response, true);

        // Process the response data as needed
        // var_dump($responseData);
        return $httpCode;
    } else {
        // Handle non-200 HTTP response codes
        // echo 'HTTP error: ' . $httpCode;
        // $false_responseData=json_decode($response, true);
        return $httpCode;
        // return $user_id;
        
    }
}

// Close cURL session
curl_close($ch);
}
}
