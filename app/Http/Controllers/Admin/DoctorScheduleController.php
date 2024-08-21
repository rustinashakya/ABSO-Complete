<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\DoctorSchedule;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;

class DoctorScheduleController extends Controller
{
    public function index(Request $request){

        $search_param=array(
            'doctor_id'=>$request->get('doctor_id'),
            'date'=>$request->get('date'),
           
        );
        $DoctorSchedule = DoctorSchedule::with('team')
                        ->where('is_deleted', 0)
                        ->when($request->get('doctor_id'),function($q) use ($request) {
                            $q->where('doctor_schedule.team_id', $request->get('doctor_id'));
                        })
                        ->when($request->get('date'),function($q) use ($request) {
                            $q->where('doctor_schedule.date', $request->get('date'));
                        })
                        ->orderBy('date','DESC')
                        ->orderBy('start_time','DESC')
                        ->Paginate(25);
        $parent_nav = 'doctor_schedule';
        $child_nav= 'doctor_schedule';
        $doctor_detail=Team::get();
        $DoctorSchedule->appends($request->all());
        return view('doctor_schedule.index',compact('DoctorSchedule', 'parent_nav', 'child_nav','search_param','doctor_detail'));
   }

    public function add(){
        $parent_nav = 'doctor_schedule';
        $child_nav= 'doctor_schedule';
        $team=Team::where('status','active')->get();
        $month=DoctorSchedule::get();
        // dd($month);
        return view('doctor_schedule.add',compact('parent_nav','child_nav','month','team'));
    }

    public function store(Request $request) {
        // dd($request->all());
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                    'team' => 'required',
                    'date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
                    'time' => ['required', 'date_format:H:i'],
                    'duration' => 'required|numeric|min:30|max:480',

            ],$message = [
                'team.required' => 'Team field is required.',
                'date.required' => 'Date field is required',
                // 'date.after_or_equal' => 'Date field must be after or equal to today ',
                'time.required' => 'Time field is required',
                'time.after_or_equal' => 'Time field must be after or equal to present time',
                'duration.required' => 'Duration field is required',
            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }

            $DoctorSchedule=DoctorSchedule::where('team_id',$data['team'])->where('date',$data['date'])->get();
            // dd($DoctorSchedule);
            foreach($DoctorSchedule as $ds){
                $existingStartTime = $ds->start_time;
                $existingEndTime = Carbon::parse($ds->start_time)->addMinutes($ds->duration_in_minutes);
                $existingEndTime = $existingEndTime->format('H:i:s');

                $requestedStartTime = $request->time;
                $requestedStartTime = $requestedStartTime.':00';
                $requestedEndTime = Carbon::parse($request->time)->addMinutes($request->duration);
                $requestedEndTime = $requestedEndTime->format('H:i:s');
                // dd($existingEndTime,$existingStartTime,$requestedStartTime,$requestedEndTime);

                // Check for overlap
                if (($requestedStartTime >= $existingStartTime && $requestedStartTime < $existingEndTime)
                || ($requestedEndTime > $existingStartTime && $requestedEndTime <= $existingEndTime))

             {
                return redirect()->back()->withError('Overlap detected with an existing record.')->withInput();
                }
                // if ($requestedStartTime >= $existingStartTime && $requestedStartTime < $existingEndTime) {
                // }
            }
            $schedule = new DoctorSchedule();
            $schedule->team_id = $request->team;
            $schedule->date = $request->date;
            $schedule->start_time = $request->time;
            $schedule->duration_in_minutes = $request->duration;
            $schedule->save();
            $message = 'Doctor Schedule Added Successfully!';

            return redirect()->route('doctorschedule.index')->withMessage($message);
            }
            catch (\Throwable $th) {
                throw $th;
            }
    }

    public function view($id){
        $schedule = DoctorSchedule::findOrFail($id);
        $parent_nav = 'doctor_schedule';
        $child_nav= 'doctor_schedule';
        return view('doctor_schedule.view',compact('schedule','parent_nav'));
    }

        public function edit($id){
            $parent_nav = 'doctor_schedule';
            $child_nav= 'doctor_schedule';
        // $month=DoctorSchedule::get();
        $team=Team::where('status','active')->get();
        $DoctorSchedule = DoctorSchedule::findOrFail($id);
        // dd($schedule);/
        return view('doctor_schedule.edit',compact('parent_nav','child_nav','DoctorSchedule','team'));
    }

    public function update(Request $request,$id) {
        // dd($request->all());
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'team' => 'required',
                'date' => 'required|date|date_format:Y-m-d|after_or_equal:today',
                'time' => 'required',
                'duration' => 'required|numeric|min:30|max:480',
            ],$message = [
                'team.required' => 'Team field is required.',
                'date.required' => 'Date field is required',
                // 'date.after_or_equal' => 'Date field must be after or equal to today ',
                'time.required' => 'Time field is required',
                'time.after_or_equal' => 'Time field must be after or equal to present time',
                'duration.required' => 'Duration field is required',
            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }
            // die();
            // $db_schedule = DoctorSchedule::findOrFail($id);
            $DoctorSchedule=DoctorSchedule::where('team_id',$data['team'])->where('date',$data['date'])
                            ->where('id', '!=', $id)
                            ->get();
            // dd($DoctorSchedule);
            foreach($DoctorSchedule as $ds){
                $existingStartTime = $ds->start_time;
                $existingEndTime = Carbon::parse($ds->start_time)->addMinutes($ds->duration_in_minutes);
                $existingEndTime = $existingEndTime->format('H:i:s');

                $requestedStartTime = $request->time;
                $requestedStartTime = $requestedStartTime.':00';
                $requestedEndTime = Carbon::parse($request->time)->addMinutes($request->duration);
                $requestedEndTime = $requestedEndTime->format('H:i:s');
                // dd($existingEndTime,$existingStartTime,$requestedStartTime,$requestedEndTime);

                // Check for overlap
                if (($requestedStartTime >= $existingStartTime && $requestedStartTime < $existingEndTime)
                || ($requestedEndTime > $existingStartTime && $requestedEndTime <= $existingEndTime))

             {
                return redirect()->back()->withError('Overlap detected with an existing record.')->withInput();
                }
                // if ($requestedStartTime >= $existingStartTime && $requestedStartTime < $existingEndTime) {
                // }
            }
            DoctorSchedule::where('id', $id)->update([
                'team_id' => $request->team,
                'date' => $request->date,
                'start_time' => $request->time,
                'duration_in_minutes' => $request->duration,
            ]);

            $message = 'Doctor Schedule Updated Successfully!';

            return redirect()->route('doctorschedule.index')->withMessage($message);
        }
            catch (\Throwable $th) {
                throw $th;
            }

        }
    public function delete($id){
        try{

            $schedule = DoctorSchedule::findOrFail($id);
            $schedule->update([
                'is_deleted'=> 1
            ]);
            $message = 'Doctor Schedule Delete Successfully!';
            return redirect()->back()->withMessage($message);
        }catch(\Throwable $th){
            $message = 'Unable to Delete Schedule!';
            return redirect()->back()->withError('Unable to Delete Schedule!!!');
        }
    }

 }
