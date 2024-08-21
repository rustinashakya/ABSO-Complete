<?php


namespace App\Http\Controllers\Admin;

use App\Exports\ExportContacts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ContactUsController extends Controller
{
    public function index(Request $request)
    {
        $from = ($request->get('date_from'));
        $to = ($request->get('date_to'));
        if ($from) {
            $from = Carbon::createFromFormat('Y-m-d', $from)->startOfDay();
        }

        if ($to) {
            $to = Carbon::createFromFormat('Y-m-d', $to)->endOfDay();
        }

        $contact = Contact::latest()
            ->when($from && $to, function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [$from, $to]);
            })
            ->when($from && !$to, function ($query) use ($from) {
                $query->where('created_at', '>=', $from);
            })
            ->when(!$from && $to, function ($query) use ($to) {
                $query->where('created_at', '<=', $to);
            })
            ->paginate(25);


        return view('contact.index', compact('contact', 'from', 'to'));
    }
    public function view($id)
    {
        // $parent_nav = 'settings';
        // $child_nav = 'contact';
        $parent_nav = 'contact';
        $contact = Contact::findOrFail($id);
        return view('contact.view', compact('contact', 'parent_nav'));
    }

    public function search(Request $request)
    {
        // Check if both fields are filled
        if ($request->has('from') && $request->has('to')) {
            $from = ($request->get('from'));
            $to = ($request->get('to'));
            // dd($from);
            if ($to == null || $from == null) {
                $contact = Contact::latest()->paginate(25);
            } else {

                $contact = Contact::whereBetween(DB::raw('DATE(created_at)'), [$from, $to])->latest()->paginate(10);
            }
            return view('contact.index', compact('contact', 'from', 'to'));
        }
    }

    public function delete($contact_id)
    {
        $contact = Contact::find($contact_id);
        $contact->delete();
        // Contact::withTrashed()->find($contact_id)->restore();
        $message = 'Contact Deleted Successfully!';
        return redirect()->back()->withMessage($message);
    }

    public function getTrashed()
    {
        Contact::onlyTrashed()->get();
        $message = 'Contact Deleted Successfully!';
        return redirect()->back()->withMessage($message);
    }

    public function restore()
    {
        Contact::withTrashed()->restore();
    }

    public function forceDelete($contact_id)
    {
        Contact::withTrashed()->find($contact_id)->forceDelete();
    }

    public function export()
    {
        return Excel::download(new ExportContacts, 'contacts.xlsx');
    }
}
