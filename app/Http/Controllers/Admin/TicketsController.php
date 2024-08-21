<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\CustomerTicket;
use App\Models\CustomerTicketPrice;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Models\QR;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\App;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // if($request->is_download == 'ticket') {
        //     $pdf = $this->pdfDownloadTicket($request->customer_id);
        //     return $pdf->download('customer-ticket.pdf');
        // }
            $name = $request->name;
            $date = $request->date;
            $email = $request->email;
            $phone = $request->phone;
            $transaction_code = $request->transaction_code;
            $ticket = Customer::searchCustomer($name, $date, $email, $phone, $transaction_code)
                    ->latest()
                    ->simplePaginate(10);
        return view('admin.ticket.index',compact('ticket'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customer_count = Customer::get()->count();
        return view('admin.ticket.create',compact('customer_count'));
    }



    public function show($id)
    {
        $ticket = Customer::findOrFail($id);
        return view('admin.ticket.view',compact('ticket'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $_is_edit_ticket = $request->is_ticket_edit;
        $ticket = Customer::with('customer_ticket.customer_ticket_type','customer_ticket_sum')->findOrFail($id);
        $total_quantity = $ticket->customer_ticket->sum('quantity');
        return view('admin.ticket.edit',compact('ticket','_is_edit_ticket','total_quantity'));
    }

    public function update(Request $request,$id) {
            $request->validate([
                'name'=>'required|string',
                // 'date'=>'required|date',
                // 'phone'=>'required_if:email,==,null',
                // 'email'=>'required_if:phone,==,null',
            ],$message = [
                'name' => 'Phone field is required',
            ]);
            $customer = Customer::where('id',$request->customer_id)->update([
                'name' => @$request->name,
                'date' => @$request->date,
                'phone' => @$request->phone,
                'email' => @$request->email,
            ]);
            if($request->is_ticket_edit == 'is_ticket_edit'){
                $customer_id = encrypt(@$request->customer_id);
                $is_admin = 'admin';
                $total_input_price = 0;
                return redirect()->route('get.payment.details',
                [   'customer_id' =>  $customer_id,
                    'is_admin' => $is_admin,
                    'total_input_price' => $total_input_price
                ])->withMessage('Customer update');
            }
            return redirect()->route('tickets.index')->withMessage('Customer update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteCustomerTicket(Request $request,$customer_ticket,$total,$customer_id)
    {
       $get_customer_ticket = CustomerTicket::find($customer_ticket);
       $delete = $get_customer_ticket->delete();
       if($delete) {
        $customer_ticket_data_s = CustomerTicket::with('customer_ticket_type')->where('customer_id',$customer_id)->get();
        $total_input_prices = $customer_ticket_data_s->sum('total_price');
        $customer = Customer::find($customer_id);
        $total_input_price = $total;
        return view('admin.ticket.payment_detail',compact(['customer_ticket_data_s','customer','total_input_price','total_input_prices']))->with('message','Successfully create a booking ticket.');
        //    return redirect()->route('get.payment.details',['customer_ticket_data_s' => $customer_ticket_data_s,'total' => $total_price, 'customer' => $get_customer]);
       }
    //    Log::info('Delete ticket');
    //     if($delete) {
    //         return response()->json([
    //            'status' => 200,
    //            'message' => 'Customer Ticket is deleted'
    //         ]);
    //     }

    }

  /**
     * getTicketValue function fetch the customer details and display it on index page
     *
     * @param Request $request
     * @return void
     */

    public function paymentDetailStore(Request $request,$customer_id) {
        $validator = Validator::make($request->all(), [
            'nationality_type' => 'required',
            'age_group' => 'required',
            'trip'=> 'required',
            'quantity' => 'required|integer'
        ],$message = [
            'nationality_type' => 'Nationality type is required',
            'age_group' => 'Age group field is required',
            'trip' => 'Trip field is required',
            'quantity' => 'Quantity field is required',
            'quantity.integer' => 'Quantity must be integer',
        ]);

        if ($validator->fails()) {
                return response()->json([
                        'status' => 400,
                        'error' => $validator->errors()->toArray()
                    ]);
            }
            else {
                $customer_ticket_price =  CustomerTicketPrice::where(
                ['nationality_type' =>  $request->nationality_type,
                'age_group' => $request->age_group,
                'trip_type' => $request->trip,
                'is_active' => '1'])
                ->first();
                try {
                if ($customer_ticket_price || @$customer_ticket_price?->rate == null) {
                    $total_price = $request->quantity * $customer_ticket_price->rate;
                    $data = [];

                    for($i=0;$i<$request->quantity;$i++){
                                $data[] =   [
                                                'customer_id' => $customer_id,
                                                'quantity' => @$request->quantity,
                                                'customer_ticket_price_id' => @$customer_ticket_price->id,
                                                'rate' => $customer_ticket_price->rate,
                                                'discount' => 0,
                                                'total_price' => $total_price,
                                                'created_at'=> now(),
                                                'updated_at'=> now()
                                            ];
                            }
                    $customer_info = CustomerTicket::insert($data);
                    if($customer_info) {
                        $customer = Customer::find($customer_id);
                        $customer_ticket_data_s = CustomerTicket::with('customer_ticket_type')->where('customer_id',$customer_id)->get();
                        $total_input_price = $customer_ticket_data_s->sum('total_price');
                        $total_input_prices = $customer_ticket_data_s->sum('total_price');
                    }
                    return view('admin.ticket.payment_detail',compact('customer','customer_ticket_data_s','total_input_price','total_input_prices'))->with('message','Successfully create a booking ticket.');
                }
                } catch (\Throwable $th) {
                   return $th->getMessage();
                }

            }
    }

    public function editCustomerTicket(CustomerTicket $ticket) {
        if($ticket->customer_ticket_type) {
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
     * getTicketValue function fetch the customer details and display it on index page
     *
     * @param Request $request
     * @return void
     */
    public function updateCustomerTicket(Request $request) {
                $request->validate([
                    'nationality_type' => 'required',
                    'age_group' => 'required',
                    'trip'=> 'required',
                    'quantity' => 'required|integer'
                ],$message = [
                    'nationality_type' => 'Nationality type is required',
                    'age_group' => 'Age group field is required',
                    'trip' => 'Trip field is required',
                    'quantity' => 'Quantity field is required',
                    'quantity.integer' => 'Quantity must be integer',
                ]);

                $customer_ticket_price =  CustomerTicketPrice::where(
                ['nationality_type' =>  $request->nationality_type,
                'age_group' => $request->age_group,
                'trip_type' => $request->trip,
                'is_active' => '1'])
                ->first();

                try {

                if ($customer_ticket_price || @$customer_ticket_price?->rate == null) {
                    $final_data = [
                        'customer_id' => @$request->customer_id,
                        'customer_ticket_price_id' => @$customer_ticket_price->id,
                        'rate' => @$customer_ticket_price?->rate == null ? 0 : $customer_ticket_price?->rate,
                        'quantity' => $request->quantity,
                        'discount' => 0,
                        'total_price' => $request->quantity * @$customer_ticket_price?->rate,
                    ];
                    if ($request->is_add == 'is_add') {
                        $has_data = CustomerTicket::create($final_data);
                    }
                    else {
                        $has_data = CustomerTicket::where('id',$request->customer_ticket_id)->update($final_data);
                    }
                    if($has_data) {
                        return redirect()->route('ticket.edit',$request->customer_id.'?is_ticket_edit=is_ticket_edit')->withMessage('Customer Ticket Update');
                    }
                }
                } catch (\Throwable $th) {
                   return $th->getMessage();
                }
    }

    public function removeCustomerTicket(CustomerTicket $ticket) {
       $_deleted = $ticket->delete();
       return response()->json([
        'status' => 200,
        'message' => 'Customer Ticket Delete',
    ]);

    //    if($_deleted) {
    //     return redirect()->route('ticket.edit',$ticket)->withMessage('Customer Ticket Update');
    //    }
    }

    public function pdfDownloadTicket($customer_id) {
        $customer_id = decrypt($customer_id);
        $customer = Customer::findOrFail($customer_id);

    $total_price = $customer->load(['customer_ticket_sum']);
    $lists = DB::table('customer_tickets')
                        ->select('customer_tickets.*','ticketPrice.age_group','ticketPrice.nationality_type','ticketPrice.trip_type')
                        ->join('customer_ticket_prices as ticketPrice','ticketPrice.id','=','customer_tickets.customer_ticket_price_id')
                        ->where('customer_tickets.customer_id','=',$customer->id)->get();
                        $qr_data = array();
                        foreach($lists as $key => $li)
                        {
                            $qr_data[] = QR::getQrCodesByTicketId($li->id);

                        }
                        $qr_data_s = collect($qr_data)->flatten();

                        $group_qr_code = $customer->main_qr_code;

                        $customer_id = encrypt($customer_id);

                        $data = array(
                            'customer_id' => $customer_id,
                            'name' => $customer->name,
                            'email' => $customer->email ?? 'ajaymrzn02@gmail.com',
                            'phone' => $customer->phone,
                            'date' => $customer->date,
                            'ticket_list' => $lists,
                            'qr_data' => $qr_data_s,
                            'total_price' => $total_price,
                            'group_qr_code' => $group_qr_code,
                            'logo' => url('assets/frontend/img/Final-Logo.png'),
                            'subject' => 'Your ticket for siddhartha cablecar',
                            'ticket_url' => url('my-ticke/is-mail/'.$customer_id)
                        );
                        $ticket_pdf = App::make('dompdf.wrapper');
                        return $pdf = PDF::loadView('frontend.ticket.ticket-pdf',compact('data'));
                        // $path = public_path('storage/uploads/pdf/');
                        // $fileName =  time().'.'. 'pdf' ;
                        // $pdf->save($path . '/' . $fileName);
                
                        // $pdf = public_path('pdf/'.$fileName);
                        // return response()->download($pdf);

                        // return response()->download($pdf);
                      return $pdf->download('customer-ticket.pdf');
                        // return response()->json([
                        //     'status' => 200,
                        //     'message' => $html,
                        // ]);
    }

}