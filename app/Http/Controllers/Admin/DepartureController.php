<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DepartureController extends Controller
{
    public function index(Request $request) {
        
        @$from = $request->from;
        @$to = $request->to;

        $customer = Customer::whereHas('isVerifyQR', function($query) {
            return $query->where('is_verify_out', '1');
        })
        ->with(['isVerifyQR' => function($query) {
            $query->where('is_verify_out', '1')->get();
        }])->first();
        if(@$customer->isVerifyQR != null) {
            $is_verify_out = @$customer->isVerifyQR->count();
        }   else {
            $is_verify_out = '0';
        }

        if ($request->has('from') && $request->has('to')) {
            $departure = Customer::searchDeparture($from,$to)
            ->simplePaginate(10);
            $qr_codes = $departure->loadCount('isVerifyQR');

        } else {
            $departure = Customer::whereDate('is_verify_out_date', Carbon::today())
                        ->simplePaginate(10);
                        $qr_codes = $departure->loadCount('isVerifyQR');
                        // $qr_codes = $departure->load('isVerifyQR');
                        // dd($qr_codes);
        }
       
        
        return view('admin.departure.index',compact('departure','from','to','is_verify_out'));
    }
}
