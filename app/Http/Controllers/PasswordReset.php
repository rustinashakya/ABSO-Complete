<?php

namespace App\Http\Controllers;

use App\Models\UserRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PasswordReset extends Controller
{
    /**
     *
     * @method to reset password
     * @author roshan
     */
    public function reset_password($token,$email){
        if($token==null && $email==null){
            echo "Invalid Request";
        }
        $check_token=UserRegistration::where('email',$email)->where('token',$token)->first();
        if($check_token!=null){

            // $this->authentication_model->activate($otp,$email);  //changes status of user in users table

            // $this->authentication_model->accept_user_in_invitation($invitation_id);  //changes status of user in invitation table  Pending to accepted
            // //echo "Activation Successful!";



            if($check_token['password'] == null){
                $user_uuid=$check_token['id'];
                return view('resetpassword.reset',compact('user_uuid'));

            }else{
                $url = 'https://https://apihope.innepal.biz'; // Replace this with your desired URL
                return Redirect::to($url);
            }

        }else{
            echo "Invalid Token!";
        }

      }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function reset_password_post(Request $request,$user_id)
    {
        //


            $rule = [
                'new_password' => 'required|min:8',
                'confirm_password' => 'required|same:new_password',
            ];

            $validator = Validator::make( $request->all(), $rule,[
                'new_password.required' => __('New password is required'),
                'new_password.different' => __('New password must be different'),
                // 'new_password.regex' => __('auth.validator.password_regex'),
                'new_password.min' => __('At least 8 digit is required'),
                'confirm_password.same' => __('Confirm password must be same'),
                'confirm_password.required' => __('Confirm password is required'),
            ]);
            if ($validator->fails()) {
                // return back()
                //       ->withErrors($validator)
                //       ->withInput();
                      return back()
                ->withErrors($validator)
                ->withInput();
            }
            UserRegistration::where('id',$user_id)->update(['status'=>'active','password' => Hash::make($request->new_password)]);
            // return redirect()->back()->with('pwd_changed', 'Your password has been changed!');
            return redirect(url('success'));


    }

    /**
     * Display the specified resource.
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function success(Request $request)
    {
        // $token=$request->get('token');
        // if($token==null){

        //    echo 'Invalid Url';
        // }else{

            return view('resetpassword.successpage');
        // }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
