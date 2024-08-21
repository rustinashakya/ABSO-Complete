<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArrivalController extends Controller
{
    public function index(Request $request) {

        @$from = $request->from;
        @$to = $request->to;
        $customer = Customer::whereHas('isVerifyQR', function($query) {
            return $query->where('is_verify', '1');
        })
        ->with(['isVerifyQR' => function($query) {
            $query->where('is_verify', '1')->get();
        }])->first();
        if(@$customer->isVerifyQR != null) {
            $is_verify_in = @$customer->isVerifyQR->count();
        } else {
            $is_verify_in = '0';
        }


        if ($request->has('from') && $request->has('to')) {
            $arrival = Customer::searchArrival($from,$to)->simplePaginate(10);
            $qr_codes = $arrival->loadCount('isVerifyQR');

        } else {
            $arrival = Customer::whereDate('is_verify_in_date', Carbon::today())->simplePaginate(10);
            // $data = dd($customer->isVerifyQR());
            // dd($data);
            $qr_codes = $arrival->loadCount('isVerifyQR');
        }
        // dd($arrival);
        return view('admin.arrival.index',compact('arrival','from','to','is_verify_in'));
    }
}
