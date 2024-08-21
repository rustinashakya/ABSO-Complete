<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class TeamApiController extends Controller
{
    public function index()
    {
        // dd(DoctorSchedule::where('date', '>=', date('Y-m-d'))->get());
        // $teams = Team::select(
        //     'id',
        //     'name',
        //     'profile_image',
        //     'designation',
        //     'description',
        //     'nmc_number',
        //     'experience',
        //     'slug',
        //     'speclaity',
        //     'doctor_schedule.date as date'
        // )
        // ->join('doctor_schedule', 'doctor_schedule.team_id', '=', 'teams.id')
        //     // ->whereHas('docketSchedule', function ($q) {
        //     //     $q->where('date', '>=', date('Y-m-d'));
        //     // })
        //     ->where('status', 'active')
        //     ->get();
        $teams = TeamResource::collection(Team::where('status', 'active')->get());
        if (count($teams) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $teams,
                ],
                200
            );
        } else {
            return response()->json(
                [

                    'status' => false,
                    'message' => 'Doctor not found',
                ],
                400
            );
        }
    }

    public function getTeamBySlug($slug)
    {
        $team = Team::where('slug', $slug)->select(
            'id',
            'name',
            'profile_image',
            'designation',
            'description',
            'nmc_number',
            'experience',
            'slug',
            'speclaity'
        )
            ->where('status', 'active')
            ->first();

        if (!is_null($team)) {
            return response()->json([
                'status' => true,
                'message' => 'Data fetched successfully!',
                'data' => $team,
            ], 200);
        } else {
            return response()->json(
                [

                    'status' => false,
                    'message' => 'Doctor not found',
                ],
                400
            );
        }
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();

            $validator = Validator::make(
                $data,
                [
                    'name' => 'required',
                    'description' => 'required',
                    'designation' => 'required',
                    'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:height=230,width=230',

                ],
                $message = [
                    'name' => 'Name field is required',
                    'description' => 'Description field is required',
                    'designation' => 'designation field is required',
                    'profile_image' => 'Profile image field is required',
                    'profile_image.image' => 'Profile image must be image',
                    'profile_image.dimensions' => 'Image should be of 230*230 size',
                ]
            );

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $teams = new Team();

            if ($request->profile_image) {


                $profile_image = $request->file('profile_image')->getClientOriginalName();
                $filename1 = pathinfo($profile_image, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . time() . '.' . $extension;
                //vsmall thumbnail name
                $vsmall_thumbnail = 'vsmall_' . $filename . '_' . time() . '.' . $extension;
                //small thumbnail name
                $small_thumbnail = 'small_' . $filename . '_' . time() . '.' . $extension;
                //medium thumbnail name
                $medium_thumbnail = 'medium_' . $filename . '_' . time() . '.' . $extension;
                //large thumbnail name
                $large_thumbnail = 'large_' . $filename . '_' . time() . '.' . $extension;

                //rezie for modal
                $modal_pic = 'modal_' . $filename . '_' . time() . '.' . $extension;

                $teams->profile_image = $filename_to_store;

                $p_image = $request->file('profile_image');
                $profileImage = Image::make($p_image);
                $profileImage->backup();
                $thumbnailPath = public_path() . '/storage/uploads/profile_image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/profile_image/';

                //orignial
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }

                $profileImage->save($originalPath . $filename_to_store);
                //for modal
                $profileImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $modal_pic);
                $profileImage->reset();
                //for large
                $profileImage->resize(202, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $large_thumbnail);
                $profileImage->reset();
                //thumbnail for medium
                $profileImage->resize(185, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $medium_thumbnail);
                $profileImage->reset();
                //thumbnail for small

                $profileImage->resize(151, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $small_thumbnail);
                $profileImage->reset();
                //thumbnail for small

                $profileImage->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $vsmall_thumbnail);
                $profileImage->reset();
            } else {
                $teams->profile_image = null;
            }


            $teams->name = $request->name;
            $teams->description = $request->description;
            $teams->designation = $request->designation;
            $teams->slug = $request->slug;
            $teams->meta_keyword = $request->meta_keyword;
            $teams->meta_description = $request->meta_description;
            $teams->save();

            $message = 'Team Created';
            return response()->json(['message' => $message]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => 'Failed to store data'
            ], 500);
        }
    }

    public function update(Request $request, $team_id)
    {
        try {
            $data = $request->all();

            $validator = Validator::make(
                $data,
                [
                    'name' => 'required',
                    'description' => 'required',
                    'designation' => 'required',
                    'profile_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:height=230,width=230',

                ],
                $message = [
                    'name' => 'Name field is required',
                    'description' => 'Description field is required',
                    'designation' => 'designation field is required',
                    'profile_image' => 'Profile image field is required',
                    'profile_image.image' => 'Profile image must be image',
                    'profile_image.dimensions' => 'Image should be of 230*230 size',
                ]
            );

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 400);
            }

            $team = Team::find($team_id);

            if ($request->hasFile('profile_image')) {
                $profile_image = $request->file('profile_image');

                // Delete old image
                $old_image_path = 'storage/uploads/profile_image/' . $team->profile_image;
                if (File::exists($old_image_path)) {
                    File::delete($old_image_path);
                }

                // Save new image

                $profile_image = $request->file('profile_image')->getClientOriginalName();
                $filename1 = pathinfo($profile_image, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $extension = $request->file('profile_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . time() . '.' . $extension;
                //vsmall thumbnail name
                $vsmall_thumbnail = 'vsmall_' . $filename . '_' . time() . '.' . $extension;
                //small thumbnail name
                $small_thumbnail = 'small_' . $filename . '_' . time() . '.' . $extension;
                //medium thumbnail name
                $medium_thumbnail = 'medium_' . $filename . '_' . time() . '.' . $extension;
                //large thumbnail name
                $large_thumbnail = 'large_' . $filename . '_' . time() . '.' . $extension;
                //rezie for modal
                $modal_pic = 'modal_' . $filename . '_' . time() . '.' . $extension;

                // dd($filename_to_store);
                $team->profile_image = $filename_to_store;

                $p_image = $request->file('profile_image');
                $profileImage = Image::make($p_image);
                $profileImage->backup();
                $thumbnailPath = public_path() . '/storage/uploads/profile_image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/profile_image/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }
                //orignial
                $profileImage->save($originalPath . $filename_to_store);
                // for modal pic
                $profileImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $modal_pic);
                $profileImage->reset();
                //for large
                $profileImage->resize(202, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $large_thumbnail);
                $profileImage->reset();
                //thumbnail for medium
                $profileImage->resize(185, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $medium_thumbnail);
                $profileImage->reset();
                //thumbnail for small

                $profileImage->resize(151, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $small_thumbnail);
                $profileImage->reset();
                //thumbnail for vsmall

                $profileImage->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $profileImage->save($thumbnailPath . $vsmall_thumbnail);
                $profileImage->reset();
            }

            // Update team details
            $team->name = $request->name;
            $team->description = $request->description;
            $team->designation = $request->designation;
            $team->slug = $request->slug;
            $team->meta_keyword = $request->meta_keyword;
            $team->meta_description = $request->meta_description;

            $team->update();

            $message = 'Team Updated !!!';
            return response()->json(['message' => $message]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => 'Failed to update team'
            ], 500);
        }
    }
    public function destroy($team_id)
    {
        try {
            Team::where('id', $team_id)->delete();
            $message = 'Team Deleted';
            return response()->json(['message' => $message]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => 'Failed to delete team'
            ], 500);
        }
    }
}
