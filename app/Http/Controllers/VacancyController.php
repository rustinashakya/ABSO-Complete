<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vacancy\VacancyStoreRequest;
use App\Http\Requests\Vacancy\VacancyUpdateRequest;
use App\Models\Vacancy;
use App\Models\VacancyLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class VacancyController extends Controller
{

    public function __construct()
    {
        $this->middleware('role_or_permission:Vacancy access', ['only' => ['index', 'show']]);
        $this->middleware('role_or_permission:Vacancy create', ['only' => ['create', 'store']]);
        $this->middleware('role_or_permission:Vacancy edit', ['only' => ['edit', 'update']]);
        $this->middleware('role_or_permission:Vacancy delete', ['only' => ['destroy']]);
    }


    public function index(Request $request)
    {
        $vacancies = Vacancy::with('level')->where('type', 'job-details')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.vacancy.index', compact('vacancies'));
    }

    public function create()
    {
        $levels = VacancyLevel::all();
        return view('admin.vacancy.create', compact('levels'));
    }

    public function store(VacancyStoreRequest $request)
    {
        try {
            $time = time();

            if ($request->hasfile('image')) {
                $filenamewithextension = $request->file('image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('image')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;

                $admin_thumbnail = 'admin_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('image');
                $thumbnailPath = public_path() . '/storage/uploads/vacancy/image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/vacancy/image/';
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

                $categoryImage->resize(300, 300, function ($constraint) {
                    // $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->save($thumbnailPath . $admin_thumbnail);
                $categoryImage->reset();
            } else {
                $main_image = null;
            }

            Vacancy::create([
                'title'=> $request->title,
                'slug'=> Str::slug($request->slug),
                'short_description'=> $request->short_description,
                'reports_to'=> $request->reports_to,
                'image'=> $main_image,
                'vacancy_level_id'=> $request->vacancy_level_id,
                'description'=> $request->description,
                'status'=> $request->status,
                'deadline'=> $request->deadline,
                'created_by'=> auth()->user()->id,
                'type'=> 'job-details',

                //meta data
                'html_title'=> $request->html_title,
                'meta_description'=> $request->meta_description,
                'meta_keyword'=> $request->meta_keyword,
            ]);
            
            return redirect()->route('admin.vacancy.index')->withMessage(__('Vacancy Added Successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $levels = VacancyLevel::all();
        return view('admin.vacancy.edit', compact('vacancy', 'levels'));
    }

    public function update(VacancyUpdateRequest $request, $id)
    {
        $vacancy = Vacancy::findOrFail($id);
        try {
            $time = time();

            if ($request->hasfile('image')) {
                Storage::delete('storage/uploads/vacancy/image/' . $vacancy->image);
                Storage::delete('storage/uploads/vacancy/image/thumbnail/' . $vacancy->image);

                $filenamewithextension = $request->file('image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('image')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;

                $admin_thumbnail = 'admin_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('image');
                $thumbnailPath = public_path() . '/storage/uploads/vacancy/image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/vacancy/image/';
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

                $categoryImage->resize(300, 300, function ($constraint) {
                    // $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->save($thumbnailPath . $admin_thumbnail);
                $categoryImage->reset();
            }
            $vacancy->update([
                'title'=> $request->title,
                'slug'=> Str::slug($request->slug),
                'short_description'=> $request->short_description,
                'reports_to'=> $request->reports_to,
                'image'=> $main_image ?? $vacancy->image,
                'vacancy_level_id'=> $request->vacancy_level_id,
                'description'=> $request->description,
                'status'=> $request->status,
                'deadline'=> $request->deadline,
                'created_by'=> auth()->user()->id,
                'type'=> 'job-details',

                //meta data
                'html_title'=> $request->html_title,
                'meta_description'=> $request->meta_description,
                'meta_keyword'=> $request->meta_keyword,
            ]);
            
            return redirect()->route('admin.vacancy.index')->withMessage(__('Vacancy Updated Successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->delete();
        return redirect()->route('admin.vacancy.index')->withMessage(__('Vacancy Deleted Successfully'));
    }
}
