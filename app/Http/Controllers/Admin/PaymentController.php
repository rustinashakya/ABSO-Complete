<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    
//http://localhost/nra-website/khalti-callback //local return url
//https://innepal.biz/nis2022/khalti-callback //live return url
//http://localhost/nra-website/ //local website
//https://innepal.biz/nis2022/  //live website
//https://khalti.com/api/v2/  //live end point
// $config['khalti_initiate_test']= 'https://a.khalti.com/api/v2/epayment/initiate/';
// $config['khalti_callback_live']='https://innepal.biz/nis2022/khalti-callback ';
// $config['khalti_return_live']='https://innepal.biz/nis2022/ ';
// $config['khalti_return_live']='https://a.khalti.com/api/v2/epayment/lookup/';
public function initiate($price, $id, $category,$email, $phone, $name)
{
    // dd(1);
//   $CI = get_instance();
//   $CI->config->load('nra_config',TRUE); 
//   $khalti_initiate_test = $CI->config->item('khalti_initiate_test', 'nra_config');
//   $khalti_callback_live = $CI->config->item('khalti_callback_live', 'nra_config');
//   $khalti_return_live = $CI->config->item('khalti_return_live', 'nra_config');
//   $Khalti_lookup = $CI->config->item('Khalti_lookup_test', 'nra_config');
  // $khalti_url = $CI->config->item('khalti_initiate_test', 'nra_config');
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/initiate/',   ///https://a.khalti.com/api/v2/epayment/initiate/
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
      "return_url": "'.url('payment.success').'",
      "website_url": "'.url('payment.success').'",
      "amount":"'.$price.'",
      "purchase_order_id": "'.$id.'",
      "purchase_order_name": "'.$category.'",
      "customer_info": {
          "name": "'.$name.'",
          "email": "'.$email.'",
          "phone": "'.$phone.'"
      }
    }',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Key live_secret_key_636ca1da2ae64874b9869269b1da9b7b',
        'Content-Type: application/json',
        'Cookie: TS012d70dd=016ebf70165b5d1445dccc6abac9cfce00b717282d563a667dc1725d1e3d0f58aa54481dfaa3d38cf7944e533646f7dda240bdf74095387d63842e8d3e18fccdc112b0efbe; TS012d70dd028=0123ed5072b9fc178fb4ae00b366ef34e6d842ca7561f84d6e6a584b6f3e13ad33038070f1c041609b35d7aec799ffbeefa591f47b; sessioncookie=!g9QWVa4Tofqnc5tf4UWs1OM+gHbca2nga1wlfJ5oeNlPzw0K3MhDgQWu7SYlIBnpAmONXsq5L+nm740='
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);

    $data = json_decode($response);

    return redirect($data->payment_url);

    return $response;
    
}

public function lookup($pidx){

  $curl = curl_init();
  
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://a.khalti.com/api/v2/epayment/lookup/',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS =>'{
    "pidx": "'.$pidx.'"
  }',
    CURLOPT_HTTPHEADER => array(
      'Authorization: Key live_secret_key_636ca1da2ae64874b9869269b1da9b7b',
      'Content-Type: application/json',
      'Cookie: TS012d70dd=016ebf7016588cebee1eb39e4237866d76dbe8a644a5fb27c62571a63d0f477d624c68af7e253535e8aa84cb3a7a8f0caa70c4f87eb900dc11eb3e1ada3f8fd3feeae06b87; TS012d70dd028=0123ed5072b9fc178fb4ae00b366ef34e6d842ca7561f84d6e6a584b6f3e13ad33038070f1c041609b35d7aec799ffbeefa591f47b; sessioncookie=!g9QWVa4Tofqnc5tf4UWs1OM+gHbca2nga1wlfJ5oeNlPzw0K3MhDgQWu7SYlIBnpAmONXsq5L+nm740='
    ),
  ));
  
  $response = curl_exec($curl);
  
  curl_close($curl);
  return $response;
  

}

// public function paymentAcknowledgement(Request $request){
//     $ap = $this->application->find($request->input('application'));

//     try {
//         $app_data = [
//             'registration'=>$this->RandStr($ap['test_level']),
//             'status'=>1
//         ];
//         $ap->update($app_data);
//     } catch (Exception $e) {
//       //  Mail::to(['abinrinal7@gmail.com','kisnapd@gmail.com'])->send(new MailableClass);
//         //sleep for 5 seconds
//         sleep(5);
//         return redirect()->back()->with('flash_notice','Failed!! Please Try Again for the payment');
//     }

//     $args = http_build_query(array(
//         'token'=>$request->input('token'),
//         'amount'=>$request->input('amount')
//     ));
    
//     $url = "https://khalti.com/api/v2/payment/verify/";
    
//     # Make the call using API.
//     $ch = curl_init();
//     curl_setopt($ch, CURLOPT_URL, $url);
//     curl_setopt($ch, CURLOPT_POST, 1);
//     curl_setopt($ch, CURLOPT_POSTFIELDS,$args);
//     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
//     $headers = ['Authorization: Key live_secret_key_34565ace47fa46fea4c484c63190ffc9'];
//     curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
//     // Response
//     $response = curl_exec($ch);
//     $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
//     curl_close($ch);

//     $payment_data = [
//         'user_id'=>Auth::user()->id,
//         'application_id'=>$request->input('application'),
//         'test_id'=>$request->input('test'),
//         'mode'=>$request->input('input-payment'),
//         'amount'=>($request->input('amount')/100),
//         'transaction_no'=>Auth::user()->id.$request->input('application').$request->input('test').rand(10000,99999),
//         'token'=>$request->input('token'),
//         'payment_id'=>$request->input('idx'),
//         'widget_id'=>$request->input('widget_id'),
//         'status'=>1
//     ];          
//     $this->payment->create($payment_data);

//     //mail function
//     $thisUser = User::findorFail(Auth::user()->id); //find userId to send mail
//     dispatch(new PaymentSuccessEmail($thisUser)); //send mail through queue
    
//     $data = $this->application->where('user_id','=',Auth::user()->id)->get();
//     $data[1]=['payment'=>$payment_data['transaction_no']];        
//     return view('user.payment-success')->with(compact('data'));
// }

}
