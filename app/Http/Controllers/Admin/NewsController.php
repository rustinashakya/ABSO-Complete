<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Requests\News\UpdateNewsRequest;
use App\Models\News;
use App\Models\NewsLanguage;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->name;
        $slug = $request->slug;
        $to = $request->to;
        $from = $request->from;
        $news = News::orderBy('published_date', 'desc')
            ->searchPage($title, $slug, $to, $from)
            ->Paginate(15);

        return view('admin.news.index', compact('news'));
    }

    public function create()
    {
        return view('admin.news.add');
    }

    public function store(StoreNewsRequest $request)
    {
        try {
            $time = time();

            if ($request->hasFile('main_image')) {
                $image = $request->file('main_image');
                $extension = $image->getClientOriginalExtension();
                $filename1 = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $news_list = 'list_' . $filename . '_' . $time . '.' . $extension;
                $news_details = 'details_' . $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $home = 'home_' . $filename . '_' . $time . '.' . $extension;


                if ($extension !== 'pdf') {
                    $originalPath = public_path('/storage/uploads/news/main_image/');
                    $thumbnailPath = public_path('/storage/uploads/news/main_image/thumbnail/');
                    $mobilePath = public_path('/storage/uploads/news/mobile/');
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }
                    if (!File::isDirectory($thumbnailPath)) {
                        File::makeDirectory($thumbnailPath, 0777, true, true);
                    }
                    if (!File::isDirectory($mobilePath)) {
                        File::makeDirectory($mobilePath, 0777, true, true);
                    }
                    $categoryImage = Image::make($image);
                    $categoryImage->save($originalPath . $filename_to_store);
                    $categoryImage->backup();

                    //list page
                    $categoryImage->resize(370, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(15);
                    $categoryImage->save($thumbnailPath . $news_list, 90);
                    $categoryImage->reset();

                    //home page
                    // $categoryImage->resize(370, null, function ($constraint) {
                    //     $constraint->aspectRatio();
                    //     $constraint->upsize();
                    // });
                    // $categoryImage->sharpen(10);
                    // $categoryImage->save($thumbnailPath . $home, 90);
                    // $categoryImage->reset();
                    
                    //admin page
                    $categoryImage->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(15);
                    $categoryImage->save($thumbnailPath . $admin, 90);
                    $categoryImage->reset();

                    //details page
                    // $categoryImage->resize(1540, 810, function ($constraint) {
                    //     // $constraint->aspectRatio();
                    //     $constraint->upsize();
                    // });
                    // $categoryImage->save($thumbnailPath . $news_details);
                    // $categoryImage->reset();


                    //mboile image
                    $categoryImage->resize(767, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(15);
                    $categoryImage->save($mobilePath . $filename_to_store, 90);
                    $categoryImage->reset();

                    $main_image = $filename_to_store;
                    $mobile_image = $filename_to_store;
                } else {

                    $main_image = null;
                    $mobile_image = null;
                }
            }

            $news = News::create([
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'published_date' => $request->published_date,
                'youtube_link' => @$request->youtube_link,
                'main_image' => @$main_image,
                'mobile_image' => @$mobile_image,
                'description' => $request->description,
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'author'=> @$request->author,
            ]);
            $setting = SiteSetting::first()->language_id;
            NewsLanguage::updateOrCreate([
                'news_id' => $news->id,
                'language_id' => $setting,
            ], [
                'title' => $request->title,
                'description' => $request->description,
            ]);

            return redirect()->route('admin.news.index')->withMessage('News Added Successfully!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function view($id)
    {
        $new_s = News::findOrFail($id);
        return view('admin.news.view', compact('new_s'));
    }

    public function edit($id)
    {
        $new_s = News::findOrFail($id);
        return view('admin.news.edit', compact('new_s'));
    }

    public function update(UpdateNewsRequest $request, $id)
    {
        $news = News::findOrFail($id);
        try {
            $time = time();

            if ($request->hasFile('main_image')) {

                //delete existing file
                Storage::delete('public/uploads/news/main_image/' . $news->main_image);
                Storage::delete('public/uploads/news/mobile_image/' . $news->mobile_image);
                Storage::delete('public/uploads/news/main_image/thumbnail/list_' . $news->main_image);
                Storage::delete('public/uploads/news/main_image/thumbnail/details_' . $news->main_image);
                Storage::delete('public/uploads/news/main_image/thumbnail/admin_' . $news->main_image);

                $image = $request->file('main_image');
                $extension = $image->getClientOriginalExtension();
                $filename1 = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $news_list = 'list_' . $filename . '_' . $time . '.' . $extension;
                $news_details = 'details_' . $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $home = 'home_' . $filename . '_' . $time . '.' . $extension;

                if ($extension !== 'pdf') {
                    $originalPath = public_path('/storage/uploads/news/main_image/');
                    $thumbnailPath = public_path('/storage/uploads/news/main_image/thumbnail/');
                    $mobilePath = public_path('/storage/uploads/news/mobile/');
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }
                    if (!File::isDirectory($thumbnailPath)) {
                        File::makeDirectory($thumbnailPath, 0777, true, true);
                    }
                    $categoryImage = Image::make($image);
                    $categoryImage->save($originalPath . $filename_to_store);
                    $categoryImage->backup();

                    //list page
                    $categoryImage->resize(370, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(15);
                    $categoryImage->save($thumbnailPath . $news_list, 90);
                    $categoryImage->reset();

                    //admin page
                    $categoryImage->resize(200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(15);
                    $categoryImage->save($thumbnailPath . $admin, 90);
                    $categoryImage->reset();

                    // //details page
                    // $categoryImage->resize(1540, 810, function ($constraint) {
                    //     // $constraint->aspectRatio();
                    //     $constraint->upsize();
                    // });
                    // $categoryImage->save($thumbnailPath . $news_details);
                    // $categoryImage->reset();

                    //home page
                    $categoryImage->resize(370, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(15);
                    $categoryImage->save($thumbnailPath . $home, 90);
                    $categoryImage->reset();
                    
                    //mboile image
                    $categoryImage->resize(767, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(15);
                    $categoryImage->save($mobilePath . $filename_to_store, 90);
                    $categoryImage->reset();

                    $main_image = $filename_to_store;
                    $mobile_image = $filename_to_store;
                    $youtube_link = null;
                }
            }
            if ($request->type == 'youtube' && !empty($request->youtube_link)) {
                if ($news->main_image) {
                    Storage::delete('public/uploads/news/main_image/' . $news->main_image);
                    Storage::delete('public/uploads/news/mobile_image/' . $news->mobile_image);
                }
                $main_image = null;
                $mobile_image = null;
                $youtube_link = $request->youtube_link;
            }

            $news->update([
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'published_date' => $request->published_date,
                'youtube_link' => @$youtube_link,
                'main_image' => $main_image ?? $news->main_image,
                'mobile_image' => @$mobile_image,
                'description' => $request->description,
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'author'=> @$request->author,
            ]);

            $setting = SiteSetting::first()->language_id;
            NewsLanguage::updateOrCreate([
                'news_id' => $news->id,
                'language_id' => $setting,
            ], [
                'title' => $request->title,
                'description' => $request->description,
            ]);

            $message = 'News Updated Successfully!';

            return redirect()->route('admin.news.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        $notice = News::findOrFail($id);
        $notice->delete();

        $message = 'News Deleted Successfully!';
        return redirect()->back()->withMessage($message);
    }
}
