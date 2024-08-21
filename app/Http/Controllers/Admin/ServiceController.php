<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\LanguagePage;
use App\Models\Page;
use App\Models\ServiceAccordion;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class ServiceController extends Controller
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
        $services = Page::with('pageLanguages')->where('type', 'service')->searchPage($request->name)->orderBy('order_by', 'asc')->Paginate(10);
        return view('admin.services.index', compact('services'));
    }
    public function create()
    {
        return view('admin.services.create');
    }

    public function store(StoreServiceRequest $request)
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
                $home_page_to_store = 'home_' . $filename . '_' . $time . '.' . $extension;
                $list_to_store = 'list_' . $filename . '_' . $time . '.' . $extension;
                $admin_to_store = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $details_to_store = 'details_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('main_image');
                $originalPath = public_path() . '/storage/uploads/services/main_image/';
                $thumbnailPath = public_path() . '/storage/uploads/services/main_image/thumbnail/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }
                $categoryImage = Image::make($main_image);
                $categoryImage->backup();

                $categoryImage->save($originalPath . $filename_to_store);
                $main_image = $filename_to_store;

                //image resize
                //thumbnail for home page

                $categoryImage->resize(420, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $home_page_to_store, 90);
                $categoryImage->reset();

                //thumbnail for list page
                $categoryImage->resize(370, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->save($thumbnailPath . $list_to_store, 90);
                $categoryImage->reset();

                //thumbnail for admin
                $categoryImage->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin_to_store, 90);
                $categoryImage->reset();
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

                $originalPath = public_path() . '/storage/uploads/services/mobile_image/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                $categoryImage->save($originalPath . $filename_to_store);

                $mobile_image = $filename_to_store;
            }

            $page = Page::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'type' => $request->type ?? 'service',
                'description' => $request->description,
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'main_image' => @$main_image,
                'mobile_image' => @$mobile_image,
                'youtube_link' => @$request->youtube_link,
                'sub_title' => $request->sub_title,
                'order_by' => $request->order_by,
            ]);

            $message = 'Service Created Successfully!';
            return redirect()->route('admin.services.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($page_id)
    {
        $service = Page::findOrFail($page_id);
        $serviceAccordians = ServiceAccordion::where('page_id', $page_id)->get();
        return view('admin.services.edit', compact('service', 'serviceAccordians'));
    }

    public function update(UpdateServiceRequest $request, $page_id)
    {
        // dd($request->rows[1]['title']);
        try {
            $page = Page::find($page_id);
            $time = time();

            if ($request->media_type == 'image1') {
                if ($request->file('main_image')) {
                    Storage::delete('storage/uploads/services/main_image/' . $page->main_image);
                    Storage::delete('storage/uploads/services/main_image/thumbnail/home_' . $page->main_image);
                    Storage::delete('storage/uploads/services/main_image/thumbnail/admin_' . $page->main_image);
                    Storage::delete('storage/uploads/services/main_image/thumbnail/details_' . $page->main_image);
                    Storage::delete('storage/uploads/services/main_image/thumbnail/list_' . $page->main_image);

                    $filenamewithextension = $request->file('main_image')->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $request->file('main_image')->getClientOriginalExtension();
                    //filename to store
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;
                    $list_to_store = 'list_' . $filename . '_' . $time . '.' . $extension;
                    $details_to_store = 'details_' . $filename . '_' . $time . '.' . $extension;
                    $home_page_to_store = 'home_' . $filename . '_' . $time . '.' . $extension;
                    $admin_to_store = 'admin_' . $filename . '_' . $time . '.' . $extension;

                    $main_image = $request->file('main_image');
                    $originalPath = public_path() . '/storage/uploads/services/main_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/services/main_image/thumbnail/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }
                    $categoryImage = Image::make($main_image);
                    $categoryImage->backup();

                    $categoryImage->save($originalPath . $filename_to_store);
                    $main_image = $filename_to_store;

                    //image resize
                    //thumbnail for home page

                    $categoryImage->resize(420, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $home_page_to_store, 90);
                    $categoryImage->reset();

                    //thumbnail for list page
                    $categoryImage->resize(370, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $list_to_store, 90);
                    $categoryImage->reset();

                    //thumbnail for admin
                    $categoryImage->resize(300, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $admin_to_store, 90);
                    $categoryImage->reset();
                }

                if ($request->file('mobile_image')) {
                    Storage::delete('storage/uploads/services/mobile_image/' . $page->mobile_image);

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

                    $originalPath = public_path() . '/storage/uploads/services/mobile_image/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }

                    $categoryImage->save($originalPath . $filename_to_store);

                    $mobile_image = $filename_to_store;
                }
            } elseif ($request->media_type == 'youtube1') {
                Storage::delete('storage/uploads/services/main_image/' . $page->main_image);
                Storage::delete('storage/uploads/services/main_image/thumbnail/home_' . $page->main_image);
                Storage::delete('storage/uploads/services/main_image/thumbnail/list_' . $page->main_image);
                Storage::delete('storage/uploads/services/main_image/thumbnail/details_' . $page->main_image);
                Storage::delete('storage/uploads/services/main_image/thumbnail/admin_' . $page->main_image);
                Storage::delete('storage/uploads/services/mobile_image/' . $page->mobile_image);
            }

            $page->Update([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->slug),
                'description' => $request->description,
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'youtube_link' => $request->media_type == 'youtube1' ? $request->youtube_link : null,
                'type' => $request->type ?? 'service',
                'main_image' => $request->media_type == 'image1' ? (@$main_image ?? $page->main_image) : null,
                'mobile_image' => $request->media_type == 'image1' ? (@$mobile_image ?? $page->mobile_image) : null,
                'sub_title' => $request->sub_title,
                'order_by' => $request->order_by,
            ]);

            $message = 'Service Updated Successfully!';
            return redirect()->route('admin.services.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($page_id)
    {
        $page = Page::where('id', $page_id)->first();
        
        $page->delete();
        $message = 'Service Deleted Successfully!';
        return redirect()->back()->withMessage($message);
    }
}
