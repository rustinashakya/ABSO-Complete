<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MemberShipDuration;
use App\Models\MembershipFamilyMember;
use App\Models\MembershipModel;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class Membership extends Controller
{
    protected $DonorController;

    public function __construct(DonorController $DonorController)
    {
        $this->DonorController = $DonorController;
    }
    //
    /**
     * @mehod to add membership detail
     * @author roshan
     */

    public function membership_registration(Request $request)
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
                    if ($check_token != null) {
                        // dd($token);
                        $user_uuid = $this->DonorController->decodeToken($token);
                        $rule = [
                            'terms_condition' => 'required',
                            'membership_duration_id' => 'required',
                            'occupation' => 'required',
                            'qualification' => 'required',
                            'payment_id' => 'required',

                            // 'family_member'=>['required','array'],
                            'family_member.*.full_name' => ['required',
                                function ($attribute, $value, $fail) {
                                    $name_parts = preg_split('/\s+/', trim($value));

                                    $full_name_size = sizeof($name_parts);

                                    if ($full_name_size < 2) {
                                        $fail($attribute . ' is invalid.');
                                    }
                                }],
                            'family_member.*.sex' => 'required',
                            'family_member.*.religion' => 'required',
                            'family_member.*.phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                            'family_member.*.occupation' => 'required',
                            'family_member.*.family_relation' => 'required',

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

                        $check_membership_detail = MembershipModel::where('id', $user_uuid)->first();
                        if ($check_membership_detail != null) {
                            return response()->json(
                                [
                                    'status' => false,
                                    'message' => 'User Already Registered as Dharma Ideal Sponsor Membership',
                                ],
                                404,
                            );
                        }

                        $membership_type_duration_detail = MemberShipDuration::where('id', $post_data['membership_duration_id'])->first();
                        $membership_data = [
                            'id' => $user_uuid,
                            'payment_id' => $post_data['payment_id'],
                            'payment_status' => 'unpaid',
                            'currency' => $membership_type_duration_detail['currency'],
                            'amount' => $membership_type_duration_detail['amount'],
                            // 'religion' => $post_data['religion'],
                            'membership_duration_id' => $post_data['membership_duration_id'],
                            'occupation' => $post_data['occupation'],
                            'qualification' => $post_data['qualification'],
                        ];
                        $inserted_membership = MembershipModel::create($membership_data);
                        if (count($post_data['family_member']) > 0) {

                            for ($i = 0; $i < count($post_data['family_member']); $i++) {
                                $family_member_data[$i] = [
                                    'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                                    'full_name' => $post_data['family_member'][$i]['full_name'],
                                    'sex' => $post_data['family_member'][$i]['sex'],
                                    'religion' => $post_data['family_member'][$i]['religion'],
                                    'phone' => $post_data['family_member'][$i]['phone'],
                                    'occupation' => $post_data['family_member'][$i]['occupation'],
                                    'family_relation' => $post_data['family_member'][$i]['family_relation'],
                                    'main_user_id' => $user_uuid,
                                ];
                                $inserted_family_member_detail[$i] = MembershipFamilyMember::create($family_member_data[$i]);
                            }
                        }

                        return response()->json(
                            [
                                'status' => true,
                                'message' => 'User Successfully registered as Dharma Ideal Sponsor Membership',
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
                    'religion' => 'required',
                    'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                    'email' => ['required', 'email'],
                    'country_id' => 'required',
                    'city_new_name' => 'required',
                    'street' => 'required',
                    'zip_code' => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
                    'membership_duration_id' => 'required',
                    'payment_id' => 'required',

                    // 'family_member'=>['required','array'],
                    'family_member.*.full_name' => ['required',
                        function ($attribute, $value, $fail) {
                            $name_parts = preg_split('/\s+/', trim($value));

                            $full_name_size = sizeof($name_parts);

                            if ($full_name_size < 2) {
                                $fail($attribute . ' is invalid.');
                            }
                        }],
                    'family_member.*.sex' => 'required',
                    'family_member.*.religion' => 'required',
                    'family_member.*.phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                    'family_member.*.occupation' => 'required',
                    'family_member.*.family_relation' => 'required',

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
                $user_uuid = \Ramsey\Uuid\Uuid::uuid4()->toString();
                $post_data['user_uuid'] = $user_uuid;
                $user_detail = [
                    'id' => $user_uuid,
                    'full_name' => $post_data['full_name'],
                    'email' => $post_data['email'],
                    'sex' => $post_data['sex'],
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
                $membership_type_duration_detail = MemberShipDuration::where('id', $post_data['membership_duration_id'])->first();
                $membership_data = [
                    'id' => $user_uuid,
                    'payment_id' => $post_data['payment_id'],
                    'payment_status' => 'unpaid',
                    'currency' => $membership_type_duration_detail['currency'],
                    'amount' => $membership_type_duration_detail['amount'],
                    'religion' => $post_data['religion'],
                    'membership_duration_id' => $post_data['membership_duration_id'],
                    'occupation' => $post_data['occupation'],
                    'qualification' => $post_data['qualification'],
                ];
                $inserted_membership = MembershipModel::create($membership_data);
                if (count($post_data['family_member']) > 0) {

                    for ($i = 0; $i < count($post_data['family_member']); $i++) {
                        $family_member_data[$i] = [
                            'id' => \Ramsey\Uuid\Uuid::uuid4()->toString(),
                            'full_name' => $post_data['family_member'][$i]['full_name'],
                            'sex' => $post_data['family_member'][$i]['sex'],
                            'religion' => $post_data['family_member'][$i]['religion'],
                            'phone' => $post_data['family_member'][$i]['phone'],
                            'occupation' => $post_data['family_member'][$i]['occupation'],
                            'family_relation' => $post_data['family_member'][$i]['family_relation'],
                            'main_user_id' => $user_uuid,
                        ];
                        $inserted_family_member_detail[$i] = MembershipFamilyMember::create($family_member_data[$i]);
                    }
                }

                return response()->json(
                    [
                        'status' => true,
                        'message' => 'User Successfully registered as Dharma Ideal Sponsor Membership',
                        'user_id' => $user_uuid,
                    ],
                    200,
                );
            }
        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to Register as Dharma Ideal Sponsor Membership',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

/**
 * @method to get membership_duration
 * @author roshan
 *
 */
    public function get_membership_duration(Request $request)
    {
        $membership_duration = MemberShipDuration::all();
        if (count($membership_duration) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched Successfully!',
                    'membership_duration' => $membership_duration,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to Fetch',
                ],
                500,
            );
        }
    }

/**
 * @method to get membership detail
 * @param $user_id is the user uuid
 * @author roshan
 */
    public function membership_detail(Request $request, $user_id)
    {
        if ($user_id) {
            $membership_detail = MembershipModel::select('usertbl.id', 'usertbl.full_name', 'usertbl.email', 'usertbl.sex', 'usertbl.phone', 'usertbl.country_id', 'countries.name as country_name', 'states.name as state_name', 'usertbl.state_id', 'usertbl.city as city_new_name', 'usertbl.street', 'usertbl.zip_code', 'membership.religion', 'membership.membership_duration_id', 'membership.occupation', 'membership.qualification', 'membership_duration.duration', 'membership_duration.currency', 'membership_duration.amount', 'membership.payment_id', 'membership.payment_status', 'payment_option.*')
                ->where('membership.id', $user_id)
                ->join('usertbl', 'usertbl.id', '=', 'membership.id')
                ->join('membership_duration', 'membership_duration.id', '=', 'membership.membership_duration_id')
                ->join('payment_option', 'payment_option.id', '=', 'membership.payment_id', 'left')
                ->join('countries', 'countries.id', '=', 'usertbl.country_id', 'left')
                ->join('states', 'states.id', '=', 'usertbl.state_id', 'left')
                ->first();

            // dd($membership_detail);
            if ($membership_detail != null) {
                // foreach($membership_detail as $key => $value){
                $membership_detail['membership_duration_name'] = $membership_detail['duration'] . ' [' . $membership_detail['currency'] . ' ' . intval($membership_detail['amount']) . ']';
                $membership_detail['family_member'] = MembershipFamilyMember::where('main_user_id', $membership_detail['id'])->get();
                // }
                return response()->json([
                    'status' => true,
                    'message' => 'Member fetched Successfully',
                    'membership_detail' => $membership_detail,
                ], 200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Member not found!',
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
     * @mehod to update membership detail
     * @author roshan
     */

    public function update_membership_registration(Request $request, $user_id)
    {
        $post_data = $request->all();
        try {
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
                'religion' => 'required',
                'phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user_id)],
                'country_id' => 'required',
                'city_new_name' => 'required',
                'street' => 'required',
                'zip_code' => ['required', 'string', 'regex:/^\d{5}(-\d{4})?$/'],
                'membership_duration_id' => 'required',
                'payment_id' => 'required',

                // 'family_member'=>['required','array'],
                'family_member.*.uuid' => 'required',
                'family_member.*.full_name' => ['required',
                    function ($attribute, $value, $fail) {
                        $name_parts = preg_split('/\s+/', trim($value));

                        $full_name_size = sizeof($name_parts);

                        if ($full_name_size < 2) {
                            $fail($attribute . ' is invalid.');
                        }
                    }],
                // 'family_member.*.sex'=>'required',
                'family_member.*.sex' => 'required',
                'family_member.*.religion' => 'required',
                'family_member.*.phone' => ['required', 'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                'family_member.*.occupation' => 'required',
                'family_member.*.family_relation' => 'required',

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
            // // dd(count($post_data['sex']));

            // $check_user_detail=UserRegistration::where('email',$post_data['email'])->first();
            // dd($check_user_detail);
            // if($check_user_detail==null){
            // $user_uuid=\Ramsey\Uuid\Uuid::uuid4()->toString();
            // $post_data['user_uuid']=$user_uuid;
            $user_detail = [
                // 'id'=> $user_uuid,
                'full_name' => $post_data['full_name'],
                'email' => $post_data['email'],
                'sex' => $post_data['sex'],
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

            UserRegistration::where('id', $user_id)->update($user_detail);
            // }else{
            //     $user_uuid=$check_user_detail['id'];
            //     $check_membership_detail=MembershipModel::where('id',$user_uuid)->first();
            //     if($check_membership_detail!=null){
            //         return response()->json(
            //             [
            //                 'status' => false,
            //                 'message' => 'User Already Registered as Dharma Ideal Sponsor Membership',
            //             ],
            //             404,
            //         );
            //     }
            // }
            $membership_type_duration_detail = MemberShipDuration::where('id', $post_data['membership_duration_id'])->first();
            $membership_data = [
                // 'id'=>$user_uuid,
                'payment_id' => $post_data['payment_id'],
                'payment_status' => 'unpaid',
                'currency' => $membership_type_duration_detail['currency'],
                'amount' => $membership_type_duration_detail['amount'],
                'religion' => $post_data['religion'],
                'membership_duration_id' => $post_data['membership_duration_id'],
                'occupation' => $post_data['occupation'],
                'qualification' => $post_data['qualification'],
            ];
            MembershipModel::where('id', $user_id)->update($membership_data);
            if (count($post_data['family_member']) > 0) {

                for ($i = 0; $i < count($post_data['family_member']); $i++) {
                    $family_member_data[$i] = [
                        // 'id'=>\Ramsey\Uuid\Uuid::uuid4()->toString(),
                        'full_name' => $post_data['family_member'][$i]['full_name'],
                        'sex' => $post_data['family_member'][$i]['sex'],
                        'religion' => $post_data['family_member'][$i]['religion'],
                        'phone' => $post_data['family_member'][$i]['phone'],
                        'occupation' => $post_data['family_member'][$i]['occupation'],
                        'family_relation' => $post_data['family_member'][$i]['family_relation'],
                        // 'main_user_id'=>$user_uuid,
                    ];
                    MembershipFamilyMember::where('id', $post_data['family_member'][$i]['uuid'])->update($family_member_data[$i]);
                }
            }

            return response()->json(
                [
                    'status' => true,
                    'message' => 'User Successfully  Updeted',
                    'user_id' => $user_id,
                ],
                200,
            );

        } catch (\Throwable $e) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to Update Dharma Ideal Sponsor Membership',
                    'error' => $e->getMessage(),
                ],
                500,
            );
        }
    }

    /**
     * @method to send email to the user after registration
     * @author roshan
     *
     */
    public function send_email_to_register_member($user_id)
    {
        //    $token=str_random(60);

        $user_detail = MembershipModel::select('usertbl.id', 'usertbl.full_name', 'usertbl.email', 'usertbl.sex', 'usertbl.phone', 'usertbl.country_id', 'countries.name as country_name', 'states.name as state_name', 'usertbl.state_id', 'usertbl.city as city_name', 'usertbl.street', 'usertbl.zip_code', 'membership.religion', 'membership.membership_duration_id', 'membership.occupation', 'membership.qualification', 'membership_duration.duration')
            ->where('membership.id', $user_id)
            ->join('usertbl', 'usertbl.id', '=', 'membership.id')
            ->join('membership_duration', 'membership_duration.id', '=', 'membership.membership_duration_id')
            ->join('countries', 'countries.id', '=', 'usertbl.country_id', 'left')
            ->join('states', 'states.id', '=', 'usertbl.state_id', 'left')
            ->first();
        if ($user_detail != null) {
            // dd($user_detail);
            // $member_detail=MembershipModel::where('')

            //    $token=Str::random(60);
            // $token=$this->generate_token();

            $subject = '[Dharma Ideal Campaign] Sponsor Membership Registration';
            $family_member = MembershipFamilyMember::where('main_user_id', $user_detail['id'])->get();

            $maildata = [
                'name' => $user_detail['full_name'],
                'phone' => $user_detail['phone'],
                'email' => $user_detail['email'],
                'sex' => $user_detail['sex'],
                'religion' => $user_detail['religion'],
                'membership_duration' => $user_detail['duration'],
                'country' => $user_detail['country_name'],
                'state' => $user_detail['state_name'],
                'city' => $user_detail['city_name'],
                'street' => $user_detail['street'],
                'zip_code' => $user_detail['zip_code'],
                'occupation' => $user_detail['occupation'],
                'qualification' => $user_detail['qualification'],
                'subject' => $subject,
                'to' => $user_detail['email'],
                'family_member' => $family_member,
                'form_type' => 'membership',
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

}
