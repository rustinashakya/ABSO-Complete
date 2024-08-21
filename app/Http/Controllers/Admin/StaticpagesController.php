<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Models\LanguagePage;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class StaticpagesController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Page access', ['only' => ['index']]);
        $this->middleware('role_or_permission:Page create', ['only' => ['add', 'store']]);
        $this->middleware('role_or_permission:Page edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Page delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $title = $request->name;
        $slug = $request->slug;
        $get_pages = Page::with('pageLanguages')->where('type', 'static_page')
            ->searchPage($title, $slug)
            ->orderBy('order_by', 'asc')
            ->Paginate(10);
        return view('admin.static_pages.index', compact('get_pages'));
    }
    public function add()
    {
        return view('admin.static_pages.add');
    }

    public function store(StorePageRequest $request)
    {
        try {
            $time = time();

            if ($request->hasfile('main_image')) {
                $filenamewithextension = $request->file('main_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('main_image')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;

                //detail page thumbnail name
                $details_thumbnail = 'details_' . $filename . '_' . $time . '.' . $extension;
                $admin_thumbnail = 'admin_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('main_image');
                $thumbnailPath = public_path() . '/storage/uploads/static_pages/main_image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/static_pages/main_image/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }
                $categoryImage = Image::make($main_image);
                $categoryImage->backup();

                $categoryImage->save($originalPath . $filename_to_store);
                $main_image = $filename_to_store;

                //thumbnail for admin panel

                $categoryImage->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin_thumbnail, 90);
                $categoryImage->reset();
            } else {
                $main_image = null;
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
                $filename_to_store = $filename . '_' . $time . '.' . $extension;

                $mobile_image = $request->file('mobile_image');
                $categoryImage = Image::make($mobile_image);
                $categoryImage->backup();

                $originalPath = public_path() . '/storage/uploads/static_pages/mobile_image/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                $categoryImage->save($originalPath . $filename_to_store);

                $mobile_image = $filename_to_store;
            } else {
                $mobile_image = null;
            }

            $page = Page::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'type' => $request->type ?? 'static_page',
                'sub_title'=> $request->sub_title,
                'description' => $request->description,
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'main_image' => @$main_image,
                'mobile_image' => @$mobile_image,
                'youtube_link' => @$request->youtube_link,
            ]);

            $message = 'Static Page Created Successfully!';
            return redirect()->route('admin.static.pages.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($page_id)
    {
        $page = Page::findOrFail($page_id);
        return view('admin.static_pages.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, $page_id)
    {
        try {
            $page = Page::find($page_id);
            $time = time();

            if ($request->media_type == 'image1') {
                if ($request->file('main_image')) {
                    Storage::delete('storage/uploads/static_pages/main_image/' . $page->main_image);
                    Storage::delete('storage/uploads/static_pages/main_image/thumbnail/details_' . $page->main_image);
                    Storage::delete('storage/uploads/static_pages/main_image/thumbnail/admin_' . $page->main_image);

                    $filenamewithextension = $request->file('main_image')->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $request->file('main_image')->getClientOriginalExtension();
                    //filename to store
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;

                    //detail page thumbnail 
                    $details_thumbnail = 'details_' . $filename . '_' . $time . '.' . $extension;
                    //detail page admin panel
                    $admin_thumbnail = 'admin_' . $filename . '_' . $time . '.' . $extension;

                    $main_image = $request->file('main_image');
                    $thumbnailPath = public_path() . '/storage/uploads/static_pages/main_image/thumbnail/';
                    $originalPath = public_path() . '/storage/uploads/static_pages/main_image/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }
                    if (!File::isDirectory($thumbnailPath)) {
                        File::makeDirectory($thumbnailPath, 0777, true, true);

                        // retry storing the file in newly created path.
                    }
                    $categoryImage = Image::make($main_image);
                    $categoryImage->backup();

                    $categoryImage->save($originalPath . $filename_to_store);
                    $main_image = $filename_to_store;

                    //thumbnail for admin panel

                    $categoryImage->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $admin_thumbnail, 90);
                    $categoryImage->reset();
                }

                if ($request->file('mobile_image')) {
                    Storage::delete('storage/uploads/static_pages/mobile_image/' . $page->mobile_image);

                    //get filename with extension
                    $filenamewithextension = $request->file('mobile_image')->getClientOriginalName();
                    //get filename without extension
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    //get file extension
                    $extension = $request->file('mobile_image')->getClientOriginalExtension();
                    //filename to store
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;

                    $mobile_image = $request->file('mobile_image');
                    $categoryImage = Image::make($mobile_image);
                    $categoryImage->backup();

                    $originalPath = public_path() . '/storage/uploads/static_pages/mobile_image/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }

                    $categoryImage->save($originalPath . $filename_to_store);

                    $mobile_image = $filename_to_store;
                }
            } elseif ($request->media_type == 'youtube1') {
                Storage::delete('storage/uploads/static_pages/main_image/' . $page->main_image);
                Storage::delete('storage/uploads/static_pages/main_image/thumbnail/details_' . $page->main_image);
                Storage::delete('storage/uploads/static_pages/main_image/thumbnail/admin_' . $page->main_image);
                Storage::delete('storage/uploads/static_pages/mobile_image/' . $page->mobile_image);
            }

            $page->Update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->slug),
                'sub_title'=> $request->sub_title,
                'description' => $request->description,
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'youtube_link' => $request->media_type == 'youtube1' ? $request->youtube_link : null,
                'type' => $request->type ?? 'static_page',
                'main_image' => $request->media_type == 'image1' ? (@$main_image ?? $page->main_image) : null,
                'mobile_image' => $request->media_type == 'image1' ? (@$mobile_image ?? $page->mobile_image) : null,
            ]);

            $message = 'Static Page Updated Successfully!';
            return redirect()->route('admin.static.pages.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($page_id)
    {
        $page = Page::where('id', $page_id)->delete();
        $message = 'Static Page Deleted Successfully!';
        return redirect()->back()->withMessage($message);
    }
}
