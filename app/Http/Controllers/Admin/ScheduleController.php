<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Schedule_day;
use App\Models\Schedule_month;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    public function index(){

        $schedules = Schedule_month::latest()->Paginate(10);
        $parent_nav = 'publication';
        $child_nav= 'schedule';
        return view('schedule.index',compact('schedules', 'parent_nav', 'child_nav'));
   }

    public function add(){
        $parent_nav = 'publication';
        $child_nav= 'schedule';
        return view('schedule.add',compact('parent_nav','child_nav'));
    }

    public function store(Request $request) {
        // dd($request);
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                    'month' => 'required|string|unique:schedule_month,month_name',
                    'order_by' => 'required|integer|unique:schedule_month,order_by',

            ],$message = [
                'month' => 'Month field is required',
                'month.unique' => 'Month already exist',
                'order_by' => 'Order by field is required',
                'order_by.unique' => 'Order by already exist',
            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }

            $schedule = new Schedule_month();
            $schedule->month_name = $request->month;
            $schedule->order_by = $request->order_by;
            $schedule->save();
            $message = 'Month Created !!!';

            return redirect()->route('schedule.index')->withSuccess('Month Created !!!')->withMessage($message);
            }
            catch (\Throwable $th) {
                throw $th;
            }
    }

    public function view($id){
        $schedule = Schedule_day::findOrFail($id);
        return view('schedule.view',compact('schedule'));
    }

    public function edit($id){
        $parent_nav = 'publication';
        $child_nav= 'schedule';
        $schedule = Schedule_month::findOrFail($id);
        // dd($schedule);/
        return view('schedule.edit',compact('schedule','parent_nav','child_nav'));
    }

    public function update(Request $request,$id) {
        // dd($request->all());
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
            'month' => ['required', Rule::unique('schedule_month', 'month_name')->ignore($id)],
            'order_by' => ['required', Rule::unique('schedule_month', 'order_by')->ignore($id)],
            ],$message = [
                'month' => 'Month field is required',
                'month.unique' => 'Month already exist',
                'order_by' => 'Order by field is required',
                'order_by.unique' => 'Order by already exist',
            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }
            // die();
            // $db_schedule = Schedule_day::findOrFail($id);

            Schedule_month::where('id', $id)->update([
                'month_name' => $request->month,
                'order_by' => $request->order_by,
            ]);

            $message = 'Schedule Month Updated !!!';

            return redirect()->route('schedule.index')->withSuccess('Schedule Month Update !!!')->withMessage($message);
        }
            catch (\Throwable $th) {
                throw $th;
            }

        }
    public function delete($id){
        $schedule = Schedule_month::findOrFail($id);
        $schedule->delete();
        $message = 'Schedule Delete Successfully';
        return redirect()->back()->withSuccess('Schedule Deleted !!!')->withMessage($message);
    }

 }
