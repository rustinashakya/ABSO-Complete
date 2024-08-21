<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\QR;
use App\Models\UserGate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class QRScannerController extends Controller
{
    public function scanQrCode(Request $request) {
        $validator = Validator::make($request->all(),[
            'qr_code' => 'required|integer',
            'gate_no' => 'required|integer'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        

        //fetch customer data
        $customer = Customer::where('main_qr_code',$request->qr_code)->first();

        //check if customer data in not null 
        if($customer != null) {
            //check for arrival ticket
            if($customer->is_verify == '1' && $request->out_going_code == null){ 
                $code = Crypt::encryptString($request->qr_code);
                $customer = $this->fetchCustomerDetails($code);
                $data = [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'date' => $customer->date,
                ];
                return response()->json([
                    'response' => 400,
                    'customer_data' => $data,
                    'message' => 'Code is already used!!!'
                ]);
                // return response()->json([
                //     'success' => 400,
                //     'message' => 'Code is already used!!!'
                // ]);
                // return redirect()->route('scan.qr-code.invalid',$code)->withError('Code is already used!!');
            }
            //check for departure ticket
            if($customer->is_verify_out == '1' && $request->out_going_code == 'out_going_qr'){ 
                $code = Crypt::encryptString($request->qr_code);
                $customer = $this->fetchCustomerDetails($code);
                $data = [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'date' => $customer->date,
                ];
                return response()->json([
                    'response' => 400,
                    'customer_data' => $data,
                    'message' => 'Code is already used!!!'
                ]);
                // return redirect()->route('scan.qr-code.invalid',$code.'?check=departure')->withError('Code is already used!!');
            }

        //Group QR Scanner
        $return_value = $this->scanGroupQrCode($customer,$request->qr_code,@$request->out_going_code);
            if($return_value == 'is_departure') {
                $code = Crypt::encryptString($request->qr_code);
                $customer = $this->fetchCustomerDetails($code);
                $data = [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'date' => $customer->date,
                ];
                $this->createUserGate($request);

                return response()->json([
                    'response' => 200,
                    'customer_data' => $data,
                    'message' => 'Verifed successfully !!!'
                ]);
                // return redirect()->route('scan.qr-code.success',$code.'?check=departure')->withMessage('Verifed successfully !!!');
            }
            else {
                $code = Crypt::encryptString($request->qr_code);
                $customer = $this->fetchCustomerDetails($code);
                $data = [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'date' => $customer->date,
                ];
                $this->createUserGate($request);
                return response()->json([
                    'response' => 200,
                    'customer_data' => $data,
                    'message' => 'Verifed successfully !!!'
                ]);
               
                // return redirect()->route('scan.qr-code.success',$code)->withMessage('Verifed successfully !!!');
            }
        }


        $get_qrcode = QR::where('qr_code_no',$request->qr_code)->first();
        if($get_qrcode != null) {

            //Single QR Scanner
            $code = $this->scanSingleQrCode($request->qr_code,@$request->out_going_code);
    
            $qrcode = Crypt::encryptString($request->qr_code);
            if($code == 'is_verify') {
                $customer = $this->fetchCustomerDetails($request->qr_code);
                    $data = [
                        'name' => $customer->name,
                        'email' => $customer->email,
                        'phone' => $customer->phone,
                        'date' => $customer->date,
                    ];
                    return response()->json([
                        'response' => 400,
                        'customer_data' => $data,
                        'message' => 'Code is already used!!!'
                    ]);
                // return redirect()->route('scan.qr-code.invalid',$qrcode)->withError('Code is already used!!');
            }

            if($code == 'is_departure') {
                $encry_code = Crypt::encryptString($request->qr_code);
                $customer = $this->fetchCustomerDetails($encry_code);
                    $data = [
                        'name' => $customer->name,
                        'email' => $customer->email,
                        'phone' => $customer->phone,
                        'date' => $customer->date,
                    ];
                    return response()->json([
                        'response' => 400,
                        'customer_data' => $data,
                        'message' => 'Code is already used!!!'
                    ]);

                // return redirect()->route('scan.qr-code.invalid',$qrcode.'?check=departure')->withError('Code is already used!!');
            }
    
            if($code == 'save_arrival') {
                $encry_code = Crypt::encryptString($request->qr_code);
                $customer = $this->fetchCustomerDetails($encry_code);
                $data = [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'date' => $customer->date,
                ];
                $this->createUserGate($request);
                return response()->json([
                    'response' => 200,
                    'customer_data' => $data,
                    'message' => 'Verifed successfully !!!'
                ]);
                // return response()->json([
                //     'success' => 200,
                //     'message' => 'Verifed successfully !!!'
                // ]);
                // return redirect()->route('scan.qr-code.success',$qrcode)->withMessage('Verifed successfully !!!');
            }

            if($code == 'save_departure') {
                $encry_code = Crypt::encryptString($request->qr_code);
                $customer = $this->fetchCustomerDetails($encry_code);
                $data = [
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'date' => $customer->date,
                ];
                $this->createUserGate($request);
                return response()->json([
                    'response' => 200,
                    'customer_data' => $data,
                    'message' => 'Verifed successfully !!!'
                ]);
            
                // return redirect()->route('scan.qr-code.success',$qrcode.'?check=departure')->withMessage('Verifed successfully !!!');
            }
        }
        if(@$request->out_going_code == 'out_going_qr') {
            return response()->json([
                'response' => 400,
                'message' => 'Invalid Code!!!'
            ]);
            // return redirect()->route('scan.qr-code','check=departure')->withError('Invalid Code!!!');
        } else {
                return response()->json([
                    'response' => 400,
                    'message' => 'Invalid Code!!!'
                ]);
            // return redirect()->route('scan.qr-code')->withError('Invalid Code!!!');
        }

    }

    private function scanGroupQrCode($customer,$qr_code,$out_going_code) {
         //check if customer qr code exists
         $qr_codes = $customer->load('isVerifyQR');
         $pluck_customer_ticket_id = $qr_codes->isVerifyQR->pluck('customer_ticket_id');
         $customer_ticket_id = $pluck_customer_ticket_id['0'];

         //update in qr table where is verify is 1
         if($out_going_code == 'out_going_qr') {
                QR::where('customer_ticket_id',$customer_ticket_id)->update([
                    'is_verify_out' => '1',
                    'is_verify_out_date' => now()
                ]);

                Customer::where('main_qr_code',$qr_code)->update([
                    'is_verify_out' => '1',
                    'is_verify_out_date' => now()
                ]);
                return 'is_departure';
            }
            else 
            {
                QR::where('customer_ticket_id',$customer_ticket_id)->update([
                    'is_verify' => '1',
                    'is_verify_in_date' => now()
                ]);
                //update in customer table where is verify is 1
                Customer::where('main_qr_code',$qr_code)->update([
                    'is_verify' => '1',
                    'is_verify_in_date' => now()
                ]);
                return;
            }
    }

    /**
     * 
     */
    private function scanSingleQrCode($qr_code,$out_ticket) {
        $code = (int)$qr_code;
        $qr_code = QR::query();
            $get_qrcode = $qr_code->where('qr_code_no',$code)->first();
            if($out_ticket == 'out_going_qr') {
                //return back if the get qrcode is already 1
                if(@$get_qrcode->is_verify_out == '1') {
                    $data = 'is_departure';
                    return $data;
                }
    
                //update in qr table where is verify is 1
                QR::where('qr_code_no',$code)->update([
                    'is_verify_out' => '1',
                    'is_verify_out_date' => now()
                ]);
                $data = 'save_departure';
                return $data;
            } else {
                //return back if the get qrcode is already 1
                if(@$get_qrcode->is_verify == '1') {
                    $data = 'is_verify';
                    return $data;
                }
    
                //update in qr table where is verify is 1
                QR::where('qr_code_no',$code)->update([
                    'is_verify' => '1',
                    'is_verify_in_date' => now()
                ]);
                $data = 'save_arrival';
                return $data;
            }
    }

    public function fetchCustomerDetails($code) {
        $dyc_code = Crypt::decryptString($code);
        $customer = Customer::where('main_qr_code',$dyc_code)->first();
        if($customer == null) {
            $code = (int)$dyc_code;
            $qr_code = QR::query();
            $fetch_qr_code = $qr_code->where('qr_code_no',$code)->first();
            $get_customer = $fetch_qr_code->load('get_customer');
            $customer_id = $get_customer->get_customer->customer_id;
           return $customer = Customer::findOrFail($customer_id);
        }
        return $customer;
    }

    public function createUserGate($request) {
        $user_id = auth()->user()->id;

        UserGate::create([
            'user_id' => $user_id,
            'gate_no' => $request->gate_no,
            'qr_code' => $request->qr_code
        ]);
    }

    // public function scanQrCodeSuccess(Request $request,$code) {
    //     $departure = $request->check;
    //     $customer = $this->fetchCustomerDetails($code);
    //             $data = [
    //                 'name' => $customer->name,
    //                 'email' => $customer->email,
    //                 'phone' => $customer->phone,
    //                 'date' => $customer->date,
    //             ];
    //             return response()->json([
    //                 'response' => 200,
    //                 'customer_data' => $data,
    //                 'message' => '!!!'
    //             ]);
    //     // return response()->json([
    //     //     'success' => 400,
    //     //     'customer_data' => $customer,
    //     //     'message' => 'Invalid Code!!!'
    //     // ]);
    //     // return view('setting.qr.success',compact('customer','departure'));
    // }

    // public function scanQrCodeInvalid(Request $request, $code) {
    //     $departure = $request->check;
    //     $customer = $this->fetchCustomerDetails($code);
    //     $data = [
    //         'name' => $customer->name,
    //         'email' => $customer->email,
    //         'phone' => $customer->phone,
    //         'date' => $customer->date,
    //     ];
    //     return response()->json([
    //         'success' => 200,
    //         'customer_data' => $data,
    //         'message' => 'Invalid Code!!!'
    //     ]);
    //     // return view('setting.qr.invalid',compact('customer','departure'));
    // }

    
}
