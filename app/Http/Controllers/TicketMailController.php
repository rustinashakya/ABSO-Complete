<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
class TicketMailController extends Controller
{
    //

    public function sendMail($to,$maildatas,$sender_name,$sender_date,$subject,$attachment)
    {
       try {
        $data = array(
            'to' => $to,
            'name' => $sender_name,
            'date' => $sender_date,
            'subject' => $subject,
            'attachment' => $attachment
        );

         Mail::send('email.ticket-mail', ['maildatas' => $maildatas], function($message) use($data){
            $message->from(env('SENDER_EMAIL'));
            $message->to($data['to']);
            $message->subject($data['subject']);
            if(!empty($data['attachment']))
            {
                foreach($data['attachment'] as $d)
                {
                    $message->attach($d);
                }
            }
          });

         return true;
       } catch (\Throwable $th) {

            die($th);
       }

    }
}