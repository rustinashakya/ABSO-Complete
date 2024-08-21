<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicantComment;
use App\Models\Vacancy;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApplicantController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Applicant access', ['only'=> ['index', 'show']]);
        $this->middleware('role_or_permission:Applicant delete', ['only'=> ['destroy']]);
    }

    public function index(Request $request)
    {
        $applicants = Applicant::with('vacancy')
                    ->latest()
                    ->searchApplicant($request->name, $request->email, $request->phone, $request->vacancy_id)
                    ->where('stage', 1)
                    ->paginate(20);

        $vacancies = Vacancy::where('deadline', '>=', Carbon::today()->format('Y-m-d'))->latest()->get();
        return view('admin.vacancy.applicants.index', compact('applicants', 'vacancies'));
    }

    public function show($id)
    {
        $applicant = Applicant::findOrFail($id);
        $comments = ApplicantComment::where('applicant_id', $applicant->id)->get();
        return view('admin.vacancy.applicants.show', compact('applicant', 'comments'));
    }

    public function destroy($id)
    {
        $applicant = Applicant::findOrFail($id);
        $applicant->delete();
        return redirect()->route('admin.applicant.index')->withMessage('Applicant deleted successfully');
    }
}
