<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HealthLibrary;

class HealthLibraryApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $health_library = HealthLibrary::select('id','title','link', 'thumbnail','published_date')
            ->get();

        if (count($health_library) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $health_library,
                ],
                200
            );
        } else {
            return response()->json(
                [

                    'status' => false,
                    'message' => 'Health Library data not found',
                ],
                400
            );
        }
    }
}