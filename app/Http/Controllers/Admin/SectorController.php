<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Page\StorePageRequest;
use App\Http\Requests\Page\UpdatePageRequest;
use App\Http\Requests\StoreSectorRequest;
use App\Http\Requests\UpdateSectorRequest;
use App\Models\LanguagePage;
use App\Models\Page;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class SectorController extends Controller
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
        $sectors = Page::with('pageLanguages')->where('type', 'sector')->searchPage($request->name, $request->slug)->orderBy('order_by', 'asc')->Paginate(10);
        return view('admin.sectors.index', compact('sectors'));
    }
    public function create()
    {
        $parentSectors = Page::where('type', 'sector')->where('parent_id', null)->get();
        return view('admin.sectors.create', compact('parentSectors'));
    }

    public function store(StoreSectorRequest $request)
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

                //home page thumbnail name
                $home_thumbnail = 'home_' . $filename . '_' . $time . '.' . $extension;
                $admin_thumbnail = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $list_thumbnail = 'list_' .$filename . '_' . $time . '.' . $extension;
                $main_image = $request->file('main_image');
                $thumbnailPath = public_path() . '/storage/uploads/sectors/main_image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/sectors/main_image/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }
                $sectorImage = Image::make($main_image);
                $sectorImage->backup();

                $sectorImage->save($originalPath . $filename_to_store);
                $main_image = $filename_to_store;

                //thumbnail for home page

                $sectorImage->resize(405, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                // $sectorImage->sharpen(10);
                $sectorImage->save($thumbnailPath . $home_thumbnail);
                $sectorImage->reset();

                //thumbnail for list page

                $sectorImage->resize(null, 450, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $sectorImage->sharpen(10);
                $sectorImage->save($thumbnailPath . $list_thumbnail);
                $sectorImage->reset();

                //thumbnail for admin

                $sectorImage->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $sectorImage->sharpen(10);
                $sectorImage->save($thumbnailPath . $admin_thumbnail, 90);
                $sectorImage->reset();
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

                $originalPath = public_path() . '/storage/uploads/sectors/mobile_image/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }

                $categoryImage->save($originalPath . $filename_to_store);

                $mobile_image = $filename_to_store;
            }

            $page = Page::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'parent_id' => $request->parent_id ?? null,
                'type' => $request->type ?? 'sector',
                'description' => $request->description,
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'main_image' => @$main_image,
                'mobile_image' => @$mobile_image,
                'youtube_link' => @$request->youtube_link,
            ]);

            $message = 'Sector Created Successfully!';
            return redirect()->route('admin.sectors.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($page_id)
    {
        $parentSectors = Page::where('type', 'sector')->where('parent_id', null)->get();
        $sector = Page::findOrFail($page_id);
        return view('admin.sectors.edit', compact('sector', 'parentSectors'));
    }

    public function update(UpdateSectorRequest $request, $page_id)
    {
        try {
            $page = Page::find($page_id);
            $time = time();

            if ($request->media_type == 'image1') {
                if ($request->file('main_image')) {
                    Storage::delete('storage/uploads/sectors/main_image/' . $page->main_image);
                    Storage::delete('storage/uploads/sectors/main_image/thumbnail/home_' . $page->main_image);
                    Storage::delete('storage/uploads/sectors/main_image/thumbnail/admin_' . $page->main_image);

                    $filenamewithextension = $request->file('main_image')->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $request->file('main_image')->getClientOriginalExtension();
                    //filename to store
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;

                    //home page thumbnail name
                    $home_thumbnail = 'home_' . $filename . '_' . $time . '.' . $extension;
                    $admin_thumbnail = 'admin_' . $filename . '_' . $time . '.' . $extension;
                    $list_thumbnail = 'list_' . $filename . '_' . $time . '.' . $extension;

                    $main_image = $request->file('main_image');
                    $thumbnailPath = public_path() . '/storage/uploads/sectors/main_image/thumbnail/';
                    $originalPath = public_path() . '/storage/uploads/sectors/main_image/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }
                    if (!File::isDirectory($thumbnailPath)) {
                        File::makeDirectory($thumbnailPath, 0777, true, true);
    
                        // retry storing the file in newly created path.
                    }
                    $sectorImage = Image::make($main_image);
                    $sectorImage->backup();

                    $sectorImage->save($originalPath . $filename_to_store);
                    $main_image = $filename_to_store;

                    //thumbnail for home page

                    $sectorImage->resize(405, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    // $sectorImage->sharpen(10);
                    $sectorImage->save($thumbnailPath . $home_thumbnail);
                    $sectorImage->reset();

                    //thumbnail for list page

                $sectorImage->resize(null, 450, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $sectorImage->sharpen(10);
                $sectorImage->save($thumbnailPath . $list_thumbnail);
                $sectorImage->reset();

                    //thumbnail for admin

                $sectorImage->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $sectorImage->sharpen(10);
                $sectorImage->save($thumbnailPath . $admin_thumbnail, 90);
                $sectorImage->reset();
                }

                if ($request->file('mobile_image')) {
                    Storage::delete('storage/uploads/sectors/mobile_image/' . $page->mobile_image);

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

                    $originalPath = public_path() . '/storage/uploads/sectors/mobile_image/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }

                    $categoryImage->save($originalPath . $filename_to_store);

                    $mobile_image = $filename_to_store;
                }
            } elseif ($request->media_type == 'youtube1') {
                Storage::delete('storage/uploads/sectors/main_image/' . $page->main_image);
                Storage::delete('storage/uploads/sectors/main_image/thumbnail/home_' . $page->mobile_image);
                Storage::delete('storage/uploads/sectors/main_image/thumbnail/admin_' . $page->mobile_image);
                Storage::delete('storage/uploads/sectors/mobile_image/' . $page->mobile_image);
            }

            $page->Update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'parent_id' => $request->parent_id ?? null,
                'description' => $request->description,
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'youtube_link' => $request->media_type == 'youtube1' ? $request->youtube_link : null,
                'type' => $request->type ?? 'sector',
                'main_image' => $request->media_type == 'image1' ? (@$main_image ?? $page->main_image) : null,
                'mobile_image' => $request->media_type == 'image1' ? (@$mobile_image ?? $page->mobile_image) : null,
            ]);

            $message = 'Sector Updated Successfully!';
            return redirect()->route('admin.sectors.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($page_id)
    {
        $page = Page::where('id', $page_id)->delete();
        $message = 'Sector Deleted Successfully!';
        return redirect()->back()->withMessage($message);
    }
}
