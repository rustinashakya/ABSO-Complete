<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Models\Page;
use App\Models\Project;
use App\Models\ProjectImage;
use App\Models\ProjectKpi;
use App\Models\ProjectLanguage;
use App\Models\ProjectType;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ProjectController extends Controller
{
    public function __construct()
    {
        $this->middleware('role_or_permission:Project access', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Project create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Project edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Project delete', ['only' => ['delete']]);
    }

    public function index(Request $request)
    {
        $projects = Project::with('page', 'projectType')
            ->searchProject($request->title, $request->slug, $request->project_type_id, $request->page_id, $request->stage)
            ->latest()->paginate(15);
        $projectTypes = ProjectType::get();
        $sectors = Page::where('type', 'sector')->get();
        return view('admin.project.index', compact('projects', 'projectTypes', 'sectors'));
    }

    public function create()
    {
        $pages = Page::where('type', 'sector')->get();
        $projectTypes = ProjectType::get();
        $services = Page::where('type', 'service')->get();

        return view('admin.project.create', compact('pages', 'projectTypes', 'services'));
    }

    public function store(StoreProjectRequest $request)
    {
        try {
            $project = Project::create([
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'short_description' => $request->short_description,
                'description' => $request->description,
                'project_type_id' => $request->project_type_id,
                'page_id' => $request->page_id,
                'service_id' => $request->service_id,
                'stage' => $request->stage,
                'show_on_menu' => $request->show_on_menu ?? 0,
                'show' => $request->show ?? 1,

                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);

            $setting = SiteSetting::first()->language_id;
            $projectLanguage = ProjectLanguage::updateOrCreate([
                'language_id' => $setting,
                'project_id' => $project->id
            ], [
                'title' => $request->title,
                'short_description' => $request->short_description,
                'description' => $request->description,
            ]);

            $time = time();
            if ($request->hasfile('main_image')) {
                foreach ($request->main_image as $image) {
                    $filenamewithextension = $image->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $image->getClientOriginalExtension();
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;
                    $home_h = 'home_h_' . $filename . '_' . $time . '.' . $extension;
                    $home_r = 'home_r_' . $filename . '_' . $time . '.' . $extension;
                    $list = 'list_' . $filename . '_' . $time . '.' . $extension;
                    $details = 'details_' . $filename . '_' . $time . '.' . $extension;
                    $details_s = 'details_s_' . $filename . '_' . $time . '.' . $extension;
                    $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;

                    $main_image = $image;
                    $originalPath = public_path() . '/storage/uploads/project/main_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/project/main_image/thumbnail/';
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

                    //home page hydropower
                    $categoryImage->resize(635, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $home_h, 90);
                    $categoryImage->reset();

                    //home page renewable energy
                    $categoryImage->resize(630, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $home_r, 90);
                    $categoryImage->reset();

                    //list page
                    $categoryImage->resize(405, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $list, 90);
                    $categoryImage->reset();

                    //details page
                    $categoryImage->resize(155, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $details_s, 90);
                    $categoryImage->reset();

                    //admin page
                    $categoryImage->resize(150, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $admin, 90);
                    $categoryImage->reset();

                    ProjectImage::updateOrCreate([
                        'project_id' => $project->id,
                        'main_image' => $main_image,
                    ]);
                }
            }

            if ($request->hasfile('mobile_image')) {
                foreach ($request->mobile_image as $image) {
                    $filenamewithextension = $image->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $image->getClientOriginalExtension();
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;
                    $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;


                    $mobile_image = $image;
                    $categoryImage = Image::make($mobile_image);
                    $categoryImage->backup();
                    $originalPath = public_path() . '/storage/uploads/project/mobile_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/project/mobile_image/thumbnail/';
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
                    $categoryImage->save($thumbnailPath . $admin);
                    $categoryImage->reset();

                    ProjectImage::updateOrCreate([
                        'project_id' => $project->id,
                        'mobile_image' => $mobile_image,
                    ]);
                }
            }

            return redirect()->route('admin.project.index')->withMessage('Project Added successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
        $projectKpi = ProjectKpi::where('project_id', $project->id)->first();

        return view('admin.project.show', compact('project', 'projectKpi'));
    }

    public function add_kpi($id)
    {
        $project = Project::findOrFail($id);
        $projectKpi = ProjectKpi::where('project_id', $project->id)->first();
        return view('admin.project.add_kpis', compact('project', 'projectKpi'));
    }

    public function store_kpi(Request $request)
    {
        $validated = $request->validate([
            'sector' => 'required',
            'location' => 'required|max:255',
            'capacity' => 'required|max:255',
            'cost' => 'required|max:255',
            'funding_by' => 'required|max:255',
            'construction_begins' => 'required|date',
            'end_date'=> 'nullable|date',
            'status' => 'required|in:operating,construction',
            'altitude' => $request->sector == 'hydropower' ? ['required', 'string', 'max:255'] : 'nullable|string|max:255',
            'source' => $request->sector == 'distrubution_infrastructure' ? ['nullable', 'string', 'max:255'] : 'required|string|max:255',
            'subbasin' => $request->sector == 'hydropower' ? ['required', 'string', 'max:255'] : 'nullable|string|max:255',
            'kw_per_year' => $request->sector == 'renewable_energy' ? ['required', 'string', 'max:255'] : 'nullable|string|max:255',
            'full_load_hours' => $request->sector == 'renewable_energy' ? ['required', 'string', 'max:255'] : 'nullable|string|max:255',
            'plant_availability' => $request->sector == 'renewable_energy' ? ['required', 'string', 'max:255'] : 'nullable|string|max:255',
            'circulation_rate' => $request->sector == 'water_conservation' ? ['required', 'string', 'max:255'] : 'nullable|string|max:255',

        ]);
        // dd($request->circulation_rate);

        $projectKpi = ProjectKpi::updateOrCreate([
            'project_id' => $request->project_id,
        ], [
            'sector' => $request->sector ?? null,
            'status' => $request->status ?? null,
            'location' => $request->location ?? null,
            'capacity' => $request->capacity ?? null,
            'cost' => $request->cost ?? null,
            'funding_by' => $request->funding_by ?? null,
            'construction_begins' => $request->construction_begins ?? null,
            'end_date'=> $request->end_date ?? null,
            'altitude' => $request->altitude ?? null,
            'source' => $request->source ?? null,
            'subbasin' => $request->subbasin ?? null,
            'kw_per_year' => $request->kw_per_year ?? null,
            'full_load_hours' => $request->full_load_hours ?? null,
            'plant_availability' => $request->plant_availability ?? null,
            'circulation_rate' => $request->circulation_rate ?? null,
        ]);

        return redirect()->route('admin.project.index')->withMessage('KPI Added successfully');
    }

    public function edit($id)
    {
        $project = Project::findOrFail($id);
        $pages = Page::where('type', 'sector')->get();
        $projectTypes = ProjectType::get();
        $services = Page::where('type', 'service')->get();

        return view('admin.project.edit', compact('project', 'pages', 'projectTypes', 'services'));
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $project = Project::findOrFail($id);
        try {
            $project->update([
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'short_description' => $request->short_description,
                'description' => $request->description,
                'project_type_id' => $request->project_type_id,
                'page_id' => $request->page_id,
                'service_id' => $request->service_id,
                'stage' => $request->stage,
                'show_on_menu' => $request->show_on_menu ?? 0,
                'show' => $request->show ?? 1,

                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);

            $setting = SiteSetting::first()->language_id;
            $projectLanguage = ProjectLanguage::updateOrCreate([
                'language_id' => $setting,
                'project_id' => $project->id
            ], [
                'title' => $request->title,
                'short_description' => $request->short_description,
                'description' => $request->description,
            ]);

            $time = time();

            // Update main images
            if ($request->hasfile('main_image')) {
                // Retrieve and delete existing main images
                $existingMainImages = ProjectImage::where('project_id', $project->id)->pluck('main_image');
                foreach ($existingMainImages as $existingMainImage) {
                    $path = public_path() . '/storage/uploads/project/main_image/' . $existingMainImage;
                    $thumbnailPath = public_path() . '/storage/uploads/project/main_image/thumbnail/';
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                }
                // Delete the records from the database
                ProjectImage::where('project_id', $project->id)->whereNotNull('main_image')->delete();

                // Save new main images
                foreach ($request->main_image as $image) {
                    $filenamewithextension = $image->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $image->getClientOriginalExtension();
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;
                    $home_h = 'home_h_' . $filename . '_' . $time . '.' . $extension;
                    $home_r = 'home_r_' . $filename . '_' . $time . '.' . $extension;
                    $list = 'list_' . $filename . '_' . $time . '.' . $extension;
                    $details = 'details_' . $filename . '_' . $time . '.' . $extension;
                    $details_s = 'details_s_' . $filename . '_' . $time . '.' . $extension;
                    $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;

                    $main_image = $image;
                    $originalPath = public_path() . '/storage/uploads/project/main_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/project/main_image/thumbnail/';
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

                    //home page hydropower
                    $categoryImage->resize(635, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $home_h, 90);
                    $categoryImage->reset();

                    //home page renewable energy
                    $categoryImage->resize(630, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $home_r, 90);
                    $categoryImage->reset();

                    //list page
                    $categoryImage->resize(405, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $list, 90);
                    $categoryImage->reset();

                    //details page
                    $categoryImage->resize(155, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $details_s, 90);
                    $categoryImage->reset();

                    //admin page
                    $categoryImage->resize(150, 150, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->sharpen(10);
                    $categoryImage->save($thumbnailPath . $admin, 90);
                    $categoryImage->reset();

                    ProjectImage::updateOrCreate([
                        'project_id' => $project->id,
                        'main_image' => $main_image,
                    ]);
                }
            }

            // Update mobile images
            if ($request->hasfile('mobile_image')) {
                // Retrieve and delete existing mobile images
                $existingMobileImages = ProjectImage::where('project_id', $project->id)->pluck('mobile_image');
                foreach ($existingMobileImages as $existingMobileImage) {
                    $path = public_path() . '/storage/uploads/project/mobile_image/' . $existingMobileImage;
                    $thumbPath = public_path() . '/storage/uploads/project/mobile_image/thumbnail/admin_' . $existingMobileImage;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    if (File::exists($thumbPath)) {
                        File::delete($thumbPath);
                    }
                }
                // Delete the records from the database
                ProjectImage::where('project_id', $project->id)->whereNotNull('mobile_image')->delete();

                // Save new mobile images
                foreach ($request->mobile_image as $image) {
                    $filenamewithextension = $image->getClientOriginalName();
                    $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                    $filename = str_replace(' ', '_', $filename1);
                    $extension = $image->getClientOriginalExtension();
                    $filename_to_store = $filename . '_' . $time . '.' . $extension;
                    $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;

                    $mobile_image = $image;
                    $categoryImage = Image::make($mobile_image);
                    $categoryImage->backup();
                    $originalPath = public_path() . '/storage/uploads/project/mobile_image/';
                    $thumbnailPath = public_path() . '/storage/uploads/project/mobile_image/thumbnail/';
                    if (!File::isDirectory($originalPath)) {
                        File::makeDirectory($originalPath, 0777, true, true);
                    }
                    if (!File::isDirectory($thumbnailPath)) {
                        File::makeDirectory($thumbnailPath, 0777, true, true);
                    }
                    $categoryImage->save($originalPath . $filename_to_store);

                    $mobile_image = $filename_to_store;

                    //admin page
                    $categoryImage->resize(150, 150, function ($constraint) {
                        // $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath . $admin);
                    $categoryImage->reset();

                    ProjectImage::updateOrCreate([
                        'project_id' => $project->id,
                        'mobile_image' => $mobile_image,
                    ]);
                }
            }


            return redirect()->route('admin.project.index')->withMessage('Project updated successfully');
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('admin.project.index')->withMessage('Project deleted successfully');
    }
}
