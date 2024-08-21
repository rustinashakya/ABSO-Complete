<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethodModel;
use Illuminate\Http\Request;

class khaltiController extends Controller
{
    //
    function initiate($price, $id, $category,$email, $phone, $name ,$khalti_callback,$khalti_return)
    // function initiate()
    {
        // $price='1000.00';
        // $id='12';
        // $category='test';
        // $email='test@example.com';
        // $phone='9860021031';
        // $name='Test test';

    $payment_detail=PaymentMethodModel::where('payment_method','khalti')->first();
    // dd($payment_detail['state']);
      //  print_r($payment_event_detail); die;
      if($payment_detail['state'] == 'test'){
      // $khalti_payment_detail = decond
      $khatli_obj=json_decode($payment_detail['payment_detail']);
    //   dd($khatli_obj->{'khalti_initiate'});
      $khalti_initiate=$khatli_obj->{'khalti_initiate'};
      $khalti_lookup=$khatli_obj->{'khalti_lookup'};
    //   $khalti_callback=$khatli_obj->{'khalti_callback'};
    //   $khalti_return=$khatli_obj->{'khalti_return'};
      $authorization=$khatli_obj->{'authorization'};
    //   echo $khalti_initiate.'<br>'.$khalti_lookup.'<br>'.$khalti_callback.'<br>'.$khalti_return.'<br>'.$authorization.'<br>'; die;

    }
    else{
      $khatli_obj=json_decode($payment_detail['payment_detail_live']);
      $khalti_initiate=$khatli_obj->{'khalti_initiate'};
      $khalti_lookup=$khatli_obj->{'khalti_lookup'};
    //   $khalti_callback=$khatli_obj->{'khalti_callback'};
    //   $khalti_return=$khatli_obj->{'khalti_return'};
      $authorization=$khatli_obj->{'authorization'};
    }

        $curl = curl_init();
        curl_setopt_array($curl, array(
          // CURLOPT_URL => $khalti_initiate_test,
          //   "return_url": "'.$khalti_callback_live.'",
         // "website_url": "'.$khalti_return_live.'",
           ///https://a.khalti.com/api/v2/epayment/initiate/
          CURLOPT_URL => $khalti_initiate,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
          "return_url": "'.$khalti_callback.'",
          "website_url": "'.$khalti_return.'",
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
            'Authorization: '.$authorization,
            'Content-Type: application/json',
            'Cookie: TS012d70dd=016ebf70165b5d1445dccc6abac9cfce00b717282d563a667dc1725d1e3d0f58aa54481dfaa3d38cf7944e533646f7dda240bdf74095387d63842e8d3e18fccdc112b0efbe; TS012d70dd028=0123ed5072b9fc178fb4ae00b366ef34e6d842ca7561f84d6e6a584b6f3e13ad33038070f1c041609b35d7aec799ffbeefa591f47b; sessioncookie=!g9QWVa4Tofqnc5tf4UWs1OM+gHbca2nga1wlfJ5oeNlPzw0K3MhDgQWu7SYlIBnpAmONXsq5L+nm740='
          ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        return $response;

    }
    function lookup($pidx){
      //'Authorization: Key live_secret_key_636ca1da2ae64874b9869269b1da9b7b',
      $payment_event_detail=PaymentMethodModel::where('payment_method','khalti')->first();
      //  print_r($payment_event_detail); die;
      if($payment_event_detail['state'] == 'test'){
      // $khalti_payment_detail = decond
      $khatli_obj=json_decode($payment_event_detail['payment_detail']);
      $khalti_initiate=$khatli_obj->{'khalti_initiate'};
      $khalti_lookup=$khatli_obj->{'khalti_lookup'};
      $khalti_callback=$khatli_obj->{'khalti_callback'};
      $khalti_return=$khatli_obj->{'khalti_return'};
      $authorization=$khatli_obj->{'authorization'};
      // echo $khalti_initiate.'<br>'.$khalti_lookup.'<br>'.$khalti_callback.'<br>'.$khalti_return.'<br>'.$authorization.'<br>'; die;

    }else{
      $khatli_obj=json_decode($payment_event_detail['payment_detail_live']);
      $khalti_initiate=$khatli_obj->{'khalti_initiate'};
      $khalti_lookup=$khatli_obj->{'khalti_lookup'};
      $khalti_callback=$khatli_obj->{'khalti_callback'};
      $khalti_return=$khatli_obj->{'khalti_return'};
      $authorization=$khatli_obj->{'authorization'};
    }

      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => $khalti_lookup,
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
          'Authorization: '.$authorization,
          'Content-Type: application/json',
          'Cookie: TS012d70dd=016ebf7016588cebee1eb39e4237866d76dbe8a644a5fb27c62571a63d0f477d624c68af7e253535e8aa84cb3a7a8f0caa70c4f87eb900dc11eb3e1ada3f8fd3feeae06b87; TS012d70dd028=0123ed5072b9fc178fb4ae00b366ef34e6d842ca7561f84d6e6a584b6f3e13ad33038070f1c041609b35d7aec799ffbeefa591f47b; sessioncookie=!g9QWVa4Tofqnc5tf4UWs1OM+gHbca2nga1wlfJ5oeNlPzw0K3MhDgQWu7SYlIBnpAmONXsq5L+nm740='
        ),
      ));

      $response = curl_exec($curl);

      curl_close($curl);
      return $response;


    }
}
