<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Investment;
use App\Models\InvestmentLanguage;
use App\Models\Language;
use Illuminate\Http\Request;

class InvestmentLanguageController extends Controller
{

    public function __construct()
    {
        $this->middleware('role_or_permission:Investment access', ['only'=> ['index', 'show']]);
        $this->middleware('role_or_permission:Investment delete', ['only'=> ['destroy']]);
        $this->middleware('role_or_permission:Investment create', ['only'=> ['create', 'store']]);
        $this->middleware('role_or_permission:Investment edit', ['only'=> ['edit', 'update']]);
    }


    public function index($id)
    {
        $investment = Investment::find($id);
        $languages = InvestmentLanguage::where('investment_id', $id)->get();
        return view('admin.investment.language.index', compact('investment', 'languages'));
    }

    public function create($id)
    {
        $investment = Investment::find($id);
        $languages = Language::all();
        return view('admin.investment.language.create', compact('investment', 'languages'));
    }


    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'language_id' => 'required',
        ]);

        $investment = Investment::find($id);
        $investmentLanguage = InvestmentLanguage::updateOrCreate([
            'investment_id' => $id,
            'language_id' => $request->language_id,
        ], [
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return redirect(route('admin.investment.language.index', $investment->id))->withMessage('Language Added Successfully');
    }

    public function edit($investment_id, $id)
    {
        $investment = Investment::find($investment_id);
        $investmentLanguage = InvestmentLanguage::findOrFail($id);
        $languages = Language::all();
        return view('admin.investment.language.edit', compact('investment', 'investmentLanguage', 'languages'));
    }

    public function update(Request $request, $investment_id, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'language_id' => 'required',
        ]);
        $investment = Investment::find($investment_id);
        $investmentLanguage = InvestmentLanguage::find($id);
        $investmentLanguage->update([
            'title' => $request->title,
            'description' => $request->description,
            'language_id' => $request->language_id,
            'investment_id' => $investment_id
        ]);
        return redirect(route('admin.investment.language.index', $investment->id))->withMessage('Language Updated Successfully');
    }

    public function destroy($investment_id, $id)
    {
        $investment = Investment::find($investment_id);
        $investmentLanguage = InvestmentLanguage::find($id);
        $investmentLanguage->delete();

        return redirect(route('admin.investment.language.index', $investment->id))->withMessage('Language Deleted Successfully');
    }


}
