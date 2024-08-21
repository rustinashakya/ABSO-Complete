<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HealthLibrary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;


class HealthLibraryController extends Controller
{
    public function index()
    {
        $health_library = HealthLibrary::get();
        $parent_nav = 'content';
        $child_nav = 'health_library';
        return view('healthlibrary.index', compact('health_library', 'parent_nav', 'child_nav'));
    }

    public function create()
    {
        $parent_nav = 'content';
        $child_nav = 'health_library';
        return view('healthlibrary.create', compact('parent_nav', 'child_nav'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(
                $data,
                [
                    'link' => ['required', 'regex:/^(https?:\/\/)?(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/)([\w\-]{11})(\S*)?$/'],
                    'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:max_height=720, max_width=1280, min_width=640'
                ],
                $message = [
                    'link' => 'The youtube link field is required.',
                    'link.regex' => 'Invalid Youtube Link.',
                    'thumbnail' => 'Thumbnail field is required',
                    'thumbnail.dimensions' => 'Thumbnail minimum width must be 640 px',
                ]
            );

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $health_library = new HealthLibrary();
        

            if ($request->thumbnail) {


                $thumbnail = $request->file('thumbnail')->getClientOriginalName();
                $filename1 = pathinfo($thumbnail, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('thumbnail')->getClientOriginalExtension();
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

                $health_library->thumbnail = $filename_to_store;

                $s_image = $request->file('thumbnail');
                $thumbnailImage = Image::make($s_image);
                $thumbnailImage->backup();
                $thumbnailPath = public_path() . '/storage/uploads/health_library_thumbnail/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/health_library_thumbnail/';

                //orignial
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }

                $thumbnailImage->save($originalPath . $filename_to_store);
                //for modal
                $thumbnailImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $modal_pic);
                $thumbnailImage->reset();
                //for large
                $thumbnailImage->resize(202, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $large_thumbnail);
                $thumbnailImage->reset();
                //thumbnail for medium
                $thumbnailImage->resize(185, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $medium_thumbnail);
                $thumbnailImage->reset();
                //thumbnail for small

                $thumbnailImage->resize(151, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $small_thumbnail);
                $thumbnailImage->reset();
                //thumbnail for small

                $thumbnailImage->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $vsmall_thumbnail);
                $thumbnailImage->reset();

            } else {
                $health_library->thumbnail = null;
            }

            if ($request->link != null) {
                // ($request->link1);
                $link = $request->link;
                if (strpos($link, 'watch?v=') !== false) {
                    $embedUrl = str_replace('watch?v=', 'embed/', $link);
                } else {
                    $embedUrl = $link;
                }
                $health_library->link = $embedUrl;
            }
            $health_library->title = $request->title;
            $health_library->published_date = $request->published_date;

            $health_library->save();
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->route('healthlibrary.index')->withSuccess('Health library created successfully')->withMessage('Health library created successfully');
    }

    public function edit($health_library_id)
    {
        $health_library = HealthLibrary::findOrFail($health_library_id);
        $parent_nav = 'content';
        $child_nav = 'health_library';
        return view('healthlibrary.edit', compact('health_library', 'parent_nav', 'child_nav'));
    }

    public function update(Request $request, $health_library_id)
    {
        try {
            $data = $request->all();
            $validator = Validator::make(
                $data,
                [
                    'link' => ['required', 'regex:/^(https?:\/\/)?(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/)([\w\-]{11})(\S*)?$/'],
                    'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:max_height=720, max_width=1280, min_width=640'
                ],
                $message = [
                    'link' => 'The youtube link field is required.',
                    'link.regex' => 'Invalid Youtube Link.',
                    'thumbnail.dimensions' => 'Thumbnail minimum width must be 640 px',
                ]
            );

            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $health_librarys = HealthLibrary::find($health_library_id);

            if ($request->hasFile('thumbnail')) {

                $thumbnail = $request->file('thumbnail');

                $old_image_path = 'storage/uploads/health_library_thumbnail/' . $health_librarys->thumbnail;
                if (File::exists($old_image_path)) {
                    File::delete($old_image_path);
                }


                $thumbnail = $request->file('thumbnail')->getClientOriginalName();
                $filename1 = pathinfo($thumbnail, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('thumbnail')->getClientOriginalExtension();
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

                $health_librarys->thumbnail = $filename_to_store;

                $s_image = $request->file('thumbnail');
                $thumbnailImage = Image::make($s_image);
                $thumbnailImage->backup();
                $thumbnailPath = public_path() . '/storage/uploads/health_library_thumbnail/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/health_library_thumbnail/';

                //orignial
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }

                $thumbnailImage->save($originalPath . $filename_to_store);
                //for modal
                $thumbnailImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $modal_pic);
                $thumbnailImage->reset();
                //for large
                $thumbnailImage->resize(202, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $large_thumbnail);
                $thumbnailImage->reset();
                //thumbnail for medium
                $thumbnailImage->resize(185, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $medium_thumbnail);
                $thumbnailImage->reset();
                //thumbnail for small

                $thumbnailImage->resize(151, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $small_thumbnail);
                $thumbnailImage->reset();
                //thumbnail for vsmall

                $thumbnailImage->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $thumbnailImage->save($thumbnailPath . $vsmall_thumbnail);
                $thumbnailImage->reset();

            }

            if ($request->link != null) {
                $link = $request->link;
                if (strpos($link, 'watch?v=') !== false) {
                    $embedUrl = str_replace('watch?v=', 'embed/', $link);
                } else {
                    $embedUrl = $link;
                    // die();
                }
            }

            HealthLibrary::where('id', $health_library_id)->Update([
                'link' => $embedUrl,
            ]);

            $health_librarys->title = $request->title;
            $health_librarys->published_date = $request->published_date;
            $health_librarys->update();
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->route('healthlibrary.index')->withSuccess('Health library updated successfully')->withMessage('Health library updated successfully');
    }

    public function delete($health_library_id)
    {
        $health_library = HealthLibrary::where('id', $health_library_id)->delete();
        $message = 'Health Library Deleted Successfully';
        return redirect()->back()->withSuccess('Health Library Deleted Successfully!!!')->withMessage($message);
    }
}
