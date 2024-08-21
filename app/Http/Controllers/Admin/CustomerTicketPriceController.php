<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CustomerTicketPrice;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class CustomerTicketPriceController extends Controller
{
    /**
     * Display a form of the customer type pricing.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewCustomerTypeForm()
    {
        return view('customer_type.form');
    }

    /**
     * Display a listing of the customer type pricing.
     *
     * @return \Illuminate\Http\Response
     */
    public function fetchCustomer()
    {
        $customer_type = CustomerTicketPrice::where('is_active', '1')->get();
        return response()->json([
            'success' => true,
            'customer_type' => $customer_type,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nationality_type' => 'required',
            'age_group' => 'required',
            'trip'=> 'required',
            'rate'=> 'required|integer'
        ],$message = [
            'rate' => 'Rate field is required'
        ]);
        if ($validator->fails()) {
                return response()->json([
                        'status' => 400,
                        'error' => $validator->errors()->toArray()
                    ]);
            }
            else {
                $update = [
                    'is_active' => 0
                ];
                $create = [
                    'nationality_type' => $request->nationality_type,
                    'age_group' => $request->age_group,
                    'trip_type' => $request->trip,
                    'rate' => $request->rate,
                    'is_active' => 1
                ];
                $data = DB::table('customer_ticket_prices')->where(
                    ['nationality_type' =>  $request->nationality_type,
                    'age_group' => $request->age_group,
                    'trip_type' => $request->trip],
                )->update($update);

                $customer_price = CustomerTicketPrice::create($create);

                if($customer_price) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Customer Ticket Type Successfully Created',
                    ]);
                }
            }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CustomerTicketPrice $ticket)
    {
        if($ticket) {
            return response()->json([
                'status' => 200,
                'message' => $ticket,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Customer Not Found',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CustomerTicketPrice $ticket)
    {
        $validator = Validator::make($request->all(), [
            'nationality_type' => 'required',
            'age_group' => 'required',
            'trip'=> 'required',
            'rate'=> 'required'
        ],$message = [
            'rate' => 'Rate field is required'
        ]);
        if ($validator->fails()) {
                return response()->json([
                        'status' => 400,
                        'error' => $validator->errors()->toArray()
                    ]);
            }
            else {
                $customer_id = $ticket->id;

                $update = [
                    'is_active' => 0
                ];
                $create = [
                    'nationality_type' => $request->nationality_type,
                    'age_group' => $request->age_group,
                    'trip_type' => $request->trip,
                    'rate' => $request->rate,
                    'is_active' => 1
                ];
                $data = DB::table('customer_ticket_prices')->where(
                    ['nationality_type' =>  $request->nationality_type,
                    'age_group' => $request->age_group,
                    'trip_type' => $request->trip],
                )->update($update);

                $customer_price = CustomerTicketPrice::create($create);

                if($customer_price) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Customer Ticket Type Successfully Updated',
                    ]);
                }
            }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CustomerTicketPrice $ticket)
    {
        $deleted = $ticket->delete();
        Log::info('Delete by'. auth()->user()->email);
        if($deleted) {
            return response()->json([
               'status' => 200,
               'message' => 'Customer type is deleted'
            ]);
        }
    }

    /**
     * getInactive function gets inactive details
     *
     * @return void
     */
    public function getInactive($ticket_id) {
        $get_ticket = CustomerTicketPrice::findOrFail($ticket_id);

        $ticket = $get_ticket
                ->where('age_group',$get_ticket->age_group)
                ->where('nationality_type',$get_ticket->nationality_type)
                ->where('trip_type',$get_ticket->trip_type)
                ->get();

        return view('customer_type.get-inactive-details',compact('ticket'));
    }

}