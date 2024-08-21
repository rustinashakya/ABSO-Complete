<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function langChange($locale, Request $request)
    {
        App::setLocale($locale);
        Session::put('locale', $locale);
        return back();
    }

    public function index()
    {
        $languages = DB::table('languages')
            ->select('languages.*')
            ->get();

        return view('admin.language.index', compact('languages'));
    }

    public function create()
    {
        $lists = DB::table('lists')
            ->select('lists.*')
            ->get();
        return view('admin.language.create', compact('lists'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'list_id' => ['required'],
        ]);
        $list = DB::table('lists')->select('lists.*')->where('id', $request->list_id)->first();
        Language::updateOrCreate([
            'flag' => $list->flag
        ], [
            'name' => $list->name,
        ]);
        return redirect()->route('admin.language.index')->withMessage('Language Created Successfully!');
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        $lists = DB::table('lists')
            ->select('lists.*')
            ->get();
        return view('admin.language.edit', compact('language', 'lists'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'list_id' => ['required'],
        ]);
        $list = DB::table('lists')->select('lists.*')->where('id', $request->list_id)->first();
        $language = Language::findOrFail($id);
        $language->update([
            'name' => $list->name,
            'flag' => $list->flag
        ]);
        return redirect()->route('admin.language.index')->withMessage('Language Updated Successfully!');
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);
        $language->delete();
        return redirect()->route('admin.language.index')->withMessage('Language Deleted Successfully!');
    }
}
