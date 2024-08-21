<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Team\StoreTeamRequest;
use App\Http\Requests\Team\UpdateTeamRequest;
use App\Models\Designation;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class TeamController extends Controller
{
    public function index(Request $request)
    {
        $name = $request->name;
        $designation_id = $request->designation_id;
        $teams = Team::with('designation')
                ->searchTeam($name, $designation_id)
                ->orderBy('order_by', 'asc')->Paginate(25);
        $designations = Designation::all();
        return view('teams.index', compact('teams', 'designations'));
    }

    public function create()
    {
        $designations = Designation::all();
        return view('teams.create', compact('designations'));
    }

    public function store(StoreTeamRequest $request)
    {
        try {
            $data = $request->validated();

            $team = new Team();
            $time = time();
            if ($request->profile_image) {
                $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin_to_store = 'admin_'. $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('profile_image');
                $originalPath = public_path() . '/storage/uploads/teams/profile_image/';
                $thumbnailPath = public_path(). '/storage/uploads/teams/profile_image/thumbnails/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }
                $categoryImage = Image::make($main_image);
                $categoryImage->backup();

                $categoryImage->save($originalPath . $filename_to_store);
                $team->profile_image = $filename_to_store;

                $categoryImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin_to_store, 90);
                $categoryImage->reset();

            } else {
                $team->profile_image = null;
            }

            $team->name = $request->name;
            $team->slug = Str::slug($request->slug);
            $team->type = $request->type;
            $team->order_by = $request->order_by;
            $team->designation_id = $request->designation_id;
            $team->experience = $request->experience;
            $team->facebook = $request->facebook;
            $team->twitter = $request->twitter;
            $team->instagram = $request->instagram;
            $team->description = $request->description;
            $team->speciality = $request->speciality;

            $team->meta_description = $request->meta_description;
            $team->meta_keyword = $request->meta_keyword;
            $team->html_title = $request->html_title;
            $team->save();

            $message = 'Team Member Added Successfully !';
            return redirect()->route('admin.teams.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($team_id)
    {

        $designations = Designation::all();
        $team = Team::findOrFail($team_id);
        return view('teams.edit', compact('team', 'designations'));
    }

    public function update(UpdateTeamRequest $request, $team_id)
    {
        try {

            $data = $request->all();
            $team = Team::find($team_id);
            $time = time();

            if ($request->hasFile('profile_image')) {
                $profile_image = $request->file('profile_image');

                // Delete old image
                $old_image_path = 'storage/uploads/teams/profile_image/' . $team->profile_image;
                $old_thumbnail_path = 'storage/uploads/teams/profile_image/thumbnails/admin_' . $team->profile_image;
                if (File::exists($old_image_path)) {
                    File::delete($old_image_path);
                }
                if (File::exists($old_thumbnail_path)) {
                    File::delete($old_thumbnail_path);
                }

                // Save new image

                $profile_image = $request->file('profile_image')->getClientOriginalName();
                $filename1 = pathinfo($profile_image, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $extension = $request->file('profile_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin_to_store = 'admin_'. $filename . '_' . $time . '.' . $extension;

                // dd($filename_to_store);
                $team->profile_image = $filename_to_store;

                $p_image = $request->file('profile_image');
                $profileImage = Image::make($p_image);
                $profileImage->backup();
                $originalPath = public_path() . '/storage/uploads/teams/profile_image/';
                $thumbnailPath = public_path(). '/storage/uploads/teams/profile_image/thumbnails/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }
                //orignial
                $profileImage->save($originalPath . $filename_to_store);

                $profileImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $profileImage->sharpen(10);
                $profileImage->save($thumbnailPath . $admin_to_store, 90);
                $profileImage->reset();
            }
            $team->name = $request->name;
            $team->slug = Str::slug($request->slug);
            $team->type = $request->type;
            $team->order_by = $request->order_by;
            $team->designation_id = $request->designation_id;
            $team->experience = $request->experience;
            $team->facebook = $request->facebook;
            $team->twitter = $request->twitter;
            $team->instagram = $request->instagram;
            $team->description = $request->description;
            $team->speciality = $request->speciality;

            $team->meta_description = $request->meta_description;
            $team->meta_keyword = $request->meta_keyword;
            $team->html_title = $request->html_title;
            $team->update();

            $message = 'Team Member Updated Successfully!';

            return redirect()->route('admin.teams.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($team_id)
    {
        try {
            $team = Team::findOrFail($team_id);
            $team->delete();

            $message = 'Team Member Deleted Successfully!';
            return redirect()->back()->withMessage($message);
        } catch (\Throwable $th) {
            $message = 'Failed to Delete Team Member';
            return redirect()->back()->withError('Failed to Delete Team Member!');
        }
    }
}
