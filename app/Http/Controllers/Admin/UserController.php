<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;



class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:User access|User create|User edit|User delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:User create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:User edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:User delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user= User::latest()->paginate();
        $parent_nav = 'settings';
        $child_nav = 'user';
        return view('setting.user.index',['users'=>$user], compact('parent_nav', 'child_nav'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_nav = 'settings';
        $child_nav = 'user';
        $roles = Role::get();
        return view('setting.user.new',['roles'=>$roles], compact('parent_nav', 'child_nav'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:users',
            'password'=>'required|confirmed'
        ]);
        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> bcrypt($request->password),
        ]);
        $user->syncRoles($request->roles);
        $message = 'User Added Successfully.';
        return redirect()->route('admin.users.index')->withMessage($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $role = Role::get();
        $user->roles;
        $parent_nav = 'settings';
        $child_nav = 'user';
       return view('setting.user.edit',['user'=>$user,'roles' => $role],compact('parent_nav', 'child_nav'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'=>'required',
            'email' => 'required|email|unique:users,email,'.$user->id.',id',
        ]);

        if($request->password != null){
            $request->validate([
                'password' => 'required|confirmed'
            ]);
            $validated['password'] = bcrypt($request->password);
        }

        $user->update($validated);

        $user->syncRoles($request->roles);
        $message = 'User Updated Successfully.';

        return redirect()->route('admin.users.index')->withMessage($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $message = 'User Deleted Successfully.';
        $user->delete();
        return redirect()->back()->withMessage($message);
    }

    public function changePassword() {
        return view('admin.change-password');
    }

    public function updateChangePassword(Request $request)
    {
        try{

            $rule = [
                'old_password' => 'required',
                'new_password' => 'required|min:8|different:old_password',
                'confirm_password' => 'required|same:new_password',
            ];

            $validator = Validator::make( $request->all(), $rule,[
                'old_password.required' => __('Old password is required'),
                'new_password.required' => __('New password is required'),
                'new_password.different' => __('New password must be different'),
                // 'new_password.regex' => __('auth.validator.password_regex'),
                'new_password.min' => __('At least 8 digit is required'),
                'confirm_password.same' => __('Confirm password must be same'),
                'confirm_password.required' => __('Confirm password is required'),
            ]);
            if ($validator->fails()) {
                return back()
                      ->withErrors($validator)
                      ->withInput();
            }
            try {
                if ((Hash::check( $request->old_password, Auth::user()->password)) == false) {
                    return redirect()->back()->with('message', 'Incorrect email or password provided.');
                } else {
                    User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->new_password)]);
                    return redirect()->back()->with('pwd_changed', 'Your password has been changed!');
                }
            } catch (\Exception $ex) {
                // if (isset($ex->errorInfo[2])) {
                //     $msg = $ex->errorInfo[2];
                // } else {
                //     $msg = $ex->getMessage();
                // }
                return redirect()->back()->with('pwd_changed', 'Your password has been changed!');
            }
        } catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()],401);
        }
    }
}