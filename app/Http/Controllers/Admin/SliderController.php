<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SlideImage;
use App\Rules\ValidYouTubeLink;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SliderController extends Controller
{
    public function __construct()
    {
        // $this->middleware('role_or_permission:Slider access', ['only' => ['index']]);
        // $this->middleware('role_or_permission:Slider create', ['only' => ['add', 'store']]);
        // $this->middleware('role_or_permission:Slider edit', ['only' => ['edit', 'update']]);
        // $this->middleware('role_or_permission:Slider delete', ['only' => ['delete']]);
    }
    public function index()
    {
        $sliders = SlideImage::orderBy('order_by', 'asc')->get();
        return view('slider.index', compact('sliders'));
    }

    public function add()
    {
        $slider = SlideImage::get();
        return view('slider.add', compact('slider'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        try {

            $data = $request->all();
            $time = time();
            $validator = Validator::make($data, [
                'youtube_link1' => $request->type == 'youtube1' ? ['nullable', new ValidYouTubeLink] : 'nullable',
                'main_image' => $request->type == 'image1' ? 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:width=1920,height=754' : 'nullable',
                'mobile_image' => $request->type == 'image1' ? 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:width=767,height=767' : 'nullable',
                'url' => 'nullable|url',
                'name' => [
                    'required',
                    'string',
                ],
                'order_by' => ['nullable', 'numeric', 'unique:slide_images,order_by'],
                'caption_description' => ['required']
            ], $message = [
                'name.required' => 'Caption Title field is required',
                'name.regex' => 'Enter a valid Caption Title',
                'main_image.required' => 'Image field is required',
                'main_image.image' => 'Image must be image type',
                'main_image.max' => 'Image size should be less than 2 MB',
                'main_image.dimensions' => 'Image should be of 1920*754 size ',
                'mobile_image.required' => 'Image field is required',
                'mobile_image.image' => 'Image must be image type',
                'mobile_image.max' => 'Image size should be less than 2 MB',
                'mobile_image.dimensions' => 'Image should be of 767*767 size ',
                'youtube_link1.required' => 'The youtube link field is required.',
                'youtube_link1.regex' => 'The youtube link is Invalid.',
                'url.url' => 'The url is Invalid.',
                'order_by.numeric' => 'The order_by must be a number.',
                'order_by.unique' => 'The order by has already been taken.',
                'description.required'=> 'Description field is required',
            ]);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
            $slider = new SlideImage();

            if ($request->main_image) {
                $image = $request->file('main_image');
                // dd($file);
                // Generate a unique filename


                $extension = $image->getClientOriginalExtension();
                $filename1 = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $filename_to_store = $filename . '_' . $time . '.' . $extension;

                $admin_to_store = 'admin_' . $filename . '_' . $time . '.' . $extension;

                $thumbnailPath = public_path('/storage/uploads/slider/main_image/thumbnail/');
                $originalPath = public_path('/storage/uploads/slider/main_image/');
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }

                $categoryImage = Image::make($image);
                $width = $categoryImage->width();
                // dd($width);
                $categoryImage->save($originalPath . $filename_to_store);
                $categoryImage->backup();

                $slider->main_image = $filename_to_store;

                //image resize for admin panel 

                $categoryImage->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin_to_store, 90);
                $categoryImage->reset();
            } else {
                $slider->main_image = null;
            }

            if ($request->mobile_image) {
                $image = $request->file('mobile_image');

                $extension = $image->getClientOriginalExtension();
                $filename1 = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin_to_store = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $originalPath = public_path('/storage/uploads/slider/mobile_image/');
                $thumbnailPath = public_path('/storage/uploads/slider/mobile_image/thumbnail/');
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                $categoryImage = Image::make($image);
                $categoryImage->save($originalPath . $filename_to_store);
                $categoryImage->backup();


                $slider->mobile_image = $filename_to_store;

                $categoryImage->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin_to_store, 90);
                $categoryImage->reset();
            } else {
                $slider->mobile_image = null;
            }
            if ($request->youtube_link1 != null) {
                // dd($request->youtube_link1);
                $link = $request->youtube_link1;
                if (strpos($link, 'watch?v=') !== false) {
                    $embedUrl = str_replace('watch?v=', 'embed/', $link);
                } else {
                    $embedUrl = $link;
                }
                $slider->youtube_url = $embedUrl;
            }

            $slider->caption_description = $request->caption_description;
            $slider->slider_type = $request->slider_type;
            $slider->name = $request->name;
            $slider->order_by = $request->order_by;
            $slider->url = $request->url;

            $slider->save();

            $message = 'Slider Added Successfully!';
            return redirect()->route('admin.slider.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($slider_id)
    {
        $slider = SlideImage::findOrFail($slider_id);
        return view('slider.edit', compact('slider'));
    }

    public function update(Request $request, $slider_id)
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'youtube_link1' => $request->type == 'youtube1' ? ['nullable', new ValidYouTubeLink] : 'nullable',
                'main_image' => $request->type == 'image1' ? 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:width=1920,height=754' : 'nullable',
                'mobile_image' => $request->type == 'image1' ? 'mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:width=767,height=767' : 'nullable',
                'slider_type' => 'nullable',
                'url' => 'nullable|url',
                'name' => [
                    'required',
                    'string',
                    'regex:/^[A-Za-z0-9\s]+$/',
                ],
                'order_by' => 'nullable|numeric|unique:slide_images,order_by,' . $slider_id,
                'caption_description' => 'required',
            ], $message = [
                'name.required' => 'Caption Title field is required',
                'name.regex' => 'Enter a valid Caption Title',
                'main_image.required' => 'Image field is required',
                'main_image.image' => 'Image must be image type',
                'main_image.max' => 'Image size should be less than 2 MB',
                'mobile_image.required' => 'Image field is required',
                'mobile_image.image' => 'Image must be image type',
                'mobile_image.max' => 'Image size should be less than 2 MB',
                'slider_type' => 'Slider type field is required',
                'main_image.dimensions' => 'Image should be size of 1920px X 754px',
                'mobile_image.dimensions' => 'Image should be size of 767px X 767px',
                'youtube_link1.required' => 'The youtube link field is required.',
                'youtube_link1.regex' => 'The youtube link is Invalid.',
                'order_by.numeric' => 'Enter a valid order by number',
                'order_by.unique' => 'The order by has already been taken.',

            ]);

            if ($validator->fails()) {

                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $slider = SlideImage::find($slider_id);
            $time = time();

            if ($request->main_image) {

                if ($slider->main_image) {
                    Storage::delete('storage/uploads/slider/main_image/' . $slider->main_image);
                    Storage::delete('storage/uploads/services/main_image/thumbnail/admin_' . $slider->main_image);
                }

                $image = $request->file('main_image');
                // dd($file);
                // Generate a unique filename


                $extension = $image->getClientOriginalExtension();
                $filename1 = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin_to_store = 'admin_' . $filename . '_' . $time . '.' . $extension;


                $originalPath = public_path('/storage/uploads/slider/main_image/');
                $thumbnailPath = public_path('/storage/uploads/slider/main_image/thumbnail/');
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }

                $categoryImage = Image::make($image);
                $width = $categoryImage->width();
                // dd($width);
                $categoryImage->save($originalPath . $filename_to_store);
                $categoryImage->backup();

                $slider->main_image = $filename_to_store;

                //image resize for admin panel 

                $categoryImage->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin_to_store, 90);
                $categoryImage->reset();
            }

            if ($request->mobile_image) {
                if ($slider->mobile_image) {
                    Storage::delete('storage/uploads/slider/mobile_image/' . $slider->mobile_image);
                    Storage::delete('storage/uploads/services/mobile_image/thumbnail/admin_' . $slider->mobile_image);
                }
                $image = $request->file('mobile_image');

                $extension = $image->getClientOriginalExtension();
                $filename1 = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin_to_store = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $originalPath = public_path('/storage/uploads/slider/mobile_image/');
                $thumbnailPath = public_path('/storage/uploads/slider/mobile_image/thumbnail/');
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }

                $categoryImage = Image::make($image);
                $categoryImage->save($originalPath . $filename_to_store);
                $categoryImage->backup();


                $slider->mobile_image = $filename_to_store;

                $categoryImage->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin_to_store, 90);
                $categoryImage->reset();
            }
            if ($request->youtube_link1 != null) {
                // dd($request->youtube_link1);
                $link = $request->youtube_link1;
                if (strpos($link, 'watch?v=') !== false) {
                    $embedUrl = str_replace('watch?v=', 'embed/', $link);
                } else {
                    $embedUrl = $link;
                }
                $slider->youtube_url = $embedUrl;
            }

            $slider->caption_description = $request->caption_description;
            $slider->slider_type = $request->slider_type;
            $slider->name = $request->name;
            $slider->url = $request->url;
            $slider->order_by = $request->order_by;

            $slider->update();

            $message = 'Slider Update Successfully';

            return redirect()->route('admin.slider.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($slider_id)
    {
        $student = SlideImage::findOrFail($slider_id);
        if ($student->main_image) {
            $image_path = public_path('/storage/uploads/slider/main_image/' . $student->main_image);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }
        if ($student->mobile_image) {
            $image_path = public_path('/storage/uploads/slider/mobile_image/' . $student->mobile_image);
            if (File::exists($image_path)) {
                File::delete($image_path);
            }
        }

        $student->delete();
        $message = 'Slider Delete Successfully';
        return redirect()->back()->withMessage($message);
    }
}
