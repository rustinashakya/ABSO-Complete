<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\MailNotification;
use App\Models\SiteSetting;

class ContactApiController extends Controller
{
    public function store(Request $request){
        try {

        $data=$request->all();
        // dd($data);
        $validator = Validator::make($data, [
            'fullname' => [
                'required',
                'string',
                'regex:/^[A-Za-z0-9\s]+$/',
            ],
            'email' => 'required|email',
            'address' => [
                'required',
                'string',
                // 'regex:/^[A-Za-z0-9]+(?:,[A-Za-z0-9]+)*$/'

            ],
            'subject' => 'required|string',
            'phone' => [
                'required','integer',
                // 'regex:/^\+?\d{7,14}$/',
              'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'
            ],
            'message' => 'required',
        ],
        $message = [
            'fullname.required' => 'Name field is required',
            'fullname.regex' => 'Enter valid Name',
            'phone' => 'Phone number field is required',
            // 'phone.integer'=>'Phone no should be number',
            'phone.regex'=>'Invalid Phone no.',
            'email' => 'Email field is required',
            'address' => 'Address field is required',
            // 'address.regex' => 'Enter valid address ',
            'subject' => 'Subject field is required',
            'message' => 'Message field is required',

        ]);

        if ($validator->fails()) {
            //
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                404,
            );
        }
        $maildata=array(
            'name'=>$request->fullname,
            'content'=>$request->message,
            'subject'=>$request->subject,
            'from'=>$request->email,
            'phone'=>$request->phone,
            'email'=>$request-> email,
            'address'=>$request->address,
        );
        // $site_setting = SiteSetting::select('email')->first();
        // dd($site_setting);

        $contact=new Contact();
        $contact->name=$request->fullname;
        $contact->phone_no=$request->phone;
        $contact->email=$request->email;
        $contact->address=$request->address;
        $contact->subject=$request->subject;
        $contact->message=$request->message;
        if($contact->save()){

            //Send Mail to Form Filler:OUtgoing Mail
            $get_mail_sender = Mail::send('email.contact-mail',$maildata,function ($message) use ($maildata){
                $mail_sender = config('app.mail_username');
                $message->from($mail_sender);
                $message->to($maildata['from']);
                // $message->subject($maildata['subject']);
                $message->subject('[Hope] Your message has been received');
            });

            if($get_mail_sender) {
                Log::info('email sent to '.$maildata['from']);
            }
            // Send Mail to Owner:incoming mail
            $mail_receiver = config('app.receiver_email_1');
            $mail_receivers = Mail::send('email.contact-incoming-mail', $maildata, function ($message) use ( $mail_receiver, $maildata) {
            $ccEmails = config('app.receiver_email_2');
                $message->bcc($ccEmails);
                // $message->from($data['from']);
                $message->to($mail_receiver);
                $message->subject('[Hope] You have a New Message from '. $maildata['name']);
            });
            if($mail_receivers) {
                Log::info('email receive by '. $mail_receiver);
            }


        }
        // dd($exam_batch_data);
        if ($contact) {
            // dd($topic_data);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Contact Added Successfully',
                    // 'contact_id' => $success->id,
                ],
                200,
            );
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to add Contact',
                ],
                404,
            );
        }

        } catch (\Throwable $th) {
            Log::error('Error  in contact mail ' . $th);
            throw $th;
        }
    }
}
