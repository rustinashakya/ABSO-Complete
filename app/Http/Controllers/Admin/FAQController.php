<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FAQ;

class FAQController extends Controller
{
    public function index()
    {
        $faqs = FAQ::get();
        $parent_nav = 'content';
        $child_nav = 'faq';
        return view('faq.index', compact('faqs', 'parent_nav', 'child_nav'));
    }

    public function create()
    {
        $parent_nav = 'content';
        $child_nav = 'faq';
        return view('faq.create', compact('parent_nav', 'child_nav'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required|in:active,inactive',
        ]);


        FAQ::create([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.faq.index')->withSuccess('FAQ created successfully')->withMessage('FAQ created successfully');
    }

    public function edit($faq_id)
    {
        $faq = FAQ::findOrFail($faq_id);
        $parent_nav = 'content';
        $child_nav = 'faq';
        return view('faq.edit', compact('faq', 'parent_nav', 'child_nav'));
    }

    public function update(Request $request, $faq_id)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'status' => 'required',

        ]);

        $faq = FAQ::findOrFail($faq_id);

        $faq->update([
            'question' => $request->input('question'),
            'answer' => $request->input('answer'),
            'status' => $request->input('status'),
        ]);

        return redirect()->route('admin.faq.index')->withSuccess('FAQ updated successfully')->withMessage('FAQ updated successfully');
    }

    public function delete($faq_id)
    {
        $faq = FAQ::where('id', $faq_id)->delete();
        $message = 'FAQ Deleted';
        return redirect()->back()->withSuccess('FAQ Deleted !!!')->withMessage($message);
    }
}