<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Spatie\Permission\Models\Permission;



class PermissionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        $this->middleware('role_or_permission:Permission access|Permission create|Permission edit|Permission delete', ['only' => ['index','show']]);
        $this->middleware('role_or_permission:Permission create', ['only' => ['create','store']]);
        $this->middleware('role_or_permission:Permission edit', ['only' => ['edit','update']]);
        $this->middleware('role_or_permission:Permission delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permission= Permission::latest()->paginate();
        $parent_nav = 'settings';
        $child_nav = 'perm';
        return view('setting.permission.index',['permissions'=>$permission], compact('parent_nav','child_nav')); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent_nav = 'settings';
        $child_nav = 'perm';
        return view('setting.permission.new', compact('parent_nav','child_nav'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validation
        $request->validate([
            'name'=>'required',
        ],$message = [
            'name' => 'Name field is required'
        ]);
        $message = 'Permission Created Successfully.';
        $permission = Permission::create(['name'=>$request->name]);
        return redirect()->back()->withMessage($message);
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
    public function edit(Permission $permission)
    {
        $parent_nav = 'settings';
        $child_nav = 'perm';
        return view('setting.permission.edit',['permission' => $permission], compact('parent_nav','child_nav'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name'=>'required',
        ],$message = [
            'name' => 'Name field is required'
        ]);
        $message = 'Permission Updated Succssfully.';
        $permission->update(['name'=>$request->name]);
        return redirect()->back()->withMessage($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        $permission->delete();
        $message = 'Permission Deleted Successfully.';
        return redirect()->back()->withMessage($message);
    }
}