<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\News;
use App\Models\NewsLanguage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class NewsLanguageController extends Controller
{

    public function index($id)
    {
        $news = News::findOrFail($id);
        $newsLanguages = NewsLanguage::where('news_id', $id)->with('language')->latest()->paginate(15);
        return view('admin.news_language.index', compact('newsLanguages', 'news'));
    }


    public function create($id)
    {
        $setting = SiteSetting::first()->language_id;
        $news = NewsLanguage::where('news_id', $id)->where('language_id', $setting)->first();
        $languages = Language::where('id', '<>',$setting)->get();
        return view('admin.news_language.create', compact('languages', 'news'));
    }   


    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);
        $news = News::findOrFail($id);

        $newsLanguage = NewsLanguage::updateOrCreate([
            'title' => $request->title,
            'description' => $request->description,
            'news_id' => $news->id,
            'language_id' => $request->language_id
        ]);

        return redirect()->route('admin.news.language.index', $news->id)->withMessage('News Language Added Successfully!');

    }


    public function show($id)
    {
        //
    }


    public function edit($news_id, $id)
    {
        $setting = SiteSetting::first()->language_id;
        $news = NewsLanguage::where('news_id', $news_id)->where('language_id', $setting)->first();
        $languages = Language::where('id', '<>',$setting)->get();
        $newsLanguage = NewsLanguage::findOrFail($id);
        return view('admin.news_language.edit', compact('newsLanguage','languages', 'news'));
    }


    public function update(Request $request, $news_id, $id)
    {
        $validated = $request->validate([
            'language_id' => 'required|exists:languages,id',
            'title' => 'required|string|max:255',
            'description' => 'required',
        ]);

        $newsLanguage = NewsLanguage::findOrFail($id);
        $news = News::findOrFail($news_id);
        $newsLanguage->update([
            'title' => $request->title,
            'description' => $request->description,
            'news_id' => $news->id,
            'language_id' => $request->language_id
        ]);
        return redirect()->route('admin.news.language.index', $news->id)->withMessage('News Language Updated Successfully!');
    }


    public function destroy($news_id, $id)
    {
        $news = News::findOrFail($news_id);
        $newsLanguage = NewsLanguage::findOrFail($id);
        $newsLanguage->delete();
        return redirect()->route('admin.news.language.index', $news->id)->withMessage('News Language Deleted Successfully!');
    }
}
