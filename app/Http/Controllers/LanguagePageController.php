<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Page;
use Illuminate\Http\Request;

class LanguagePageController extends Controller
{
    public function index(Request $request, $page_id)
    {
        $title = $request->title ?? 'Pages';
        $languages = LanguagePage::with('language', 'page')->where('page_id', $page_id)->get();
        $page = Page::find($page_id);
        return view('admin.static_pages.language.index', compact('languages', 'page', 'title'));
    }

    public function create(Request $request, $page_id)
    {
        $title = $request->title;
        $page = Page::find($page_id);
        $languages = Language::all();
        return view('admin.static_pages.language.create', compact('page', 'languages', 'title'));
    }

    public function store(Request $request, $page_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => ['required'],
            'language_id' => ['required', 'exists:languages,id'],
        ]);
        LanguagePage::updateOrCreate(
            [
                'language_id' => $request->language_id,
                'page_id' => $page_id,
            ],
            [
                'name' => $request->name,
                'description' => $request->description
            ]
        );
        return redirect()->route('admin.page.language.index', $page_id)->withMessage('Language Page Added successfully');
    }

    public function edit(Request $request, $page_id, $id)
    {
        $title = $request->title;
        $page = Page::find($page_id);
        $languagePage = LanguagePage::find($id);
        $languages = Language::all();
        return view('admin.static_pages.language.edit', compact('page', 'languagePage', 'languages', 'title'));
    }


    public function update(Request $request, $page_id, $id)
    {
        $validated = $request->validate([
           'name'=> 'required|string|max:255',
            'description' => ['required'],
            'language_id' => ['required', 'exists:languages,id'], 
        ]);
        $languagePage = LanguagePage::find($id);
        $languagePage->update([
            'name' => $request->name,
            'description' => $request->description,
            'language_id' => $request->language_id,
            'page_id' => $page_id
        ]);
        return redirect()->route('admin.page.language.index', $page_id)->withMessage('Language Page Updated successfully');
    }

    public function destroy($page_id, $id)
    {
        $languagePage = LanguagePage::find($id);
        $languagePage->delete();
        return redirect()->route('admin.page.language.index', $page_id)->withMessage('Language Page Deleted successfully');
    }
}
