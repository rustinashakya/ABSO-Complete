<?php


namespace App\Http\Controllers\Admin;

use App\Exports\ExportNewsLetters;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NewsLetter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;

class NewsletterController extends Controller
{
    public function index(){
        $letter = NewsLetter::latest()->paginate();
        $parent_nav = 'publication';
        $child_nav= 'news';
        
        return view('newsletter.index',compact('letter','parent_nav','child_nav'));
    }

    public function store(Request $request) {
        try {
        $data = $request->all();

        $validationRules = [
                    'g-recaptcha-response' => 'required',
                    'email' => 'required|email|unique:news_letters,email',

        ];

        $validator = Validator::make(
            $request->all(),
            $validationRules,
            $messages = [
                'g-recaptcha-response.required' => 'Captcha field is required.',
                'email'=>'Email already Registered',
            ]
        );
                if ($validator->fails()) {
                    return redirect()->back()
                            ->withErrors($validator)
                            ->withInput()
                            ->setTargetUrl(url()->previous() . '#banner');
                }

                $data=array(
                    'from'=>$request->email,
                    'content' => 'NewsLetter',
                    'name' => 'test'
                );

                $letter = NewsLetter::create([
                    'email' => $request->email
                ]);


                if($letter){
                    Mail::send('email.contact-mail',$data,function ($message) use ($data){
                        $receiver_email_1 = config('app.receiver_email_1');
                        $message->from($data['from']);
                        $message->to($receiver_email_1);
                        $message->bcc($receiver_email_1);
                        $message->subject('NewsLetter');
                    });

                    Mail::send('email.contact-mail',$data,function ($message) use ($data){
                        $receiver_email_1 = config('app.receiver_email_1');
                        $message->from($receiver_email_1);
                        $message->to($data['from']);
                        $message->subject('NewsLetter');
                    });
                }

                return redirect()->back()->with('message', 'Thank you for messaging us. We will contact you very soon !');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function exportNewsLetters() {
        return Excel::download(new ExportNewsLetters, 'newsLetter.xlsx');
    }

    public function delete($id) {
        $news = NewsLetter::find($id);
        $news->delete();
        // Contact::withTrashed()->find($contact_id)->restore();
        $message = 'NewsLetter Delete';
        return redirect()->back()->withSuccess('NewsLetter Delete !!!')->withMessage($message);
    }
}
