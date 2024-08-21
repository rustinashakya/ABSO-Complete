<?php

namespace App\Http\Controllers\Admin;

// use Illuminate\Http\Response;
use Monolog\Logger;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Monolog\Handler\StreamHandler;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateRegistrationNumber;
require_once(app_path('Helpers/TicketLog.php'));

class KhaltiController extends Controller
{
    private $logger;
    private $khaltiCreds = [];

    public function __construct(Request $request)
    {
        // Log::channel('monolog')->info('Hello, Monolog!');
        // Log::channel('monolog')->error('Something went wrong.');
        $log_path = storage_path() . '/logs/khalti/' . date('Y-m-d') . '.log';

        $this->logger = new Logger('Khalti LOG :'.date('Y-d-m H:i:s'));
        $this->logger->pushHandler(new StreamHandler($log_path, Logger::INFO));

        //Testing Environment
        // $this->khaltiCreds['endpoint'] = 'https://a.khalti.com/api/v2';
        // $this->khaltiCreds['secretKey'] = 'live_secret_key_bf81eef16d0942d68362c1221ff04693';

        //Live Khalti
        $this->khaltiCreds['endpoint'] = 'https://a.khalti.com/api/v2';
        $this->khaltiCreds['secretKey'] = 'live_secret_key_636ca1da2ae64874b9869269b1da9b7b';
    }

    public function khaltiPayment(Request $request)
    {
        try {
            $orderId = time(); // unique hamro transaction id
            $transactionID = $request->transaction_id;

            //update into transaction table --pachi khaltiResponse function ma use garna
            Transaction::where('id',$transactionID)->update([
                'transaction_no' => $orderId,
                'redirect_to' => $request->redirect_to,
                'transaction_timestamp' => now()
            ]);
            //totalprice - discount
            $ticketAmount = (int)$request->totalPrice;// in RS
            $vatAmount = (int)$request->totalVat;
            $totalAmount = $ticketAmount + $vatAmount;
            
            $orderName = 'Buy Tickets';
            
            $paymentParams = [
                // 'website_url' => 'http://siddharthacablecar.com',  // hamro website url
                // 'return_url' => 'http://siddharthacablecar.com/khalti-v2/khaltiResponse', // hamro return url khalti bata redirect hune after payment
                'website_url' => 'http://127.0.0.1:8000',
                'return_url' => 'http://127.0.0.1:8000/khalti-v2/khaltiResponse',
                'amount' => $totalAmount * 100, // in Paisa
                'purchase_order_id' => $orderId,
                'purchase_order_name' => $orderName,
                'customer_info' => [
                    'name' => $request->name,
                    'email' => $request->email ?? 'ajaymrzn02@gmail.com',
                    'phone' => $request->phone ?? '9843690374',
                    'date' => $request->date,
                ],
                'amount_breakdown' => [
                    [
                        'label' => 'Total Price',
                        'amount' => $ticketAmount * 100,
                    ],
                    [
                        "label" => "VAT",
                        "amount" => $vatAmount * 100,
                    ]
                ]
            ];

            $paymentInitializeStatus = $this->paymentInitialize($paymentParams);
            // dd($paymentInitializeStatus);
            if( !$paymentInitializeStatus ) {
                return redirect()->back()->with('error','Failed!! Please Try Again for the payment'); // handle failure
            }

            if ( !isset($paymentInitializeStatus->pidx) || !isset($paymentInitializeStatus->payment_url) ) {
                return redirect()->back()->with('error','Failed!! Please Try Again for the payment'); // handle failure
            }

            //log event params using helper method log_event
            log_event('info','customer_payment_information',json_encode($paymentParams));

            /*   {
                   "pidx": "S8QJg2VALZGTJRkKqVxjqB",
                   "payment_url": "https://test-pay.khalti.com/?pidx=S8QJg2VALZGTJRkKqVxjqB/"
                 }*/

            $pidx = $paymentInitializeStatus->pidx; // store in database
            
            $paymentURL = $paymentInitializeStatus->payment_url; // yesma redirect garne aaba
            // dd($paymentURL);
            return response()->json([
                'status' => 200,
                'paymentURL' => $paymentURL,
            ]);
            // return redirect()->away($paymentURL);

        } catch (\Exception $e) {
            log_event('error','customer_payment',json_encode($e));
            dd($e);
        }

    }

    public function khaltiResponse(Request $request) // should be get url
    {
        try {
            // yesari redirect huncha hamro ma
           // https://example.com/payment?pidx=EwGKrbdaYLTQ4rmWtNAMEJ
           // &amount=1300
           // &mobile=98XXXXX403
           // &purchase_order_id=test12
           // &purchase_order_name=test
           // &transaction_id=MJbBJDKYziWqgvkgjxhS2W
           log_event('info','KHALTI RESPONSE',json_encode($request->toArray()));

            if ( !isset($request['pidx']) ) {
                return redirect()->route('khalti.payment')->with('error','Failed!! Please Try Again for the payment'); 
                // url ma pidx set chaina vane we can assume payment failed  
            }
            
            $pidx = $request['pidx'];
            
            // aaba hamro server to khalti ko server transaction verify garne and if success balla hamro end ma further kaam garne
            $verificationPayload = [
                'pidx' => $pidx
            ];
            $paymentStatus = $this->verifyKhaltiTransaction($verificationPayload);
            
            if ( !$paymentStatus ) {
                return redirect()->route('khalti.payment')->with('error','Failed!! Please Try Again for the payment');
            }

            /*{
                "pidx": "HT6o6PEZRWFJ5ygavzHWd5",
                "total_amount": 1000,
                "status": "Completed",
                "transaction_id": "GFq9PFS7b2iYvL8Lir9oXe",
                "fee": 0,
                "refunded": false
            }*/

            if ( !isset($paymentStatus->status) || $paymentStatus->status != 'Completed' ) {
                return redirect()->route('khalti.payment')->with('error','Failed!! Please Try Again for the payment'); // handle failure
            }

            // payment success yaha pugnu bhaneko,, further process continue garne
            $paymentCustomerTransaction = Transaction::query();

            $transactionDate = $paymentCustomerTransaction
                ->where('transaction_no',$request->purchase_order_id)
                ->update([
                'payment_method'=>'Khalti',
                'amount'=> $paymentStatus->total_amount,
                'token'=> $paymentStatus->transaction_id,
                'payment_id'=> $paymentStatus->pidx,
                'widget_id'=> $paymentStatus->pidx,
                'payment_timestamp'=> now(),
                'status'=> 1
            ]);

            $transaction = $paymentCustomerTransaction->where('transaction_no',$request->purchase_order_id)->first();
            
            if ( !isset($transactionDate )) {
                return redirect()->route('khalti.payment')->with('error','Failed!! Please Try Again for the payment');
            }
            $customerID = encrypt($transaction->customer_id);
            //mail function
            // $thisUser = User::findorFail(Auth::user()->id); //find userId to send mail
            // dispatch(new PaymentSuccessEmail($thisUser)); //send mail through queue
            return redirect()->route('payment.success',['customer_id' => $customerID,'is_admin' => $transaction->redirect_to,'status' => 'completed','total_amount' => $transaction->amount])
                ->withMessage('Payment Successful');

        } catch (\Exception $e) {
            log_event('error','KHALTI RESPONSE',json_encode($e));
            dd($e);

        }
    }

    private function paymentInitialize($paymentParams)
    {
        try {

            // log ma write gareko for reference and debug and reconcilation
            // $this->logger->info("Payment Initialize Request :" . json_encode($paymentParams));

            $paymentInitEndpoint = $this->khaltiCreds['endpoint'] . "/epayment/initiate/";

            $headerParams = array(
                'Content-Type: application/json',
                'Authorization: Key ' . $this->khaltiCreds['secretKey'],
            );

            $curlConnection = curl_init($paymentInitEndpoint);

            curl_setopt($curlConnection, CURLOPT_HTTPHEADER, $headerParams);
            curl_setopt($curlConnection, CURLOPT_HEADER, 0);
            curl_setopt($curlConnection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curlConnection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, 1);

            curl_setopt($curlConnection, CURLOPT_POSTFIELDS, json_encode($paymentParams));

            $result = curl_exec($curlConnection);
            // $this->logger->info("Payment Initialize Response :" . $result);
            curl_close($curlConnection);
            return $result ? json_decode($result) : null;

        } catch (\Exception $e) {
            log_event('error','Payment Initialize',json_encode($e));
            dd($e);

        }
    }

    private function verifyKhaltiTransaction($verificationPayload)
    {
        try {

            // log ma write gareko for reference and debug and reconcilation
            // $this->logger->info("Payment Verification (Lookup) Reqeust :" . $verificationPayload['pidx']);

            $paymentLookUpEndpoint = $this->khaltiCreds['endpoint'] . "/epayment/lookup/";

            $headerParams = array(
                'Content-Type: application/json',
                'Authorization: Key ' . $this->khaltiCreds['secretKey'],
            );

            $curlConnection = curl_init($paymentLookUpEndpoint);

            curl_setopt($curlConnection, CURLOPT_HTTPHEADER, $headerParams);
            curl_setopt($curlConnection, CURLOPT_HEADER, 0);
            curl_setopt($curlConnection, CURLOPT_CONNECTTIMEOUT, 30);
            curl_setopt($curlConnection, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1)");
            curl_setopt($curlConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curlConnection, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curlConnection, CURLOPT_FOLLOWLOCATION, 1);

            curl_setopt($curlConnection, CURLOPT_POSTFIELDS, json_encode($verificationPayload));

            $result = curl_exec($curlConnection);

            // $this->logger->info("Payment Verification (Lookup) Response :" . $result);

            curl_close($curlConnection);
            
            return $result ? json_decode($result) : null;

        } catch (\Exception $e) {
            log_event('error','Verify Khalti Transaction',json_encode($e));
            dd($e);

        }
    }

     /**
     * Generate a random number
     *
     * @return \Illuminate\Http\Response
     */
    // private function RandStr($id){
    //     // $job = new GenerateRegistrationNumber($id);
    //     $data = $this->dispatch($job);
    //     return $data;      
    // }
}
