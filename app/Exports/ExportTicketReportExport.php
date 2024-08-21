<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Customer;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ExportTicketReportExport implements FromView
{
    private $request;

    public function __construct()
    {

    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function view(): View
    {
            $customer = Customer::whereDate('created_at', Carbon::today())->with('customer_ticket_sum')->get();
            return view('excel.ticket-report',compact('customer'));
    }
}