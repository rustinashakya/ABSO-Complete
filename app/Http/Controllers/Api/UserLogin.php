<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentOptionModel;
use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use DB;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Throwable;

class UserLogin extends Controller
{
    //
    /**
     * @method to get payment by country id
     * @author roshan
     */

     public function get_payment_by_country_id(Request $request,$country_id){
        $payment_detail=PaymentOptionModel::select('id','country_name','country_id','payment_method','icon_url')->where('country_id',$country_id)->get();
        if(count($payment_detail)>0){
            return response()->json([
                'status'=>true,
                'message'=>'Payment Detail Fetched Successfully',
                'payment_detail'=>$payment_detail
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>'Failed to fetch',
            ],500);
        }
     }


     /**
      * @method to login 
      */
      public function login_user(Request $request){
        // dd($request->all());
        try{
            $email=$request->post('email');
            $password=$request->post('password');
            $rule= [
                'email' => 'required|email|exists:usertbl',
                'password' => 'required',
            ];
    
            $validator = Validator::make( $request->all(), $rule,[
                'email.required' => __('auth.validator.email_required'),
                'email.email' =>  __('auth.validator.email_validate'),
                'email.exists' =>  __('auth.validator.email_exists'),
                'password.required' => __('auth.validator.password_reqired'),
            ]);
    // dd($email);
            $user = UserRegistration::where('email',$email)->first();
            // dd($user);
    
            if(empty($user->email))
            {
                return response()->json([
                    'status'=>false,
                    'message' => 'Username or password incorrect'], 400);
            }
    
            if (hash_equals($user->password, crypt($password, $user->password))) {
    
                $expirationTime = Carbon::now()->addDay()->timestamp;
                $country_name= DB::table('countries')->where('id', $user['country_id'])->first();
                $state_name= DB::table('states')->where('id', $user['state_id'])->first();
                // dd($state_name);
                $user_detail=[
                    'id'=>$user['id'],
                    'full_name'=>$user['full_name'],
                    'email'=>$user['email'],
                    'sex'=>$user['sex'],
                    'religion'=>$user['religion'],
                    'phone'=>$user['phone'],
                    'country_id'=>$user['country_id'],
                    'country_name'=>$country_name->name,
                    'state_name'=>$state_name->name,
                    'state_id'=>$user['state_id'],
                    'city'=>$user['city'],
                    'street'=>$user['street'],
                    'zip_code'=>$user['zip_code'],
                    'status'=>$user['status'],
                ];
                // $user_detail;
                $token =  JWTAuth::fromUser($user, [ 'exp' => $expirationTime]);
                $user->jwt_token = $token;
                $user->save();
             }else{
                return response()->json([
                'status'=>false,
                'message' => 'Password Incorrect'], 400);
             }
    
            return response()->json([
                'status'=>true,
                'token'=>$token,
                'user_detail'=> $user_detail
            ],200);
        


        }catch(\Throwable $e){
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Failed to check',
                    'error'=>$e->getMessage(),
                ],
                500,
            );
        }
      }

    
}
