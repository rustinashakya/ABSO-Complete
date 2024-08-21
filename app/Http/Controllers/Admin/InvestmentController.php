<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ivestment\StoreInvestmentRequest;
use App\Http\Requests\Ivestment\UpdateInvestmentRequest;
use App\Models\Investment;
use App\Models\InvestmentLanguage;
use App\Models\Page;
use App\Models\ProjectType;
use App\Models\SiteSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class InvestmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Investment access', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Investment delete', ['only' => ['destroy']]);
        $this->middleware('role_or_permission:Investment create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Investment edit', ['only' => ['edit', 'update']]);
    }

    public function index(Request $request)
    {
        $investments = Investment::latest()
            ->searchInvestment($request->title, $request->slug, $request->stage, $request->project_type_id, $request->page_id)
            ->paginate(15);
        $projectTypes = ProjectType::get();
        $sectors = Page::where('type', 'sector')->get();

        return view('admin.investment.index', compact('investments', 'projectTypes', 'sectors'));
    }

    public function create()
    {
        $pages = Page::where('type', 'sector')->get();
        $projectTypes = ProjectType::get();
        return view('admin.investment.create', compact('pages', 'projectTypes'));
    }

    public function store(StoreInvestmentRequest $request)
    {
        try {
            $time =  time();
            if ($request->hasfile('main_image')) {
                $filenamewithextension = $request->file('main_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('main_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $list = 'list_' . $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('main_image');
                $originalPath = public_path() . '/storage/uploads/investment/main_image/';
                $thumbnailPath = public_path() . '/storage/uploads/investment/main_image/thumbnail/';
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

                //list page
                $categoryImage->resize(405, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $list, 90);
                $categoryImage->reset();

                //admin page
                $categoryImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin, 90);
                $categoryImage->reset();
            } else {
                $main_image = null;
            }
            if ($request->hasfile('mobile_image')) {
                $filenamewithextension = $request->file('mobile_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('mobile_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;


                $mobile_image = $request->file('mobile_image');
                $categoryImage = Image::make($mobile_image);
                $categoryImage->backup();
                $originalPath = public_path() . '/storage/uploads/investment/mobile_image/';
                $thumbnailPath = public_path() . '/storage/uploads/investment/mobile_image/thumbnail/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }
                $categoryImage->save($originalPath . $filename_to_store);

                $mobile_image = $filename_to_store;

                //admin page
                $categoryImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin, 90);
                $categoryImage->reset();
            } else {
                $mobile_image = null;
            }

            $investment = Investment::create([
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'description' => $request->description,
                'capital' => $request->capital,
                'start_year' => $request->start_year,
                'payback_period' => $request->payback_period,
                'roi' => $request->roi,
                'page_id' => $request->page_id,
                'project_type_id' => $request->project_type_id,
                'stage' => $request->stage,
                'short_description' => $request->short_description,
                'main_image' => @$main_image,
                'mobile_image' => @$mobile_image,
                'type_of_service' => $request->type_of_service ?? 'investment',

                //meta
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword
            ]);

            $setting = SiteSetting::first()->language_id;
            $investmentLanguage = InvestmentLanguage::updateOrCreate([
                'investment_id' => $investment->id,
                'language_id' => $setting
            ], [
                'title' => $request->title,
                'description' => $request->description
            ]);

            return redirect(route('admin.investment.index'))->withMessage('Investment Created Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $investment = Investment::find($id);
        $pages = Page::where('type', 'sector')->get();
        $projectTypes = ProjectType::get();

        return view('admin.investment.edit', compact('investment', 'pages', 'projectTypes'));
    }

    public function update(UpdateInvestmentRequest $request, $id)
    {
        $investment = Investment::find($id);
        try {
            $time = time();

            if ($request->hasfile('main_image')) {
                Storage::delete('storage/uploads/investment/main_image/' . $investment->main_image);
                Storage::delete('storage/uploads/investment/main_image/thumbnail/admin_' . $investment->main_image);

                $filenamewithextension = $request->file('main_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('main_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $list = 'list_' . $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('main_image');
                $originalPath = public_path() . '/storage/uploads/investment/main_image/';
                $thumbnailPath = public_path() . '/storage/uploads/investment/main_image/thumbnail/';
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

                //list page
                $categoryImage->resize(405, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $list, 90);
                $categoryImage->reset();

                //admin page
                $categoryImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin, 90);
                $categoryImage->reset();
            }

            if ($request->hasfile('mobile_image')) {
                Storage::delete('storage/uploads/investment/mobile_image/' . $investment->mobile_image);
                Storage::delete('storage/uploads/investment/mobile_image/thumbnail/admin_' . $investment->mobile_image);

                $filenamewithextension = $request->file('mobile_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('mobile_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;


                $mobile_image = $request->file('mobile_image');
                $categoryImage = Image::make($mobile_image);
                $categoryImage->backup();
                $originalPath = public_path() . '/storage/uploads/investment/mobile_image/';
                $thumbnailPath = public_path() . '/storage/uploads/investment/mobile_image/thumbnail/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);
                }
                $categoryImage->save($originalPath . $filename_to_store);

                $mobile_image = $filename_to_store;

                //admin page
                $categoryImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin, 90);
                $categoryImage->reset();
            }

            $investment->update([
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'description' => $request->description,
                'capital' => $request->capital,
                'start_year' => $request->start_year,
                'payback_period' => $request->payback_period,
                'roi' => $request->roi,
                'page_id' => $request->page_id,
                'project_type_id' => $request->project_type_id,
                'stage' => $request->stage,
                'short_description' => $request->short_description,
                'main_image' => $main_image ?? $investment->main_image,
                'mobile_image' => $mobile_image ?? $investment->mobile_image,
                'type_of_service' => $request->type_of_service ?? 'investment',

                //meta data
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword
            ]);

            $setting = SiteSetting::first()->language_id;
            $investmentLanguage = InvestmentLanguage::updateOrCreate([
                'investment_id' => $investment->id,
                'language_id' => $setting
            ], [
                'title' => $request->title,
                'description' => $request->description
            ]);

            return redirect(route('admin.investment.index'))->withMessage('Investment Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $investment = Investment::find($id);
        $investment->delete();

        return redirect(route('admin.investment.index'))->withMessage('Investment Deleted Successfully');
    }
}
