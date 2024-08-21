<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Mail\MailNotification;
use App\Models\Donation_payment;
use App\Models\Donation_payment_has_donation;
use Illuminate\Support\Facades\DB;


class DonationApiController extends Controller
{
    public function donation_payment(Request $request){
        try {

        $data=$request->all();
        // dd($data);
        $validator = Validator::make($data, [
            'payment_id' => [
                'required'
            ],
            'application_id' => [
                'required'
            ],
            'amount' => 'required|numeric',
            'currency' => 'required',
            'donation' => 'required|array',
        ],
        $message = [
            'application_id' => 'Application id is required',
            'payment_id' => 'Payment id is required',
            'amount' => 'Amount field is required',
            'currency' => 'Currency field is required',
            'donation' => 'Donation field is required',
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
        // $site_setting = SiteSetting::select('email')->first();
        // dd($site_setting);
        DB::beginTransaction();
        $donation=new Donation_payment();
        $donation->payment_id=$request->payment_id;
        $donation->application_id=$request->application_id;
        $donation->amount=$request->amount;
        $donation->currency=$request->currency;
        $donation->save();
        // dd($donation);
        if ($donation) {
            foreach($data['donation'] as $donation_id){
            $donation_has_payment=new Donation_payment_has_donation();
            $donation_has_payment->donation_id=$donation_id;
            $donation_has_payment->donation_payment_id=$donation->id;
            $donation_has_payment->save();
            }
            if($donation_has_payment){
            DB::commit();
                $data=['currency'=>$request->currency,'application_id'=>$request->application_id,'Donation_payment_id'=>$donation->id,'Amount'=>$request->amount,'payment_method'=>$request->paymemt_id];
            // dd($topic_data);
            return response()->json(
                [
                    'status' => true,
                    'data'=>$data,
                    'message' => 'Donation Added Successfully',
                    // 'contact_id' => $success->id,
                ],
                200,
            );
        }else{
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to add',
                ],
                404,
            );
        }
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to add',
                ],
                404,
            );
        }

        } catch (\Throwable $th) {
            Log::error('Error' . $th);
            throw $th;
        }
    }
}
