<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Applicant;
use App\Models\Contact;
use App\Models\Vacancy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class ApplicantController extends Controller
{
    public function contact_store(Request $request)
    {
        try {
            $validationRules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone' => [
                    'nullable',
                    'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'
                ],
                'message' => ['required', 'string'],
                'subject' => ['required', 'string'],
                'g-recaptcha-response' => ['required'],
            ];
            $validationMessages = [
                'email.unique' => 'Email already exists',
                'name.required' => 'Name field is required',
                'email.required' => 'Email field is required',
                'phone.required' => 'Phone field is required',
                'message.required' => 'Message field is required',
                'name.max' => 'Name should be less than 255 characters',
                'email.max' => 'Email should be less than 255 characters',
                'phone.regex' => 'Phone number is invalid',
                'g-recaptcha-response.required' => 'Captcha is required',
            ];

            $validator = Validator::make($request->all(), $validationRules, $validationMessages);

            if ($validator->fails()) {
                // Validation failed
                return response()->json([
                    'errors' => $validator->errors()
                ], 422); // 422 Unprocessable Entity status code
            }

            $contact = Contact::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone_no' => $request->phone,
                'message' => $request->message,
                'subject' => $request->subject,
            ]);

            // Prepare email subject
            $subject = 'Thank You for Contacting Us';
            $company_name = env('APP_NAME');
            // Prepare mail data

            $maildata = [
                'name' => $contact->name,
                'email' => $contact->email,
                'company_name' => $company_name,
                'subject' => $subject,
                'subjectssss'=> $contact->subject,
                'content' => $contact->message,
            ];
            $get_mail_sender = Mail::send('email.contact-us-mail',$maildata,function ($message) use ($maildata){
                $mail_sender = config('app.mail_username') ?? env('MAIL_FROM_ADDRESS');
                $message->from($mail_sender);
                $message->to($maildata['email']);
                $message->bcc('sagundhk@gmail.com');
                $message->subject($maildata['subject']);
            });
        } catch (\Exception $e) {
            // toast($e->getMessage(), 'error');
            // return redirect()->back()->withErrors($validator)->withInput();
            return response()->json([
                'errors' => $validator->errors()
            ]);
        }
        // toast('Thank you for Contact us', 'success');
        return response()->json(['success' => 'Thank you for Contact us']);
    }
}
