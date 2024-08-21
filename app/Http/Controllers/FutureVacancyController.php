<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Models\Vacancy;
use App\Models\VacancyLevel;
use App\Rules\SlugRule;
use Illuminate\Validation\Rule;

class FutureVacancyController extends Controller
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
        $vacancies = Vacancy::with('level')->where('type', 'future')->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.vacancy.future.index', compact('vacancies'));
    }

    public function create()
    {
        $levels = VacancyLevel::all();
        return view('admin.vacancy.future.create', compact('levels'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'max:100', new SlugRule, Rule::unique('vacancies', 'slug')->withoutTrashed()],
                'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                'vacancy_level_id' => ['nullable', Rule::exists('vacancy_levels', 'id')],
                'deadline' => ['nullable', 'date'],
                'short_description' => ['required', 'max:2000'],
                'reports_to' => ['nullable', 'string', 'max:120'],
                'status' => ['nullable', 'string'],
                'description' => ['required'],
                'html_title' => ['required', 'string'],
                'meta_description' => ['required', 'string'],
                'meta_keyword' => ['required', 'string'],
            ], [
                'title.required' => 'The title field is required.',
                'title.max' => 'The title may not be greater than 255 characters.',
                'slug.required' => 'The slug field is required.',
                'slug.max' => 'The slug may not be greater than 100 characters.',
                'image.required' => 'The image field is required.',
                'image.image' => 'The image must be an image.',
                'image.max' => 'The image may not be greater than 2048 characters.',
                'vacancy_level_id.required' => 'The level field is required.',
                'deadline.required' => 'The deadline field is required.',
                'short_description.required' => 'The short description field is required.',
                'reports_to.required' => 'The reports to field is required.',
                'status.required' => 'The status field is required.',
                'description.required' => 'The description field is required.',
                'description.max' => 'The description may not be greater than 64KB.',
                'html_title.required' => 'The html title field is required.',
                'meta_description.required' => 'The meta description field is required.',
                'meta_keyword.required' => 'The meta keyword field is required.',
            ]);
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
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'short_description' => $request->short_description,
                'reports_to' => $request->reports_to,
                'image' => $main_image,
                'vacancy_level_id' => $request->vacancy_level_id,
                'description' => $request->description,
                'status' => 'active',
                'deadline' => $request->deadline,
                'created_by' => auth()->user()->id,
                'type' => 'future',

                //meta data
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);

            return redirect()->route('admin.vacancy.future.index')->withMessage(__('Future Vacancy Added Successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function edit($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $levels = VacancyLevel::all();
        return view('admin.vacancy.future.edit', compact('vacancy', 'levels'));
    }

    public function update(Request $request, $id)
    {
        $vacancy = Vacancy::findOrFail($id);
        try {
            $validated = $request->validate([
                'title' => ['required', 'string', 'max:255'],
                'slug' => ['required', 'max:100', new SlugRule],
                'image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
                'vacancy_level_id' => ['nullable', Rule::exists('vacancy_levels', 'id')],
                'deadline' => ['nullable', 'date'],
                'short_description' => ['required', 'max:2000'],
                'reports_to' => ['nullable', 'string', 'max:120'],
                'status' => ['nullable', 'string'],
                'description' => ['required'],
                'html_title' => ['required', 'string'],
                'meta_description' => ['required', 'string'],
                'meta_keyword' => ['required', 'string'],
            ], [
                'title.required' => 'The title field is required.',
                'title.max' => 'The title may not be greater than 255 characters.',
                'slug.required' => 'The slug field is required.',
                'slug.max' => 'The slug may not be greater than 100 characters.',
                'image.required' => 'The image field is required.',
                'image.image' => 'The image must be an image.',
                'image.max' => 'The image may not be greater than 2048 characters.',
                'vacancy_level_id.required' => 'The level field is required.',
                'deadline.required' => 'The deadline field is required.',
                'short_description.required' => 'The short description field is required.',
                'reports_to.required' => 'The reports to field is required.',
                'status.required' => 'The status field is required.',
                'description.required' => 'The description field is required.',
                'description.max' => 'The description may not be greater than 64KB.',
                'html_title.required' => 'The html title field is required.',
                'meta_description.required' => 'The meta description field is required.',
                'meta_keyword.required' => 'The meta keyword field is required.',
            ]);

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
                'title' => $request->title,
                'slug' => Str::slug($request->slug),
                'short_description' => $request->short_description,
                'reports_to' => $request->reports_to,
                'image' => $main_image ?? $vacancy->image,
                'vacancy_level_id' => $request->vacancy_level_id,
                'description' => $request->description,
                'status' => 'active',
                'deadline' => $request->deadline,
                'created_by' => auth()->user()->id,
                'type' => 'future',

                //meta data
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);

            return redirect()->route('admin.vacancy.future.index')->withMessage(__('Future Vacancy Updated Successfully'));
        } catch (\Exception $e) {
            return redirect()->back()->withError($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $vacancy = Vacancy::findOrFail($id);
        $vacancy->delete();
        return redirect()->route('admin.vacancy.future.index')->withMessage(__('Future Vacancy Deleted Successfully'));
    }
}
