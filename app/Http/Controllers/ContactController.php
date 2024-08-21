<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Exports\ExportContacts;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function contact(){
        $get_lang = Session::get('locale');
        $site_setting = SiteSetting::firstOrFail();
        return view('contact',compact('site_setting','get_lang'));

    }

    public function mail(Request $request)
    {
        try {
           // dd($request->all());
        $get_lang = Session::get('locale');

        $data = $request->all();
        $validationRules = [
                    'g-recaptcha-response' => 'required',
                    'name' => 'required',
                    'email' => 'required|email',
                    'message' => 'required',
                    'phone' => 'required',
        ];

        $validator = Validator::make(
            $request->all(),
            $validationRules,
            $messages = [
                'g-recaptcha-response.required' => 'Captcha field is required.',
            ]
        );
                if ($validator->fails()) {
                    return back()
                            ->withErrors($validator)
                            ->withInput();
                }
                // if ($validator->fails()) {
                //     return response()->json(['error' => $validator->errors(), 'error']);
                // }

        $data=array(
            'name'=>$request->name,
            'from'=>$request->email,
            'content'=>$request->message,
        );
//        dd($data);
        $contactDetails = new Contact();
        $contactDetails->name = $request->name;
        $contactDetails->email = $request->email;
        $contactDetails->message = $request->message;
        $contactDetails->phone_no = $request->phone;
        if($contactDetails->save()){
            $mail_receiver = config('app.mail_username');

            $mail_receivers = Mail::send('email.contact-mail',$data,function ($message) use ($data,$mail_receiver){
                $message->from($data['from']);
                $message->to($mail_receiver);
                $message->subject($data['content']);
            });
            if($mail_receivers) {
                Log::info('email receive by '. $mail_receiver);
            }

            $get_mail_sender = Mail::send('email.contact-mail',$data,function ($message) use ($data){
                $mail_sender = config('app.mail_username');
                $message->from($mail_sender);
                $message->to($data['from']);
                $message->subject($data['content']);
            });
            if($get_mail_sender) {
                Log::info('email sent to '.$data['from']);
            }
        }
        if($get_lang == 'en'){
            $message = 'Thank you for messaging us. We will contact you very soon !';
            }
            if($get_lang == 'np'){
                $message = 'हामीलाई सन्देश पठाउनु भएकोमा धन्यवाद। हामी तपाईंलाई चाँडै सम्पर्क गर्नेछौं!';
                }

            if($get_lang == 'en'){
            return redirect()->route('frontend.contact')->withSuccess('Thank you for messaging us. We will contact you very soon !')->withMessage($message);
            }  if($get_lang == 'np'){
            return redirect()->route('frontend.contact')->withSuccess('हामीलाई सन्देश पठाउनु भएकोमा धन्यवाद। हामी तपाईंलाई चाँडै सम्पर्क गर्नेछौं!')->withMessage($message);

            }
        } catch (\Throwable $th) {
            Log::error('Error  in contact mail ' . $th);
            throw $th;
        }

    }


    public function exportContact() {
            return Excel::download(new ExportContacts, 'contacts.xlsx');

    }


    public function contactMail(Request $request)
    {
        if($request['email']!=''){
            $email=$request['email'];
            $display= '';
            foreach($email as $mail){
                $display=$display.$mail.",";
            }
            $total_display = trim($display,",");
            $emails=$total_display;
        }
        else{
            $emails='';
        }
        return view('email.mail-form',compact('emails'));
    }

    // public function mailSendFromContact(Request $request)
    // {

    //     $site_data = SiteSetting::find(1);
    //     if($request['to']!=''){
    //         $email=$request['to'];
    //         $display= '';
    //         foreach($email as $mail){
    //             $display=$display.$mail.",";
    //         }
    //         $total_display = trim($display,",");
    //         $emails=(explode(",",$total_display));;
    //     }
    //     $data=array(
    //         'from'=>'test',
    //         'email'=>$emails,
    //         'subject'=>$request->subject,
    //         'content'=>$request->message,
    //         'mail_name'=>$site_data->title,
    //     );
    //     Mail::send('emails.hrlite-mail',$data,function ($message) use ($data){
    //         $message->from($data['from'],$data['mail_name']);
    //         $message->bcc($data['email']);
    //         $message->subject($data['subject'].' - '.'test');
    //     });
    //     Toastr::success('Mail Sent successfully', 'Success !!!', ["positionClass" => "toast-bottom-right"]);
    //     return redirect()->route('contact.index');
    // }
}
