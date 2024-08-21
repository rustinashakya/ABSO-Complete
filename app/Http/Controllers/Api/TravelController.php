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
use App\Models\Travel;

class TravelController extends Controller
{
    public function assistance_in_travel(Request $request){
        try {

        $data=$request->all();
        // dd($data);
        $validator = Validator::make($data, [
            'arrival_date' => [
                'required','date'
            ],
            'departure_date' => [
                'required','date','after:arrival_date'
            ],
            'mode_of_transportation' => 'required|array',
            'application_id' => 'required|numeric',
        ],
        $message = [
            'application_id' => 'Application id is required',
            'mode_of_transportation' => 'Mode of Transportation field is required',
            'address.regex' => 'Enter valid address ',
            'departure_date' => 'Departure date field is required',
            'arrival_date' => 'Arrival date field is required',
            'arrival_date.date' => 'Arrival date must be a date',
            'departure_date.date' => 'Departure date must be a date',
            'departure_date.after' => 'Departure date must be a date after Arrival date',
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
        foreach($data['mode_of_transportation'] as  $transport){
        $travel=new Travel();
        $travel->arrival_date=$request->arrival_date;
        $travel->departure_date=$request->departure_date;
        $travel->mode_of_transportation=$transport;
        $travel->application_id=$request->application_id;
        $travel->save();
        }
        // dd($exam_batch_data);
        if ($travel) {
            // dd($topic_data);
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Assistance in travel Added Successfully',
                    // 'contact_id' => $success->id,
                ],
                200,
            );
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
