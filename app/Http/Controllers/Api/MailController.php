<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
{

    public function sendMail($uid)
    {
        // dd($uid);
       try {
        // $user_detail =  $appointment_details=Appointment::select(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS name"),
        // 'email','sex','dob','phone_no','appointment.date as appointment_date',
        // 'time as appointment_time','doctor_availability_id','province_id','fee','address','city','payment_option.payment_method','payment_status',
        // 'payment_confirmation_code as transaction_no','teams.name as doctor_name','teams.designation','teams.nmc_number'
        // )
        // ->join('payment_option','payment_option.id','=','appointment.payment_method_id','left')
        // ->join('doctor_schedule','doctor_schedule.id','=','appointment.doctor_availability_id')
        // ->join('teams','teams.id','=','doctor_schedule.team_id')
        // ->where('appointment.id',$uid)->first();
        $user_detail=Appointment::select(DB::raw("CONCAT(first_name, ' ', COALESCE(middle_name, ''), ' ', last_name) AS name"),'appointment.payment_confirmation_code as transaction_no','appointment.id','appointment.first_name','appointment.middle_name','appointment.last_name','appointment.email','appointment.sex','appointment.dob','appointment.phone_no',
         'appointment.date as appointment_date','time as appointment_time','appointment.payment_status','appointment.created_at','note','doctor_availability_id','appointment.country_id',
         'countries.name as country_name','province_id','states.name as province_name','fee','address as street','city'
         ,'teams.id as doctor_id','teams.name as doctor_name' ,'payment_option.payment_method','payment_option.icon_url','payment_option.id as payment_id'
         )
                 ->join('doctor_schedule','doctor_schedule.id','=','appointment.doctor_availability_id')
                 ->join('teams', 'teams.id', '=', 'doctor_schedule.team_id')
                 ->join('countries', 'countries.id', '=', 'appointment.country_id')
                 ->join('states', 'states.id', '=', 'appointment.province_id','left')
                 ->join('payment_option', 'payment_option.id', '=', 'appointment.payment_method_id')
                //  ->where('appointment.status','pending')
                 ->where('appointment.id',$uid)->first();

        // dd($user_detail);
        // ->where('membership.id', $user_id)
        // ->first();
        if ($user_detail != null) {
            // dd($user_detail);
            // $member_detail=MembershipModel::where('')

            //    $token=Str::random(60);
            // $token=$this->generate_token();

            $subject = '[Hope] New Doctor\'s Appointment Booked by '.ucwords(@$user_detail['name']);
           
            $maildata = [
                'name' => $user_detail['name'],
                'phone' => $user_detail['phone_no'],
                'email' => $user_detail['email'],
                'subject' => $subject,
                'to' => $user_detail['email'],
                'amount'=>$user_detail['fee'],
                'payment_method'=>$user_detail['payment_method'],
                'payment_status'=>$user_detail['payment_status'],
                'transaction_no' => $user_detail['transaction_no'],
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
            // $maildata = [
            //     'name' => $user_detail['name'],
            //     'phone' => $user_detail['phone_no'],
            //     'email' => $user_detail['email'],
            //     'subject' => $subject,
            //     'to' => $user_detail['email'],
            //     'amount'=>$user_detail['fee'],
            //     'payment_method'=>$user_detail['payment_method'],
            //     // 'payment_icon_url'=>$user_detail['payment_icon_url'],
            //     'payment_status'=>$user_detail['payment_status'],
            //     'transaction_id' => $user_detail['transaction_no'],
            //     'fee'=>$user_detail['fee'],
            //     'address'=>$user_detail['address'],
            //     'doctor_name'=>$user_detail['doctor_name'],
            //     'designation'=>$user_detail['designation'],
            //     'nmc_number'=>$user_detail['nmc_number'],
            //     // 'token'=>'https://dharmaideal.org?token='.$token
            //     // 'from'=>,
            // ];
        // dd($maildata);
        $get_mail_sender = Mail::send('email.payment-success-mail',$maildata,function ($message) use ($maildata){
            $mail_sender = config('app.mail_username');
            $message->from($mail_sender,'Hope Fertility and Diagnostic');
            $message->to(env('RECEIVER_EMAIL_1'));
            $message->cc(env('RECEIVER_EMAIL_2'));
            $message->subject($maildata['subject']);
        });
        if($get_mail_sender){
            return response()->json([
                'status' => true,
                'message'=>'Mail send'
            ],200);
        }else{
            return response()->json([
                'status' => false,
                'message'=>'Error in mailing to admin'
            ],400);
        }
    }else{
        return response()->json([
            'status' => false,
            'message'=>'Appointment details not found'
        ],400);
    }

        //  return true;
       } catch (\Throwable $th) {

            die($th);
       }

    }
}
