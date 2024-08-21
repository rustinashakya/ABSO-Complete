<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\donation_has_donor;
use App\Models\donor;
use App\Models\UserRegistration;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class DonorController extends Controller
{
    protected $khaltiController;

    public function __construct(khaltiController $khaltiController)
    {
        $this->khaltiController = $khaltiController;
    }
    //
/**
 * method to decode jwt_token
 */
    public function decodeToken($token)
    {
        try {
            // Get the token from the request
            // $token = $request->bearerToken();

            // Decode the token and get the payload
            $payload = JWTAuth::setToken($token)->getPayload();

            // Access the user ID from the payload
            $userId = $payload->get('id'); // Assuming 'sub' is the key for user ID in the JWT payload

            // Now $userId contains the user ID
            // return response()->json([
            //     'status'=>true,
            //     'id' => $userId
            // ],200);
            return $userId;
        } catch (\Exception $e) {
            // Handle the exception if the token is invalid or any other issues
            return response()->json([
                'status' => false,
                'error' => 'Invalid token',
            ], 401);
        }
    }

    //
    /**
     * @mehod to add Donor detail
     * @author roshan
     */

    public function donor_registration(Request $request)
    {
        $post_data = $request->all();
        try {
// $token = $request->bearerToken();
        // dd($token); die;
        // Check if the Authorization header is present
        if ($request->hasHeader('Authorization')) {
            // Retrieve the token from the Authorization header
            $token = $request->bearerToken();

            // Now you can check if $token is set and perform actions accordingly
            if ($token) {
                // dd($token);

                $check_token = UserRegistration::where('jwt_token', $token)->first();
                //    dd($check_token);
                if ($check_token != null) {
                    // dd($token);
                    $user_uuid = $this->decodeToken($token);
                    // dd($user_uuid);

                    $rule = [
                        'terms_condition' => 'required',
                        'donation_ids' => ['required', 'array'],
                        'donation_ids.*' => 'required',
                        'amount' => 'required',
                        // 'currency'=>'required',
                        'payment_id' => 'required',
                    ];
                    $validator = Validator::make($post_data, $rule);
                    if ($validator->fails()) {
                        return response()->json(
                            [
                                'status' => false,
                                'message' => $validator->errors(),
                            ],
                            404,
                        );
                    }
                    // dd(count($post_data['sex']));

                    DB::beginTransaction();

                    $check_membership_detail = donor::where('id', $user_uuid)->first();
                    if ($check_membership_detail != null) {
                        return response()->json(
                            [
                                'status' => false,
                                'message' => 'User Already Registered as Donor',
                            ],
                            404,
                        );
                    }
                    // }
                    $donor_data = [
                        'id' => $user_uuid,
                        // 'payment_method'=>$post_data['payment_method'],
                        'payment_id' => $post_data['payment_id'],
                        'currency' => 'NRP',
                        'amount' => $post_data['amount'],
                        'payment_status' => 'unpaid',
                    ];
                    // dd($donor_data);
                    $inserted_donor = donor::create($donor_data);
                    foreach ($post_data['donation_ids'] as $donation_val) {

                        $donation_has_donor_data = [
                            'donor_id' => $user_uuid,
                            'donation_id' => $donation_val,
                        ];
                        $inserted_donation_has_donor = donation_has_donor::create($donation_has_donor_data);

                    }
                    DB::commit();

                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'User Successfully registered as Donor',
                            'user_id' => $user_uuid,
                        ],
                        200,
                    );
                } else {

                    return response()->json([
                        'status' => false,
                        'message' => 'Unauthorized User',
                    ], 401);
                }
            }

        } else {
            $rule = [
                'terms_condition' => 'required',
                'full_name' => ['required',
                    function ($attribute, $value, $fail) {
                        $name_parts = preg_split('/\s+/', trim($value));

                        $full_name_size = sizeof($name_parts);

                        if ($full_name_size < 2) {
                            $fail($attribute . ' is invalid.');
                        }
                    }],
                'sex' => 'required',
                // 'religion'=>'required',
                'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                'email' => ['required', 'email','unique:usertbl,email'],
                'country_id' => 'required',
                'city_new_name' => 'required',
                'street' => 'required',
                'religion' => 'required',
                'zip_code' => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
                'donation_ids' => ['required', 'array'],
                'donation_ids.*' => 'required',
                'amount' => 'required',
                // 'currency' => 'required',
                'payment_id' => 'required',
                // 'payment_method'=>'required',

                // 'visa'=>'required',
            ];
            $validator = Validator::make($post_data, $rule);
            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validator->errors(),
                    ],
                    404,
                );
            }
            // dd(count($post_data['sex']));

            // dd($check_user_detail);
            DB::beginTransaction();
            $user_uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
            $post_data['user_uuid'] = $user_uuid;
            $user_detail = [
                'id' => $user_uuid,
                'full_name' => $post_data['full_name'],
                'email' => $post_data['email'],
                'sex' => @$post_data['sex'] ? @$post_data['sex'] : null,
                'religion' => @$post_data['religion'] ? @$post_data['religion'] : null,
                'phone' => $post_data['phone'],
                'password' => null,
                'country_id' => $post_data['country_id'],
                'state_id' => $post_data['state_id'],
                'city' => $post_data['city_new_name'],
                'street' => $post_data['street'],
                'zip_code' => $post_data['zip_code'],
                'token' => null,
                'status' => 'pending',
            ];

            $inserted_data = UserRegistration::create($user_detail);

            $donor_data = [
                'id' => $user_uuid,
                'payment_id' => $post_data['payment_id'],
                // 'payment_id'=>null,
                'currency' =>'NRP',
                'amount' => $post_data['amount'],
                'payment_status' => 'unpaid',
            ];
            // dd($donor_data);
            $inserted_donor = donor::create($donor_data);
            foreach ($post_data['donation_ids'] as $donation_val) {

                $donation_has_donor_data = [
                    'donor_id' => $user_uuid,
                    'donation_id' => $donation_val,
                ];
                $inserted_donation_has_donor = donation_has_donor::create($donation_has_donor_data);

            }
            DB::commit();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User Successfully registered as Donor',
                    'user_id' => $user_uuid,
                ],
                200,
            );
        }
        } catch (\Throwable $e) {
            DB::rollback();
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to Register as Donor',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
        
    }

/**
 * @mehod to update Donor detail
 * @author roshan
 */

    public function update_donor_registration(Request $request, $user_uuid)
    {
        $post_data = $request->all();
        try {
        if ($request->hasHeader('Authorization')) {
            // Retrieve the token from the Authorization header
            $token = $request->bearerToken();

            // Now you can check if $token is set and perform actions accordingly
            if ($token) {
                // dd($token);
                $check_token = UserRegistration::where('jwt_token', $token)->first();
                //    dd($check_token);
                $user_uuid = $this->decodeToken($token);
                if ($check_token != null) {
                    $rule = [
                        'terms_condition' => 'required',
                        'donation_ids' => ['required', 'array'],
                        'donation_ids.*' => 'required',
                        'amount' => 'required',
                        // 'currency' => 'required',
                        'payment_id'=>'required',
                        // 'payment_method' => 'required',
        
                        // 'visa'=>'required',
                    ];
                    $validator = Validator::make($post_data, $rule);
                    if ($validator->fails()) {
                        return response()->json(
                            [
                                'status' => false,
                                'message' => $validator->errors(),
                            ],
                            404,
                        );
                    }
                    $donor_data = [
                        // 'id'=>$user_uuid,
                        // 'payment_method' => $post_data['payment_method'],
                        'payment_id' => $post_data['payment_id'],
                        // 'payment_id' => null,
                        'currency' => 'NRP',
                        'amount' => $post_data['amount'],
                        'payment_status' => 'unpaid',
                    ];
                    donor::where('id', $user_uuid)->update($donor_data);
                    $check_donor_detail = donation_has_donor::where('donor_id', $user_uuid)->pluck('id');
                    if(count($check_donor_detail)>0){
        
                        donation_has_donor::whereIn('id',$check_donor_detail)->delete();
                    }
                    // dd($test,$check_donor_detail);
                         
                    foreach ($post_data['donation_ids'] as $donation_val) {
        
                        $donation_has_donor_data = [
                            'donor_id' => $user_uuid,
                            'donation_id' => $donation_val,
                        ];
                        $inserted_donation_has_donor = donation_has_donor::create($donation_has_donor_data);
        
                        
                    }
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'User Successfully registered as Donor',
                            'user_id' => $user_uuid,
                        ],
                        200,
                    );
                }else{

                }
            }
        }else{
            $rule = [
                'terms_condition' => 'required',
                'full_name' => ['required',
                    function ($attribute, $value, $fail) {
                        $name_parts = preg_split('/\s+/', trim($value));

                        $full_name_size = sizeof($name_parts);

                        if ($full_name_size < 2) {
                            $fail($attribute . ' is invalid.');
                        }
                    }],
                'sex' => 'required',
                'religion'=>'required',
                'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                'email' => ['required', 'email'],
                'country_id' => 'required',
                'city_new_name' => 'required',
                'street' => 'required',
                'zip_code' => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
                'donation_ids' => ['required', 'array'],
                'donation_ids.*' => 'required',
                'amount' => 'required',
                // 'currency' => 'required',
                'payment_id'=>'required',
                // 'payment_method' => 'required',

                // 'visa'=>'required',
            ];
            $validator = Validator::make($post_data, $rule);
            if ($validator->fails()) {
                return response()->json(
                    [
                        'status' => false,
                        'message' => $validator->errors(),
                    ],
                    404,
                );
            }
            // dd(count($post_data['sex']));

            // $check_user_detail=UserRegistration::where('email',$post_data['email'])->first();
            // dd($check_user_detail);
            // DB::beginTransaction();

            // $user_uuid=\Ramsey\Uuid\Uuid::uuid4()->toString();
            // $post_data['user_uuid']=$user_uuid;
            $user_detail = [
                // 'id'=> $user_uuid,
                'full_name' => $post_data['full_name'],
                'email' => $post_data['email'],
                'sex' => @$post_data['sex'] ? @$post_data['sex'] : null,
                'religion' => @$post_data['religion'] ? @$post_data['religion'] : null,
                'phone' => $post_data['phone'],
                'password' => null,
                'country_id' => $post_data['country_id'],
                'state_id' => $post_data['state_id'],
                'city' => $post_data['city_new_name'],
                'street' => $post_data['street'],
                'zip_code' => $post_data['zip_code'],
                'token' => null,
                'status' => 'pending',
            ];

            UserRegistration::where('id', $user_uuid)->update($user_detail);

            $donor_data = [
                // 'id'=>$user_uuid,
                // 'payment_method' => $post_data['payment_method'],
                'payment_id' => $post_data['payment_id'],
                // 'payment_id' => null,
                'currency' => 'NRP',
                'amount' => $post_data['amount'],
                'payment_status' => 'unpaid',
            ];
            donor::where('id', $user_uuid)->update($donor_data);
            $check_donor_detail = donation_has_donor::where('donor_id', $user_uuid)->pluck('id');
            if(count($check_donor_detail)>0){

                donation_has_donor::whereIn('id',$check_donor_detail)->delete();
            }
            // dd($test,$check_donor_detail);
                 
            foreach ($post_data['donation_ids'] as $donation_val) {

                $donation_has_donor_data = [
                    'donor_id' => $user_uuid,
                    'donation_id' => $donation_val,
                ];
                $inserted_donation_has_donor = donation_has_donor::create($donation_has_donor_data);

            }
            // DB::commit();

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User Successfully registered as Donor',
                    'user_id' => $user_uuid,
                ],
                200,
            );
        }
    } catch (\Throwable $e) {
        // DB::rollback();
        return response()->json(
            [
                'status' => false,
                'message' => 'Failed to Register as Donor',
                'error' => $e->getMessage(),
            ],
            500,
        );
    }

    }

    public function donor_detail(Request $request, $user_id)
    {

        if ($user_id) {
            $donor_detail = donor::select('usertbl.id', 'usertbl.full_name', 'usertbl.email', 'usertbl.sex','usertbl.religion', 'usertbl.phone', 'usertbl.country_id', 'countries.name as country_name', 'states.name as state_name', 'usertbl.state_id', 'usertbl.city as city_new_name', 'usertbl.street', 'usertbl.zip_code', 'donor.payment_id', 'donor.currency', 'donor.amount', 'donor.payment_status','payment_option.payment_method','payment_option.icon_url as payment_icon_url')
                ->where('donor.id', $user_id)
                ->join('usertbl', 'usertbl.id', '=', 'donor.id')
                ->join('payment_option','payment_option.id','=','donor.payment_id','left')
                ->join('countries', 'countries.id', '=', 'usertbl.country_id', 'left')
                ->join('states', 'states.id', '=', 'usertbl.state_id', 'left')
                ->first();

            // dd($donor_detail);
            if ($donor_detail != null) {
                // foreach($membership_detail as $key => $value){
                $donor_detail['donation'] = Donation::select('donation.id', 'donation.name')
                    ->join('donation_has_donor', 'donation_has_donor.donation_id', '=', 'donation.id')
                    ->where('donation_has_donor.donor_id', $donor_detail['id'])->get();
                // }
                return response()->json([
                    'status' => true,
                    'message' => 'Donor fetched Successfully',
                    'donor_detail' => $donor_detail,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Donor not found!',
                ], 500);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'user_id is not found!',
            ], 500);
        }
    }

    /**
     * @method to send email to the user after registration
     * @author roshan
     *
     */
    public function send_email_to_donor_member($user_id)
    {
        //    $token=str_random(60);

        $user_detail = donor::select('usertbl.id', 'usertbl.full_name', 'usertbl.email', 'usertbl.sex','usertbl.religion', 'usertbl.phone', 'usertbl.country_id', 'countries.name as country_name', 'states.name as state_name', 'usertbl.state_id', 'usertbl.city as city_new_name', 'usertbl.street', 'usertbl.zip_code', 'donor.payment_id', 'donor.currency', 'donor.amount', 'donor.payment_status','payment_option.payment_method','payment_option.icon_url as payment_icon_url')
            ->where('donor.id', $user_id)
            ->join('usertbl', 'usertbl.id', '=', 'donor.id')
            ->join('payment_option','payment_option.id','=','donor.payment_id','left')
        // ->join('membership_duration','membership_duration.id','=','membership.membership_duration_id')
            ->join('countries', 'countries.id', '=', 'usertbl.country_id', 'left')
            ->join('states', 'states.id', '=', 'usertbl.state_id', 'left')
            ->first();
        if ($user_detail != null) {
            // dd($user_detail);
            // $member_detail=MembershipModel::where('')

            //    $token=Str::random(60);
            // $token=$this->generate_token();

            $subject = '[Dharma Ideal Campaign] Donor Registration';
            $donation = Donation::select('donation.id', 'donation.name')
                ->join('donation_has_donor', 'donation_has_donor.donation_id', '=', 'donation.id')
                ->where('donation_has_donor.donor_id', $user_detail['id'])
                ->get();

            $maildata = [
                'name' => $user_detail['full_name'],
                'phone' => $user_detail['phone'],
                'email' => $user_detail['email'],
                'sex' => @$user_detail['sex'],
                'religion' => $user_detail['religion'],
                // 'membership_duration' => $user_detail['duration'],
                'country' => $user_detail['country_name'],
                'state' => $user_detail['state_name'],
                'city' => $user_detail['city_new_name'],
                'street' => $user_detail['street'],
                'zip_code' => $user_detail['zip_code'],
                'occupation' => @$user_detail['occupation'],
                'qualification' => @$user_detail['qualification'],
                'subject' => $subject,
                'to' => $user_detail['email'],
                'amount'=>$user_detail['amount'],
                'currency'=>$user_detail['currency'],
                'payment_method'=>$user_detail['payment_method'],
                'payment_icon_url'=>$user_detail['payment_icon_url'],
                'payment_status'=>$user_detail['payment_status'],
                'form_type' => 'donor',
                'currency' => $user_detail['currency'],
                'donation' => $donation,
                // 'token'=>'https://dharmaideal.org?token='.$token
                // 'from'=>,
            ];
            // dd($maildata);
            $mail_send = Mail::send('email.user-registration-mail', $maildata, function ($message) use ($maildata) {
                $mail_sender = config('app.mail_username');
                $message->from($mail_sender, 'Dharma Ideal Campaign');
                $message->to($maildata['to']);
                $message->subject($maildata['subject']);
            });

            if ($mail_send) {
                Log::info('email sent to ' . $maildata['to']);
                return response()->json([
                    'status' => true,
                    'message' => 'Email send Successfully to ' . $maildata['to'],
                ], 200);
            }
            // return view('email.activate-user-account-mail',['maildata'=>$maildata]);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'user is already active',
            ], 200);
        }
    }


    /**
     * 
     * @method redirect to payment page
     */

     public function redirect_payment_page($user_id){
        $user_detail= UserRegistration::select('usertbl.id','usertbl.full_name','usertbl.email','usertbl.phone','donor.amount','donor.payment_id')
                                        ->join('donor','donor.id','=','usertbl.id')
                                        ->where('donor.id',$user_id)
                                        ->first();
        // dd($user_detail);

        if($user_detail['payment_id']=='1'){ //khalti
        // dd($user_detail);

            $phoneNumber = str_replace(['977', '+977'], '', $user_detail['phone']);
            $amount=$user_detail['amount']*100;
            $url=$this->khaltiController->initiate($amount,$user_id,'Dharma Ideal Donor',$user_detail['email'],$phoneNumber,$user_detail['full_name']);
                $obj=json_decode($url, true);
                $pidx=@$obj['pidx'];
                $payment_url=@$obj['payment_url'];
                if($pidx == '' || $payment_url== ''){
                    $dharma_web_url=env('dharma_web_url');
                    // $customer_info=
                    // header('Location:'.$payment_url);
                    return response()->json([
                        'status'=>false,
                        'message'=>'Phone number should be either a valid mobile number (e.g. 98xxxxxxxx) or a valid landline number with district code (e.g. 014484xxx)',
                        // 'message'=>'Failed',
                        'url'=>$dharma_web_url.'edit_donation?user_id='.$user_id,
                        // 'url'=>'https://dharmaideal.org/edit_donation?user_id='.$user_id,
                       
                    ],404);
                    // $this->session->set_tempdata('error', 'Failed to redirecting to payment page because Khalti doesnot support International mobile number.', 2);
                    // redirect(base_url('update-registration/'.$show_header.'/'.$id ));
                    // exit;
                }else{
                    $update_khalti_detail=[
                        'pidx'=>$pidx,
                    ];
                    donor::where('id',$user_id)->update($update_khalti_detail);
                    // $this->User_model->update_user_pidx($pidx,$id); 
                    // $khalti_id=$this->User_model->insert_khalti_payment($pidx,$price,$id);
                    return response()->json([
                        'status'=>true,
                        'message'=>'Payment Url fetch successfully',
                        'pidx'=>$pidx,
                        'url'=>$payment_url
                    ],200);
                    // header('Location:'.$payment_url);
                }
            
        // }
         
        }
      
    }

    /**
     * @method call back function of khalti
     */

     public function donation_khalti_callback(Request $request){
        // dd($request);
        $dharma_web_url=env('dharma_web_url');
        // $this->session->unset_userdata('powersummit_pid');
        $pidx=$request->get('pidx');
        // $test=$this->khaltiController->lookup($pidx);
        // dd($test);
        $user_id= $request->get('purchase_order_id');
        $txnId=$request->get('txnId');
        $mobile=$request->get('mobile');
        $transaction_id=$this->get('transaction_id');
        // echo $participant_id.'<br>'.$pidx; die();
        // $payment_status= $this->input->get('')
        
        // $result= $this->User_model->check_pidx($pidx,$participant_id);
        $result= donor::where('id',$user_id)->where('pidx',$pidx)->first();

        // print_r($result); die;
        // echo $amount; die();
        if($result!=null){
            $amount = $result['amount'];
            // $test=$this->input->get_post('pidx');
            // print_r($test); die();
            $url=$this->khaltiController->lookup($pidx);
            // $url=lookup($pidx);
            $obj=json_decode($url);
            $status=$obj->{'status'};
            $khalti_amount=$obj->{'total_amount'};
            if($status == 'Completed'){
                // echo $status;
                // $this->session->unset_userdata('email');
                if(empty($transaction_id) || $transaction_id == null){
                    $transaction_id = $obj->{'transaction_id'};
                }
                $update_khalti_detail=[
                    'transaction_id'=>$transaction_id,
                    'paymebt_status'=>'paid',

                ];
                donor::where('id',$user_id)->update($update_khalti_detail);
               
                // header('Location:https://dharmaideal.org/donation-confirmation?payment_status=success&&user_id='.$user_id);
                header('Location:'.$dharma_web_url.'donation-confirmation?payment_status=success&&user_id='.$user_id);
            

        }
    }else{
        header('Location:'.$dharma_web_url.'edit-donation?payment_status=failed&user_id='.$user_id);
        // header('Location:https://dharmaideal.org/donation-confirmation?payment_status=failed&user_id='.$user_id);
        
    }
     }
}
