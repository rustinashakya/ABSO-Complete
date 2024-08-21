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

class ScheduleDayController extends Controller
{
    public function index($id){

        $schedules = Schedule_day::where('month_id',$id)->latest()->Paginate(10);
        $parent_nav = 'publication';
        $child_nav= 'schedule';
        return view('schedule_day.index',compact('schedules', 'parent_nav', 'child_nav','id'));
   }

    public function add($id){
        $parent_nav = 'publication';
        $child_nav= 'schedule';
        $month=Schedule_month::get();
        // dd($month);
        return view('schedule_day.add',compact('parent_nav','child_nav','month','id'));
    }

    public function store(Request $request,$id) {
        // dd($request->all());
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                    'month' => 'required',
                    'day' => 'required|integer|max:32',
                    'title' => 'required|string',
                    'description' => 'required|string',
                    // 'order_by' => 'required|integer|unique:Schedule_day,order_by',

            ],$message = [
                'title.required' => 'Title field is required.',
                'day.required' => 'Day field is required',
                'day.integer' => 'Day field must be a number',
                'day.max' => 'Max day is 32',
                'description.required' => 'Description field is required',
                'month' => 'Month field is required',
                'month.unique' => 'Month already exist',
                // 'order_by' => 'Order by field is required',
                // 'order_by.unique' => 'Order by already exist',
            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }

            $schedule = new Schedule_day();
            $schedule->month_id = $request->month;
            $schedule->name = $request->day;
            $schedule->title = $request->title;
            $schedule->description = $request->description;
            $schedule->meta_description = $request->meta_description;
            $schedule->meta_keyword = $request->meta_keyword;
            $schedule->save();
            $message = 'Month Created !!!';

            return redirect()->route('schedule_day.index',$id)->withSuccess('Month Created !!!')->withMessage($message);
            }
            catch (\Throwable $th) {
                throw $th;
            }
    }

    public function view($id){
        $schedule = Schedule_day::findOrFail($id);
        return view('schedule_day.view',compact('schedule'));
    }

    public function edit($month_id,$id){
        $parent_nav = 'publication';
        $child_nav= 'schedule';
        $month=Schedule_month::get();
        $schedule = Schedule_day::findOrFail($id);
        // dd($schedule);/
        return view('schedule_day.edit',compact('schedule','parent_nav','child_nav','month_id','month'));
    }

    public function update(Request $request,$month_id,$id) {
        // dd($request->all());
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'month' => 'required',
                'day' => 'required|integer|max:32',
                'title' => 'required|string',
                'description' => 'required|string',
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

            Schedule_day::where('id', $id)->update([
                'month_id' => $request->month,
                'name' => $request->day,
                'title' => $request->title,
                'description' => $request->description,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);

            $message = 'Schedule Month Updated !!!';

            return redirect()->route('schedule_day.index',['month_id'=>$month_id])->withSuccess('Schedule Day Update !!!')->withMessage($message);
        }
            catch (\Throwable $th) {
                throw $th;
            }

        }
    public function delete($month_id,$id){
        $schedule = Schedule_day::findOrFail($id);
        $schedule->delete();
        $message = 'schedule Delete Successfully';
        return redirect()->back()->withSuccess('Category Delete !!!')->withMessage($message);
    }

 }
