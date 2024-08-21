<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\ConsultationFee;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AppointmentApiController extends Controller
{
      //
    /**
     * @method to list schedule date of specific doctor
     * @author subish
     * @id  is the id of doctor(team)
     */

    public function getdatebydoctorid($id){

        $dates = DoctorSchedule::where('team_id', $id)
        // ->wheredate('date', '>=', date('Y-m-d'))
        ->where(function ($query) {
            $query->where('date', '>', now()->toDateString())
                ->orWhere(function ($subquery) {
                    $subquery->whereDate('date', now()->toDateString())
                        ->whereTime('start_time', '>', now()->format('H:i'));
                });
        })
        ->select('date')
        ->groupBy('date')
        ->get()
        ->toArray();
        // dd($dates);
        if (count($dates) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $dates,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Dates not available',
                ],
                400
            );
        }
    }
      /**
     * @method to list schedule time of specific dateof specific doctor
     * @author subish
     * @id  is the id of doctor(team)
     */
    public function gettimebydoctorid(Request $request,$id){
        $rule=[
            'date'=>'required',
        ];
        $validator=Validator::make($request->all(),$rule);
        if($validator->fails()){
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->errors(),
                ],
                404,
            );
        }
        $times = DoctorSchedule::where('team_id', $id)
        ->select('start_time','id as schedule_id')
        ->when($request->date == now()->toDateString(), function ($query) {
            // If date is today, add the time condition
            return $query->where(function ($subquery) {
                $subquery->where(function ($q) {
                    // Compare hours and minutes
                    $q->wheretime('start_time', '>=', now()->format('H:i'));
                });
            });
        })
        // ->wheretime('start_time', '>=', now())
        ->whereDate('date', $request->date)
        // ->groupBy('date')
        ->get()
        ->toArray();
        // dd($times);
        if (count($times) > 0) {
            foreach($times as $key => $value){
                $times[$key]['start_time']=date('h:i A',strtotime($value['start_time']));
            }
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $times,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Time not available',
                ],
                400
            );
        }
    }
      /**
     * @method to fetch active consultation fee of specific doctor
     * @author subish
     * @id  is the id of doctor(team)
     */
    public function getconsultationfeebydoctorid($id){
        $fee= ConsultationFee::where('team_id',$id)
                ->where('status','active')
                ->select('amount','id as consultation_id')
                ->first();
                if ($fee) {
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Data fetched successfully!',
                            'data' => $fee,
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'Consultation fee not available',
                        ],
                        400
                    );
                }
    }
       /**
     * @method to fetch all country
     * @author subish
     * @id  is the id of doctor(team)
     */
    public function getcountries(){
        $countries=DB::table('countries')->select('id as country_id','name')->get();
        if(count($countries)>0){
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $countries,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Countries not available',
                ],
                400
            );
        }
    }
        /**
     * @method to fetch all province of an country
     * @author subish
     * @id  is the id of doctor(team)
     */
    public function getprovince($id){
        $countries=DB::table('states')->where('country_id',$id)->select('id as province_id','name')->get();
        if(count($countries)>0){
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $countries,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Countries not available',
                ],
                400
            );
        }
    }
    /**
     * @method to store appointment
     * @author subish
     */
    public function storeappointment(Request $request){
        $post_data=$request->all();
        try{
            $rule=[
                'doctor_id'=>'required',
                'doctor_availability_id'=>'required',
                'date'=>'required',
                'time'=>'required',
                'dob'=>'required',
                'fee'=>'required',
                'full_name'=>['required',
                function ($attribute, $value, $fail) {
                    $name_parts = preg_split('/\s+/', trim($value));

                    $full_name_size = sizeof($name_parts);

                    if ($full_name_size < 2) {
                        $fail($attribute . ' is invalid.');
                    }
                },],
                'sex'=>'required|in:male,female,others',
                'phone_no'=>['required','regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                'email'=>['required','email'],
                'country_id'=>'required',
                'city'=>'required',
                // 'province_id'=>'required',
                'street'=>'required',
                'payment_id'=>'required'

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
            $full_name=$request->full_name;
        $name_parts = preg_split('/\s+/', trim($full_name)); // Split by multiple spaces
                $firstName = $name_parts[0];

                $full_name_size = sizeof($name_parts);
                $middleName = null;

                $lastName = $name_parts[$full_name_size - 1];
                if ($full_name_size > 2) {

                    array_pop($name_parts);
                    array_shift($name_parts);
                    $middleName= implode(' ', $name_parts);
                }
                // dd($firstName,$middleName,$lastName);

                $fee=ConsultationFee::where('id',$request->fee)
                ->where('status','active')
                ->pluck('amount')
                ->first();
                if($fee){
                // dd($fee);
                $appointment=new Appointment();
                $appointment->first_name=$firstName;
                $appointment->middle_name=$middleName;
                $appointment->last_name=$lastName;
                $appointment->email=$request->email;
                $appointment->sex=$request->sex;
                $appointment->dob=$request->dob;
                $appointment->phone_no=$request->phone_no;
                $appointment->date=$request->date;
                $appointment->time=date('H:i:s',strtotime($request->time));
                $appointment->payment_method_id=$request->payment_id;
                $appointment->note=$request->note;
                $appointment->doctor_availability_id=$request->doctor_availability_id;
                $appointment->country_id=$request->country_id;
                $appointment->province_id=@$request->province_id;
                $appointment->city=$request->city;
                $appointment->fee=$fee;
                $appointment->address=$request->street;//changed address to street as per ui from srijana
                 $appointment->save();
                if($appointment){
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Appointment stored successfully!',
                            'appointment_id' => encrypt($appointment->id),
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'Appointment failed to store',
                        ],
                        400
                    );
                }
            }else{
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Amount not active',
                    ],
                    400
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
     /**
     * @method to fetch appointmentdetails
     * @author subish
     * @id  is the id of appointment
     * preview page
     */
    public function getappointmentdetails($id){
        try{
            //get appointment details by id
            $id=decrypt($id);
            // dd($id);
            $details=Appointment::select(
               ( DB::raw("CONCAT_WS(
                    ' ',
                    first_name,
                    middle_name,
                    last_name
                ) AS full_name"))
            ,'email','sex','dob','phone_no','first_name','middle_name','last_name',
            'appointment.date as appointment_date','time as appointment_time','note','doctor_availability_id','appointment.country_id',
            'countries.name as country_name','province_id','states.name as province_name','fee','address as street','city'
            ,'teams.id as doctor_id','teams.name as doctor_name' ,'payment_option.payment_method','payment_option.icon_url','payment_option.id as payment_id'
            )
                    ->join('doctor_schedule','doctor_schedule.id','=','appointment.doctor_availability_id')
                    ->join('teams', 'teams.id', '=', 'doctor_schedule.team_id')
                    ->join('countries', 'countries.id', '=', 'appointment.country_id')
                    ->join('states', 'states.id', '=', 'appointment.province_id','left')
                    ->join('payment_option', 'payment_option.id', '=', 'appointment.payment_method_id')
                    ->where('appointment.id',$id)->get();
                    // dd($details);
            if($details){
                foreach($details as $key => $value){
                    if($value['middle_name']=='' || $value['middle_name']== null){

                        $details[$key]['name']=$value['first_name'].' '.$value['last_name'];
                    }else{
                        $details[$key]['name']=$value['first_name'].' '.$value['middle_name'].' '.$value['last_name'];

                    }
                    $details[$key]['appointment_time']=date('h:i A',strtotime($value['appointment_time']));
                }
                return response()->json(
                    [
                        'status' => true,
                        'message' => 'Appointment details fetch successfully!',
                        'data' => $details,
                    ],
                    200
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Appointment failed to store',
                    ],
                    400
                );
            }
        }catch(\Throwable $e){
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to fetch',
                    'error'=>$e->getMessage(),
                ],
                500,
            );
        }
    }
     /**
     * @method to store appointment
     * @author subish
     */
    public function updateappointment(Request $request,$cid){
        $post_data=$request->all();
        $id=decrypt($cid);
// dd($id);
        try{
            $rule=[
                'doctor_id'=>'required',
                'doctor_availability_id'=>'required',
                'date'=>'required',
                'time'=>'required',
                'dob'=>'required',
                'fee'=>'required',
                'full_name'=>['required',
                function ($attribute, $value, $fail) {
                    $name_parts = preg_split('/\s+/', trim($value));

                    $full_name_size = sizeof($name_parts);

                    if ($full_name_size < 2) {
                        $fail($attribute . ' is invalid.');
                    }
                },],
                'sex'=>'required|in:male,female,others',
                'phone_no'=>['required','regex:/^\+?[0-9\s\-\(\)]{7,15}$/'],
                'email'=>['required','email'],
                'country_id'=>'required',
                'city'=>'required',
                // 'province_id'=>'required',
                'street'=>'required',
                'payment_id'=>'required'

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
            $full_name=$request->full_name;
        $name_parts = preg_split('/\s+/', trim($full_name)); // Split by multiple spaces
                $firstName = $name_parts[0];

                $full_name_size = sizeof($name_parts);
                $middleName = '';
                // if ($full_name_size < 2) {
                //     return response()->json(
                //         [
                //             'status' => false,
                //             'message' => 'Invalid Name',
                //         ], 404
                //     );
                // }
                $lastName = $name_parts[$full_name_size - 1];
                if ($full_name_size > 2) {

                    array_pop($name_parts);
                    array_shift($name_parts);
                    $middleName= implode(' ', $name_parts);
                }
                $fee=ConsultationFee::where('id',$request->fee)
                ->where('status','active')
                ->pluck('amount')
                ->first();
                // dd($firstName,$middleName,$lastName);
                $update=Appointment::where('id',$id)->update([
                    'first_name'=> $firstName,
                    'middle_name'=> $middleName,
                    'last_name'=> $lastName,
                    'email'=> $request->email,
                    'sex'=> $request->sex,
                    'dob'=> $request->dob,
                    'phone_no'=> $request->phone_no,
                    'date'=> $request->date,
                    'payment_method_id'=> $request->payment_id,
                    'time'=>  date('H:i:s',strtotime($request->time)),
                    'note'=> $request->note,
                    'doctor_availability_id'=> $request->doctor_availability_id,
                    'country_id'=> $request->country_id,
                    'province_id'=> @$request->province_id?@$request->province_id:null,
                    'city'=> $request->city,
                    'fee'=> $fee,
                    'address'=> $request->street,
                ]);
                if($update){
                    return response()->json(
                        [
                            'status' => true,
                            'message' => 'Appointment updated successfully!',
                            'appointment_id' => $cid,
                        ],
                        200
                    );
                } else {
                    return response()->json(
                        [
                            'status' => false,
                            'message' => 'Appointment failed to update',
                        ],
                        400
                    );
                }
            }catch(\Throwable $e){
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'Failed to Update',
                        'error'=>$e->getMessage(),
                    ],
                    500,
                );
            }
    }
    public function bookingconfirm($cid){
        try{

            $id=decrypt($cid);
            // $user_detail=Appointment::select(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS name"),'email','sex','dob','phone_no','date as appointment_date',
            // 'time as appointment_time','doctor_availability_id','country_id','province_id','fee','address','city','payment_method_id')->where('id',$id)->where('status','pending')->first();

           $user_detail=Appointment::select(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS name"),'appointment.id','appointment.first_name','appointment.middle_name','appointment.last_name','appointment.email','appointment.sex','appointment.dob','appointment.phone_no',
         'appointment.date as appointment_date','time as appointment_time','appointment.payment_status','appointment.created_at','note','doctor_availability_id','appointment.country_id',
         'countries.name as country_name','province_id','states.name as province_name','fee','address as street','city'
         ,'teams.id as doctor_id','teams.name as doctor_name' ,'payment_option.payment_method','payment_option.icon_url','payment_option.id as payment_id'
         )
                 ->join('doctor_schedule','doctor_schedule.id','=','appointment.doctor_availability_id')
                 ->join('teams', 'teams.id', '=', 'doctor_schedule.team_id')
                 ->join('countries', 'countries.id', '=', 'appointment.country_id')
                 ->join('states', 'states.id', '=', 'appointment.province_id','left')
                 ->join('payment_option', 'payment_option.id', '=', 'appointment.payment_method_id')
                 ->where('appointment.status','pending')
                 ->where('appointment.id',$id)->first();

        // $user_detail = Appointment::select('customers.*','transaction.amount','transaction.transaction_no','payment_methods.name as payment_method')
        // ->leftjoin('transaction', 'transaction.customer_id', '=', 'customers.id')
        // ->leftjoin('customer_tickets','customer_tickets.customer_id', '=', 'customers.id')
        // ->join('payment_methods','payment_methods.id','=','transaction.payment_method_id','left')
        // ->withCount('customer_ticket')
        // ->findOrFail($id);
        // dd($user_detail);
        // ->where('membership.id', $user_id)
        // ->first();
        if ($user_detail != null) {
            Appointment::where('id',$id)->where('status','pending')->update([
                'status'=>'confirmed',
            ]);
            // dd($user_detail);
            // $member_detail=MembershipModel::where('')

            //    $token=Str::random(60);
            // $token=$this->generate_token();

            
            $subject = '[Hope] Application for appointment with '.$user_detail['doctor_name'].' on '.$user_detail['appointment_date'].' at '.date('h:s A',strtotime($user_detail['appointment_time'])).' received';
            

            $maildata = [
                'name' => $user_detail['name'],
                'phone' => $user_detail['phone_no'],
                'email' => $user_detail['email'],
                'subject' => $subject,
                'to' => $user_detail['email'],
                'amount'=>$user_detail['fee'],
                'payment_method'=>$user_detail['payment_method'],
                'payment_status'=>$user_detail['payment_status'],
                'transaction_id' => $user_detail['transaction_no'],
                'doctor_name'=>$user_detail['doctor_name'],
                'appointment_date'=>$user_detail['appointment_date'],
                'appointment_time'=>date('h:s A',strtotime($user_detail['appointment_time'])),
                'phone_no'=>$user_detail['phone_no'],
                'sex'=>$user_detail['sex'],
                'country_name'=>$user_detail['country_name'],
                'province_name'=>$user_detail['province_name'],
                'city'=>$user_detail['city'],
                'street'=>$user_detail['street'],
                'note'=>$user_detail['note'],
                'fee'=>$user_detail['fee'],
                'dob'=>$user_detail['dob'],
                // 'payment_icon_url'=>$user_detail['payment_icon_url'],
                // 'token'=>'https://dharmaideal.org?token='.$token
                // 'from'=>,
            ];
            // dd($maildata);
            $mail_send = Mail::send('email.user-booking-success', $maildata, function ($message) use ($maildata) {
                $mail_sender = config('app.mail_username');
                $message->from($mail_sender, 'Hope Fertility and Diagnostic Center');
                $message->to($maildata['to']);
                $message->subject($maildata['subject']);
            });

            if($mail_send){
                return response()->json([
                    'success' => true,
                    'status' => true,
                    'customer_id'=>encrypt($id),
                    'message'=>'email sent Successfully'
                ], 200);
            }else{
                return response()->json([
                    'success' => false,
                    'status' => false,
                    'message'=>'failed to send mail'
                ], 400);
            }
    }else{
        return response()->json([
            'success' => true,
            'status' => true,
            'customer_id'=>encrypt($id),
            'message'=>'Appointment booked successfully!'
        ], 200);
    }
    } catch (\Throwable $th) {
        // DB::rollback();
        return response()->json([
        'success' => false,
        'status' => false,
        'message'=>'failed to update',
        'error'=>$th->getMessage(),
    ], 400);

    }
    }
}
