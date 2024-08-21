<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ApplicantComment;
use Illuminate\Http\Request;

class ApplicantCommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => ['required'],
            'status' => ['required', 'in:accepted,rejected,shortlisted'],
        ]);

        $applicantComment = ApplicantComment::create([
            'comment' => $request->comment,
            'comment_date' => now(),
            'comment_by' => auth()->user()->id,
            'status' => $request->status,
            'applicant_id' => $request->applicant_id,
        ]);

        return redirect()->route('admin.applicant.show', $request->applicant_id)->withMessage('Comment Added successfully!');
    }

    public function destroy($id)
    {
        $comment = ApplicantComment::findOrFail($id);
        $comment->delete();
        
        return redirect()->back()->withMessage('Comment Deleted successfully!');
    }
}
