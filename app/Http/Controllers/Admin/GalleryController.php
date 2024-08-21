<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Rules\ValidYouTubeLink;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);

        return view('admin.gallery.index', compact('galleries'));
    }
    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate(
            [
                'youtube_link' => @$request->type == 'youtube_link' ? ['required', new ValidYouTubeLink] : 'nullable',
                'main_image' => @$request->type == 'image' ? 'required|image|mimes:jpeg,png,jpg,gif,svg|max:50000|dimensions:width=1116,height=1552' : 'nullable',
                'mobile_image' => @$request->type == 'image' ? 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:50000|dimensions:width=767,height=767' : 'nullable',
                'document' => @$request->type == 'document' ? 'required|mimes:pdf,doc,docx,xlsx,xls,csv|max:50000' : 'nullable',
                'type' => 'required',
                'caption' => 'nullable|string',
            ],
            $message = [
                'youtube_link.required' => 'Youtube link field is required',
                'youtube_link.regex' => 'Invalid youtube url',
                'main_image.image' => 'Main Image must be image',
                'mobile_image.image' => 'Mobile Image must be image',
                'type' => 'Type field is required',
                'main_image.required' => 'Main image field is required',
                'mobile_image.required' => 'Mobile image field is required',
                'description' => 'Description field in required',
                'mobile_image.dimensions' => 'Mobile image must be size of 767px X 767px',
                'main_image.dimensions' => 'Main image must be size of 1116px X 1552px',
                'document.required' => 'Document field is required',
                'document.mimes' => 'Document must be pdf,doc,docx,xlsx,xls,csv',
                'document.max' => 'Document maximum size is 5MB',
            ],
        );

        $time = time();
        try {
            $gallery = new Gallery();

            //check if request has main image
            if ($request->main_image) {
                //get filename with extension
                $filenamewithextension = $request->file('main_image')->getClientOriginalName();
                //get filename without extension
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                //get file extension
                $extension = $request->file('main_image')->getClientOriginalExtension();
                //filename to store
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $list = 'list_' . $filename . '_' . $time . '.' . $extension;
                //filename to store
                $filename_to_store = preg_replace('/\s+/', '', $filename . '_' . $time . '.' . $extension);

                //generate a different thumbnail main_image and save into a folder
                $main_image = $request->file('main_image');
                $galleryImage = Image::make($main_image);
                $galleryImage->backup();
                $originalPath = public_path() . '/storage/uploads/gallery/main_image/';
                $thumbnailPath = public_path() . '/storage/uploads/gallery/main_image/thumbnail/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }

                $galleryImage->save($originalPath . $filename_to_store);

                $gallery->main_image = $filename_to_store;

                $galleryImage->resize(200, 200, function ($constraint) {
                    // $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $galleryImage->save($thumbnailPath . $admin);
                $galleryImage->reset();

                $galleryImage->resize(475, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $galleryImage->sharpen(10);
                $galleryImage->save($thumbnailPath . $list, 90);
                $galleryImage->reset();
            } else {
                $gallery->main_image = null;
            }

            if ($request->mobile_image) {
                //get filename with extension
                $filenamewithextension = $request->file('mobile_image')->getClientOriginalName();
                //get filename without extension
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                //get file extension
                $extension = $request->file('mobile_image')->getClientOriginalExtension();
                //filename to store
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                //filename to store
                $filename_to_store = preg_replace('/\s+/', '', $filename . '_' . $time . '.' . $extension);

                //generate a different thumbnail main_image and save into a folder
                $main_image = $request->file('mobile_image');
                $galleryImage = Image::make($main_image);
                $galleryImage->backup();
                $originalPath = public_path() . '/storage/uploads/gallery/mobile_image/';
                $thumbnailPath = public_path() . '/storage/uploads/gallery/mobile_image/thumbnail/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }

                $galleryImage->save($originalPath . $filename_to_store);

                $gallery->mobile_image = $filename_to_store;

                $galleryImage->resize(200, 200, function ($constraint) {
                    // $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $galleryImage->save($thumbnailPath . $admin);
                $galleryImage->reset();
            } else {
                $gallery->mobile_image = null;
            }

            if ($request->hasFile('document')) {
                // Get file details
                $file = $request->file('document');

                // Get file name with extension
                $filenamewithextension = $file->getClientOriginalName();

                // Get file name without extension
                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                // Replace spaces in filename with underscores
                $filename = str_replace(' ', '_', $filename);

                // Get file extension
                $extension = $file->getClientOriginalExtension();

                // Generate unique filename to store
                $filename_to_store = preg_replace('/\s+/', '', $filename . '_' . $time . '.' . $extension);

                // Define the directory where you want to store the documents
                $uploadPath = public_path('storage/uploads/gallery/document/');

                // Create the directory if it doesn't exist
                if (!File::isDirectory($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true, true);
                }

                // Store the document file
                $file->move($uploadPath, $filename_to_store);

                // Map the filename to your database column
                $gallery->document = $filename_to_store;
            } else {
                $gallery->document = null;
            }


            if ($request->youtube_link != null) {
                // dd($request->youtube_link1);
                $link = $request->youtube_link;
                if (strpos($link, 'watch?v=') !== false) {
                    $embedUrl = str_replace('watch?v=', 'embed/', $link);
                } else {
                    $embedUrl = $request->youtube_link;
                }
                $gallery->youtube_link = $embedUrl;
            }
            $gallery->type = $request->type;
            $gallery->caption = $request->caption;
            $gallery->save();

            return redirect()->route('admin.gallery.index')->withMessage("Gallery Added Successfully");
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $gallery = Gallery::findOrFail($id);
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate(
            [
                'youtube_link' => @$request->type == 'youtube_link' ? ['required', new ValidYouTubeLink] : 'nullable',
                'main_image' => @$request->type == 'image' ? 'image|mimes:jpeg,png,jpg,gif,svg|max:50000|dimensions:width=1116,height=1552' : 'nullable',
                'mobile_image' => @$request->type == 'image' ? 'image|mimes:jpeg,png,jpg,gif,svg|max:50000|dimensions:width=767,height=767' : 'nullable',
                'document' => @$request->type == 'document' ? 'mimes:pdf,doc,docx,xlsx,xls,csv|max:50000' : 'nullable',
                'type' => 'required|required',
                'caption' => 'nullable|string',
            ],
            $message = [
                'youtube_link.required' => 'Youtube link field is required',
                'youtube_link.regex' => 'Invalid youtube url',
                'main_image.image' => 'Main Image must be image',
                'mobile_image.image' => 'Mobile Image must be image',
                'type' => 'Type field is required',
                'main_image.required' => 'Main image field is required',
                'mobile_image.required' => 'Mobile image field is required',
                'description' => 'Description field in required',
                'mobile_image.dimensions' => 'Mobile image must be size of 767px X 767px',
                'main_image.dimensions' => 'Main image must be size of 1116px X 1552px ',
                'document.required' => 'Document field is required',
                'document.max' => 'Document size must be less than 5 MB',
                'document.mimes' => 'Document type must be pdf, doc, docx, xlsx, xls, csv',
            ],
        );
        $time = time();
        try {
            //check if request has main image
            if ($request->main_image) {
                if ($gallery->document) {
                    $path = public_path() . '/storage/uploads/gallery/document/';
                    if (File::exists($path . $gallery->document)) {
                        File::delete($path . $gallery->document);
                    }
                    $gallery->document = null;
                }
                if ($gallery->youtube_link) {
                    $gallery->youtube_link = null;
                }
                $path = public_path() . '/storage/uploads/gallery/main_image/';
                $thumbnail = public_path() . '/storage/uploads/gallery/main_image/thumbnail/';
                if (File::exists($path . $gallery->main_image)) {
                    File::delete($path . $gallery->main_image);
                }

                if (File::exists($thumbnail . 'admin_' . $gallery->main_image)) {
                    File::delete($thumbnail . 'admin_' . $gallery->main_image);
                }
                //get filename with extension
                $filenamewithextension = $request->file('main_image')->getClientOriginalName();
                //get filename without extension
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                //get file extension
                $extension = $request->file('main_image')->getClientOriginalExtension();
                //filename to store
                $filename_to_store_main_image = preg_replace('/\s+/', '', $filename . '_' . $time . '.' . $extension);
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $list = 'list_' . $filename . '_' . $time . '.' . $extension;

                //generate a different thumbnail image and save into a folder
                $main_image = $request->file('main_image');
                $galleryImage = Image::make($main_image);
                //backup status
                $galleryImage->backup();

                $originalPath = public_path() . '/storage/uploads/gallery/main_image/';
                $thumbnailPath = public_path() . '/storage/uploads/gallery/main_image/thumbnail/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }

                $galleryImage->save($originalPath . $filename_to_store_main_image);

                $gallery->main_image = $filename_to_store_main_image;

                //thumbnail for admin panel
                $galleryImage->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $galleryImage->sharpen(10);
                $galleryImage->save($thumbnailPath . $admin, 90);
                $galleryImage->reset();



                $galleryImage->resize(475, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $galleryImage->sharpen(10);
                $galleryImage->save($thumbnailPath . $list, 90);
                $galleryImage->reset();

            } else {
                if ($request->type == 'image') {
                    $gallery->main_image = $gallery->main_image;
                }
            }

            //check if request has small_image image
            if ($request->mobile_image) {
                if ($gallery->document) {
                    $path = public_path() . '/storage/uploads/gallery/document/';
                    if (File::exists($path . $gallery->document)) {
                        File::delete($path . $gallery->document);
                    }
                    $gallery->document = null;
                }
                if ($gallery->youtube_link) {
                    $gallery->youtube_link = null;
                }
                $path = public_path() . '/storage/uploads/gallery/mobile_image/';
                $thumbnail = public_path() . '/storage/uploads/gallery/mobile_image/thumbnail/';
                if (File::exists($path . $gallery->mobile_image)) {
                    File::delete($path . $gallery->mobile_image);
                }

                if (File::exists($thumbnail . 'admin_' . $gallery->mobile_image)) {
                    File::delete($thumbnail . 'admin_' . $gallery->mobile_image);
                }
                $filenamewithextension = $request->file('mobile_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('mobile_image')->getClientOriginalExtension();
                $filename_to_store_small_image = preg_replace('/\s+/', '', $filename . '_' . $time . '.' . $extension);
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $small_image = $request->file('mobile_image');
                $galleryImage = Image::make($small_image);
                $galleryImage->backup();

                $originalPath = public_path() . '/storage/uploads/gallery/mobile_image/';
                $thumbnailPath = public_path() . '/storage/uploads/gallery/mobile_image/thumbnail/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }

                $galleryImage->save($originalPath . $filename_to_store_small_image);

                $gallery->mobile_image = $filename_to_store_small_image;

                $galleryImage->resize(200, 200, function ($constraint) {
                    $constraint->upsize();
                });
                $galleryImage->save($thumbnailPath . $admin);
                $galleryImage->reset();
            } else {
                if ($request->type == 'image') {
                    $gallery->mobile_image = $gallery->mobile_image;
                }
            }

            if ($request->hasFile('document')) {
                if ($gallery->main_image) {
                    $path = public_path() . '/storage/uploads/gallery/main_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/gallery/main_image/thumbnail/admin_';
                    if (File::exists($path . $gallery->main_image)) {
                        File::delete($path . $gallery->main_image);
                    }

                    if (File::exists($thumbnailPath . $gallery->main_image)) {
                        File::delete($thumbnailPath . $gallery->main_image);
                    }
                    $gallery->main_image = null;
                }
                if ($gallery->mobile_image) {
                    $mpath = public_path() . '/storage/uploads/gallery/mobile_image/';
                    $mthumbnailPath = public_path() . '/storage/uploads/gallery/mobile_image/thumbnail/admin_';
                    if (File::exists($mpath . $gallery->mobile_image)) {
                        File::delete($mpath . $gallery->mobile_image);
                    }

                    if (File::exists($mthumbnailPath . $gallery->mobile_image)) {
                        File::delete($mthumbnailPath . $gallery->mobile_image);
                    }
                    $gallery->mobile_image = null;
                }
                if ($gallery->youtube_link) {
                    $gallery->youtube_link = null;
                }
                $path = public_path() . '/storage/uploads/gallery/document/';
                if (File::exists($path . $gallery->document)) {
                    File::delete($path . $gallery->document);
                }
                $file = $request->file('document');

                $filenamewithextension = $file->getClientOriginalName();

                $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);

                $filename = str_replace(' ', '_', $filename);

                $extension = $file->getClientOriginalExtension();

                $filename_to_store = preg_replace('/\s+/', '', $filename . '_' . $time . '.' . $extension);

                $uploadPath = public_path('storage/uploads/gallery/document/');

                if (!File::isDirectory($uploadPath)) {
                    File::makeDirectory($uploadPath, 0777, true, true);
                }

                $file->move($uploadPath, $filename_to_store);
                $gallery->document = $filename_to_store;
            } else {
                if ($request->type == 'document') {
                    $gallery->document = $gallery->document;
                }
            }
            if ($request->type == 'youtube_link') {
                if ($gallery->document) {
                    $path = public_path() . '/storage/uploads/gallery/document/';
                    if (File::exists($path . $gallery->document)) {
                        File::delete($path . $gallery->document);
                    }

                    $gallery->document = null;
                }
                if ($gallery->main_image) {
                    $path = public_path() . '/storage/uploads/gallery/main_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/gallery/main_image/thumbnail/admin_';
                    $adminPath = public_path() . '/storage/uploads/gallery/main_image/thumbnail/list_';
                    if (File::exists($path . $gallery->main_image)) {
                        File::delete($path . $gallery->main_image);
                    }

                    if (File::exists($thumbnailPath . $gallery->main_image)) {
                        File::delete($thumbnailPath . $gallery->main_image);
                    }

                    if (File::exists($adminPath . $gallery->main_image)) {
                        File::delete($adminPath . $gallery->main_image);
                    }

                    $gallery->main_image = null;
                }
                if ($gallery->mobile_image) {
                    $mpath = public_path() . '/storage/uploads/gallery/mobile_image/';
                    $mthumbnailPath = public_path() . '/storage/uploads/gallery/mobile_image/thumbnail/admin_';
                    if (File::exists($mpath . $gallery->mobile_image)) {
                        File::delete($mpath . $gallery->mobile_image);
                    }

                    if (File::exists($mthumbnailPath . $gallery->mobile_image)) {
                        File::delete($mthumbnailPath . $gallery->mobile_image);
                    }

                    $gallery->mobile_image = null;
                }
                $link = $request->youtube_link;
                if (strpos($link, 'watch?v=') !== false) {
                    $embedUrl = str_replace('watch?v=', 'embed/', $link);
                } else {
                    $embedUrl = $link;
                }
            }
            $gallery->youtube_link = @$embedUrl;
            $gallery->type = $request->type;
            $gallery->caption = $request->caption;
            $gallery->update();

            return redirect()->route('admin.gallery.index')->withMessage('Gallery Updated Successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        $gallery = Gallery::find($id);
        $gallery->delete();
        $message = 'Gallery Deleted';
        return redirect()
            ->back()
            ->withMessage('Gallery Deleted Successfully!');
    }
}
