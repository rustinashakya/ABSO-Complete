<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FAQ;

class FAQApiController extends Controller
{
    public function getAllFaq()
    {
        $faqs = FAQ::where('status', 'active')
            ->select('question', 'answer')
            ->get();

        if (count($faqs) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $faqs,
                ],
                200
            );
        } else {
            return response()->json(
                [

                    'status' => false,
                    'message' => 'FAQ not found',
                ],
                400
            );
        }
    }
}
