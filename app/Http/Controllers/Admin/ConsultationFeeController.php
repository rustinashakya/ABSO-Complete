<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\ConsultationFee;
use App\Models\Team;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Illuminate\Validation\Rule;
use PhpParser\Node\Stmt\TryCatch;

class ConsultationFeeController extends Controller
{
    public function index(){

        $consultationfee = ConsultationFee::with('team','user')->where('status','active')->latest()->Paginate(25);
        $parent_nav = 'fee';
        $child_nav= 'fee';
        return view('consultation_fee.index',compact('consultationfee', 'parent_nav', 'child_nav'));
   }

    public function add(){
        $parent_nav = 'fee';
        $child_nav= 'fee';
        $team=Team::where('status','active')->get();
        $month=ConsultationFee::get();
        // dd($month);
        return view('consultation_fee.add',compact('parent_nav','child_nav','month','team'));
    }

    public function store(Request $request) {
        // dd($request->all());
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                    'team' => 'required',
                    'amount' => 'required|numeric|regex:/^\d{1,6}(\.\d{1,2})?$/',

            ],$message = [
                'team.required' => 'Title field is required.',
                'amount.required' => 'Amount field is required',
            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }
            // $Check for active status with request doctor id
            $afw=ConsultationFee::where('team_id',$data['team'])->where('status','active')->exists();
            if(!$afw){
            $fee = new ConsultationFee();
            $fee->team_id = $request->team;
            $fee->amount = $request->amount;
            $fee->created_by = Auth::user()->id;
            $fee->status = 'active';
            $fee->save();
            $message = 'Consultation fee Created Successfully!!!';

            return redirect()->route('consultationfee.index')->withSuccess('Consultation fee Created Successfully!!!')->withMessage($message);
            }else{
            return redirect()->back()->withError('The consultation fee for this doctor already exists !!!');
            }
            }
            catch (\Throwable $th) {
                throw $th;
            }
    }

    public function view($id){
        $parent_nav = 'fee';
        $child_nav= 'fee';
        $schedule = ConsultationFee::findOrFail($id);
        return view('consultation_fee.view',compact('schedule','parent_nav'));
    }

    public function edit($id){
        $parent_nav = 'fee';
        $child_nav= 'fee';
        // $month=ConsultationFee::get();
        // $team=Team::where('status','active')->get();
        $consultationfee = ConsultationFee::with('team')->findOrFail($id);
        // dd($schedule);/
        return view('consultation_fee.edit',compact('parent_nav','child_nav','consultationfee'));
    }

    public function update(Request $request,$id) {
        // dd($request->all());
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'team' => 'required',
                'amount' => 'required|numeric|regex:/^\d{1,6}(\.\d{1,2})?$/',
            ],$message = [
                'team.required' => 'Team field is required.',
                'amount.required' => 'Amount field is required',
            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }
            // die();
            // $db_schedule = ConsultationFee::findOrFail($id);
DB::beginTransaction();
            $ConsultationFee=ConsultationFee::where('team_id',$data['team'])->where('status','active')->first();

            if($ConsultationFee){
            $fee = new ConsultationFee();
            $fee->team_id = $request->team;
            $fee->amount = $request->amount;
            $fee->created_by = Auth::user()->id;
            $fee->save();
            $message = 'Consultation fee Updated Successfully !!!';
            $ConsultationFee->update([
                'status'=>'inactive',
                'updated_by' => Auth::user()->id,
            ]);
DB::commit();
            return redirect()->route('consultationfee.index')->withSuccess('Consultation fee Updated Successfully !!!')->withMessage($message);
            }else{
            return redirect()->back()->withError('The consultation fee for this doctor already exists !!!');
            }
            $message = 'Schedule Month Updated !!!';

            return redirect()->route('consultation_fee.index')->withSuccess('Schedule Day Update !!!')->withMessage($message);
        }
            catch (\Throwable $th) {
                DB::rollBack();
                throw $th;
            }

        }
    public function delete($id){
        try{

            $ConsultationFee = ConsultationFee::findOrFail($id);
            // dd($ConsultationFee);
            // $schedule->delete();
            // $ConsultationFee->update([
            //     'status'=>'inactive',
            //     'updated_by' => Auth::user()->id,
            // ]);
            if($ConsultationFee){
    
                ConsultationFee::where('team_id',$ConsultationFee['team_id'])->delete();
               $message = 'Consultation Fee Delete Successfully';
               return redirect()->back()->withSuccess('Consultation Fee Deleted !!!')->withMessage($message);
            }else{
               $message = 'Failed to Delete Consultation Fee';
    
               return redirect()->back()->withError('Failed to Delete Consultation Fee !!!')->withMessage($message);
            }
        }catch (\Throwable $th){
            $message = 'Failed to Delete Consultation Fee';
    
            return redirect()->back()->withError('Failed to Delete Consultation Fee !!!');
        }
        
    }
    public function history($id) {
        $parent_nav = 'fee';
        $child_nav= 'fee';
        $fee = ConsultationFee::with('user','team','user_update')->where('team_id',$id)->orderBy('id','desc')->get();
        // dd($fee);
        return view('consultation_fee.history',compact('fee','parent_nav'));
    }

 }
