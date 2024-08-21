<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;

class TestimonialApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $testimonials = Testimonial::select('id','link','thumbnail')
            ->get();

        if (count($testimonials) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $testimonials,
                ],
                200
            );
        } else {
            return response()->json(
                [

                    'status' => false,
                    'message' => 'Testimonials not found',
                ],
                400
            );
        }
    }
}