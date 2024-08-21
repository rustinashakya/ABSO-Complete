<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaCoverage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;


class MediaController extends Controller
{
    public function index(){

        $media = MediaCoverage::latest()->Paginate(25);

        return view('admin.media_coverage.index',compact('media'));
   }

    public function add(){
        $parent_nav = 'content';
        $child_nav = 'media';
        return view('admin.media_coverage.add', compact('parent_nav', 'child_nav'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'title' => 'required|string|max:200',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'description' => 'required|string',
                'slug' => 'required|string|alpha_dash|unique:notices,slug|unique:media_coverages,slug',
                'published_date' => 'required|date',
                'meta_description' => 'required|string',
                'meta_keyword' => 'required|string',
                // 'youtube_link' => $request->type == 'youtube' ? ['required', 'regex:/^(https?:\/\/)?(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/)([\w\-]{11})$/'] : 'nullable',
                'youtube_link' => $request->type == 'youtube' ? ['required', 'regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.be)\/.+$/'] : 'nullable',
                'main_image' => $request->type == 'image' ? 'required|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:max_width=900,max_height=470' : 'nullable',

            ], [
                'title.required' => 'Title field is required.',
                'file.required' => 'File field is required',
                'description.required' => 'Description field is required',
                'slug.required' => 'Slug field is required',
                'published_date.required' => 'Published date field is required',
                'slug.unique'=>'This slug already exists.',
                'main_image.dimensions'=>'Image max size should be of size 900*470',
            ]);

            $notice = new MediaCoverage();
            $time=time();
            $notice->description = $data['description'];
            $notice->title = $data['title'];
            $notice->meta_description = $data['meta_description'];
            $notice->meta_keyword = $data['meta_keyword'];
            $notice->publish_date = $data['published_date'];
            $notice->slug = $data['slug'];
            $notice->type = $request->type;
            $notice->utube_link = $data['youtube_link'];

            if ($request->has('main_image') && $request->file('main_image')->isValid()) {
                $image = $request->file('main_image');
                $extension = $image->getClientOriginalExtension();
                $filename1 = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                $filename= str_replace(' ', '_', $filename1);

                $filename_to_store = $filename.'_'.$time.'.'.$extension;

                if ($extension !== 'pdf') {
                    $originalPath = public_path('/storage/uploads/media/');
                    $thumbnailPath = public_path('/storage/uploads/media/thumbnail/');
                    if(!File::isDirectory($originalPath)){
                        File::makeDirectory($originalPath, 0777, true, true);

                    } if(!File::isDirectory($thumbnailPath)){
                        File::makeDirectory($thumbnailPath, 0777, true, true);

                    }
                    $categoryImage = Image::make($image);
                    $categoryImage->save($originalPath.$filename_to_store);
                    $categoryImage->backup();

                    //verysmall thumbnail name
                    $vsmall_thumbnail = 'vsmall_'.$filename.'_'.$time.'.'.$extension;
                    //small thumbnail name
                    $small_thumbnail = 'small_'.$filename.'_'.$time.'.'.$extension;
                    //medium thumbnail name
                    $medium_thumbnail = 'medium_'.$filename.'_'.$time.'.'.$extension;
                     //large thumbnail name
                     $large_thumbnail = 'large_'.$filename.'_'.$time.'.'.$extension;

                    $categoryImage->resize(296, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$vsmall_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();
                    //resize for 414
                    $categoryImage->resize(416, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$small_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();

                    //resize for 414
                    $categoryImage->resize(520, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$medium_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();

                    //resize for 414
                    $categoryImage->resize(700, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$large_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();

                    $notice->file_image = $filename_to_store;
                } else {
                    $filename = $filename . '_' . $time . '.' . $extension;
                    $image->move(public_path('/storage/uploads/pdf_image/'), $filename);

                    $notice->file_image = null;
                }
            }

            $notice->save();

            return redirect()->route('media.index')->withMessage('News Added Successfully!');
        } catch (\Throwable $th) {
            throw $th;
        }
    }


    public function view($id){
        $media = MediaCoverage::findOrFail($id);
        return view('admin.media_coverage.view',compact('media'));
    }

    public function edit($id){
        $notice = MediaCoverage::findOrFail($id);
        $parent_nav = 'content';
        $child_nav = 'media';
        // dd($media);/
        return view('admin.media_coverage.edit',compact('notice','parent_nav','child_nav'));
    }

    public function update(Request $request,$id) {
        // dd($request->all());
        try {
            $data = $request->all();
            // define the validation rules and messages for all cases
            $rules = [
                'title' => 'required|string|max:200',
                'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048',
                'description' => 'required|string',
                'published_date' => 'required|date',
                'meta_description' => 'required|string',
                'meta_keyword' => 'required|string',
                
                // 'youtube_link' => $request->type == 'youtube' ? ['required', 'regex:/^(https?:\/\/)?(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/)([\w\-]{11})$/'] : 'nullable',
                'youtube_link' => $request->type == 'youtube' ? ['required', 'regex:/^(https?\:\/\/)?(www\.youtube\.com|youtu\.be)\/.+$/'] : 'nullable',
                'main_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:max_height=470,max_width=900',
            ];
            $messages = [
                'title.required' => 'Title field is required.',
                'file.required' => 'File field is required',
                'description.required' => 'Description field is required',
                'slug' => 'Slug field is required',
                'published_date' => 'Slug field is required',
                'main_image.dimensions'=>'Image should be of size 900*470',

            ];

            // modify the main_image rule if a file is uploaded
            // if ($request->type == 'image') {
            //     if ($request->hasFile('main_image')) {
            //         $rules['main_image'] = 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:max_width=900,max_height=470';
            //     }
            //     if($request->old_main_image == null) {
            //         $rules['main_image'] = 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:max_width=900,max_height=470';
            //     }
            // }

            // validate the request data
            $validator = Validator::make($data, $rules, $messages);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $db_notice = MediaCoverage::findOrFail($id);
            $time=time();

            if ($request->file('main_image') == null) {
                MediaCoverage::where('id', $id)->update([
                    'description' => $request->description,
                    // 'file_image' => $db_filename_to_store,
                    'title' => $request->title,
                    'meta_description' => $request->meta_description,
                    'meta_keyword' => $request->meta_keyword,
                    'publish_date' => $request->published_date,
                    'slug' => $request->slug,
                    'type' => $request->type,
                    'utube_link' => ($request->type == 'youtube') ? $request->youtube_link : '',
                ]);
            }else{
                
                if ($request->type == 'image' ){
                    $db_filename_to_store = '';
    
                if($request->main_image) {
    
                $file = $request->file('main_image');
                $extension = $file->getClientOriginalExtension();
                $filename1= pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $filename= str_replace(' ', '_', $filename1);
    
                $filename_to_store = $filename.'_'.$time.'.'.$extension;
    
                if ($extension != 'pdf') {
                    $originalPath = public_path('/storage/uploads/media/');
                    $thumbnailPath = public_path('/storage/uploads/media/thumbnail/');
              if(!File::isDirectory($originalPath)){
                        File::makeDirectory($originalPath, 0777, true, true);
    
                    } if(!File::isDirectory($thumbnailPath)){
                        File::makeDirectory($thumbnailPath, 0777, true, true);
    
                    }
                    $categoryImage = Image::make($file);
                    $categoryImage->save($originalPath.$filename_to_store);
                    $categoryImage->backup();
    
                    //verysmall thumbnail name
                    $vsmall_thumbnail = 'vsmall_'.$filename.'_'.$time.'.'.$extension;
                    //small thumbnail name
                    $small_thumbnail = 'small_'.$filename.'_'.$time.'.'.$extension;
                    //medium thumbnail name
                    $medium_thumbnail = 'medium_'.$filename.'_'.$time.'.'.$extension;
                     //large thumbnail name
                     $large_thumbnail = 'large_'.$filename.'_'.$time.'.'.$extension;
    
    
    
    
    
    
                    $categoryImage->resize(296, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$vsmall_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();
                    //resize for 414
                    $categoryImage->resize(416, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$small_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();
    
                //resize for 414
                $categoryImage->resize(520, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->save($thumbnailPath.$medium_thumbnail);
                //  reset image (return to backup state)
                $categoryImage->reset();
    
                //resize for 414
                $categoryImage->resize(700, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $categoryImage->save($thumbnailPath.$large_thumbnail);
                //  reset image (return to backup state)
                $categoryImage->reset();
    
                } else {
                    $filename = $filename . '_' . $time . '.' . $extension;
                    $file->move(public_path('/storage/uploads/pdf_image/'), $filename);
    
                    $db_notice->file_image = null;
                }
    
                $db_filename_to_store = $filename_to_store;
            }
    
            }
            if ($request->type == 'youtube') {
                $db_filename_to_store = '';
            }
            MediaCoverage::where('id', $id)->update([
                'description' => $request->description,
                'file_image' => $db_filename_to_store,
                'title' => $request->title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'publish_date' => $request->published_date,
                'slug' => $request->slug,
                'type' => $request->type,
                'utube_link' => ($request->type == 'youtube') ? $request->youtube_link : '',
            ]);
            }
            
           

           

            $message = 'News Updated Successfully!';

            return redirect()->route('media.index')->withMessage($message);
            }
            catch (\Throwable $th) {
                throw $th;
            }
    }

    private function generateFilenameToStore($file)
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filename_to_store = preg_replace('/\s+/', '-', $filename.'_'.time().'.'.$extension);
        return $filename_to_store;
    }

    private function generatePdfFilenameToStore($file)
    {
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        return $filename.'_'.time().'.'.$file->extension();
    }

    private function saveImage($file, $filename_to_store)
    {
        $categoryImage = Image::make($file);
        $categoryImage->backup();
        $originalPath = public_path().'/storage/uploads/media/';
        $categoryImage->save($originalPath.$filename_to_store);
        $categoryImage->reset();
    }

    private function savePdfImage($file, $filename_to_store)
    {
        $file->move(public_path('/storage/uploads/pdf_image/'), $filename_to_store);
    }

    public function delete($id){
        $notice = MediaCoverage::findOrFail($id);
        $notice->delete();
        $message = 'News Deleted Successfully!';
        return redirect()->back()->withMessage($message);
    }
}
