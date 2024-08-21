<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
class NoticeController extends Controller
{
    public function index(){

        $notices = Notice::latest()->Paginate(10);
        $parent_nav = 'publication';
        $child_nav= 'notice';
        return view('notice.index',compact('notices', 'parent_nav', 'child_nav'));
   }

    public function add(){
        $parent_nav = 'publication';
        $child_nav= 'notice';
        return view('notice.add',compact('parent_nav','child_nav'));
    }

    public function store(Request $request) {
        // dd($request);
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                    'title' => 'required|string',
                    'notice_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:width=900,height=795',
                    'description' => 'required|string',
                    'slug' => 'required|string|unique:notices,slug',
                    'published_date' => 'required|date',
                    // 'meta_description' => $request->description =='' ?'nullable':'required',
                    // 'meta_keyword' => $request->description =='' ?'nullable':'required',
            ],$message = [
                'title' => 'Title field is required',
                'notice_image.mimes' => 'Invalid file',
                'notice_image' => 'Notice image field is required',
                'published_date' => 'Publish date field is required',
                'slug' => 'Slug field in required',
                'description' => 'Description field in required',
                'slug.unique' => 'This slug already exists',
                'notice_image.dimensions'=>'Image should be of 900*795',
            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }

            $notice = new Notice();
            if($request->hasfile('notice_image')) {
            // get filename with extension
            $filenamewithextension = $request->file('notice_image')->getClientOriginalName();
            //get filename without extension
            $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $filename= str_replace(' ', '_', $filename1);

            //get file extension
            $extension = $request->file('notice_image')->getClientOriginalExtension();
            //filename to store
            $filename_to_store = $filename.'_'.time().'.'.$extension;
            if($extension != 'pdf'){
            $vsmall_thumbnail = 'vsmall_'.$filename.'_'.time().'.'.$extension;

            //small thumbnail name
            $small_thumbnail = 'small_'.$filename.'_'.time().'.'.$extension;
            //medium thumbnail name
            $medium_thumbnail = 'medium_'.$filename.'_'.time().'.'.$extension;
                //large thumbnail name
            $large_thumbnail = 'large_'.$filename.'_'.time().'.'.$extension;

            $file = $request->file('notice_image');
            $categoryImage = Image::make($file);
            $categoryImage->backup();
            $originalPath = public_path().'/storage/uploads/pdf_image/';
            $thumbnailPath = public_path().'/storage/uploads/pdf_image/thumbnail/';
            if(!File::isDirectory($originalPath)){
                File::makeDirectory($originalPath, 0777, true, true);

            } if(!File::isDirectory($thumbnailPath)){
                File::makeDirectory($thumbnailPath, 0777, true, true);

            }
            $categoryImage->save($originalPath.$filename_to_store);

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
            $categoryImage->resize(516, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $categoryImage->save($thumbnailPath.$medium_thumbnail);
            //  reset image (return to backup state)
            $categoryImage->reset();

            //resize for 414
            $categoryImage->resize(831, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $categoryImage->save($thumbnailPath.$large_thumbnail);
            //  reset image (return to backup state)
            $categoryImage->reset();

            }
            $notice->file_image = $filename_to_store;
            }
            else {
                $notice->file_image = null;
            }
               $extension = $request->file('notice_image')->getClientOriginalExtension();
            if($extension == 'pdf') {
                $fileName = $filename.'_'.time().'.'.$request->file->extension();

                $request->file->move(public_path('/storage/uploads/pdf_image/'), $fileName);
            }



            $notice->description = $request->description;
            $notice->title = $request->title;
            $notice->meta_description = $request->meta_description;
            $notice->meta_keyword = $request->meta_keyword;
            $notice->publish_date = $request->published_date;
            $notice->slug = $request->slug;
            $notice->save();

            $message = 'Notice Created !!!';

            return redirect()->route('notice.index')->withSuccess('Notice Created !!!')->withMessage($message);
            }
            catch (\Throwable $th) {
                throw $th;
            }
    }

    public function view($id){
        $notice = Notice::findOrFail($id);
        return view('notice.view',compact('notice'));
    }

    public function edit($id){
        $parent_nav = 'publication';
        $child_nav= 'notice';
        $notice = Notice::findOrFail($id);
        // dd($notice);/
        return view('notice.edit',compact('notice','parent_nav','child_nav'));
    }

    public function update(Request $request,$id) {
        // dd($request->all());
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                    'title' => 'required|string',
                    'file' => 'nullable|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:width=900,height=795',
                    'description' => 'required|string',
                    'published_date' => 'required|date',
                    // 'meta_description' => $request->description =='' ?'nullable':'required',
                    // 'meta_keyword' => $request->description =='' ?'nullable':'required',
            ],$message = [
                'title' => 'Title field is required',
                'file.mimes' => 'Invalid file',
                'file' => 'File field is required',
                'published_date' => 'Publish date field is required',
                'slug' => 'Slug field in required',
                'description' => 'Description field in required',
                'file.max'=>'file is large',
                'file.dimensions'=>'Image should be of 900*795',

            ]);

            if ($validator->fails()) {
                return back()
                        ->withErrors($validator)
                        ->withInput();
            }
            $db_notice = Notice::findOrFail($id);

            if($request->hasfile('file')) {
            //get filename with extension
            $filenamewithextension = $request->file('file')->getClientOriginalName();
            //get filename without extension
            $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $filename = str_replace(' ', '_', $filename1);

            //get file extension
            $extension = $request->file('file')->getClientOriginalExtension();
            //filename to store
            $filename_to_store = $filename.'_'.time().'.'.$extension;
            if($extension != 'pdf'){
                //versmall thumbnail
                $vsmall_thumbnail='vsmall_'.$filename.'_'.time().'.'.$extension;
            //small thumbnail name
            $small_thumbnail = 'small_'.$filename.'_'.time().'.'.$extension;
            //medium thumbnail name
            $medium_thumbnail = 'medium_'.$filename.'_'.time().'.'.$extension;
                //large thumbnail name
            $large_thumbnail = 'large_'.$filename.'_'.time().'.'.$extension;

            $file = $request->file('file');
            $categoryImage = Image::make($file);
            $originalPath = public_path().'/storage/uploads/pdf_image/';
            $thumbnailPath = public_path('/storage/uploads/pdf_image/thumbnail/');
            if(!File::isDirectory($originalPath)){
                File::makeDirectory($originalPath, 0777, true, true);

            } if(!File::isDirectory($thumbnailPath)){
                File::makeDirectory($thumbnailPath, 0777, true, true);

            }
            // dd($filename_to_store);
            $categoryImage->save($originalPath.$filename_to_store);
            $categoryImage->backup();


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
            $categoryImage->resize(516, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $categoryImage->save($thumbnailPath.$medium_thumbnail);
            //  reset image (return to backup state)
            $categoryImage->reset();

            //resize for 414
            $categoryImage->resize(831, null, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });
            $categoryImage->save($thumbnailPath.$large_thumbnail);
            //  reset image (return to backup state)
            $categoryImage->reset();







            }
            $db_notice->file_image= $filename_to_store;
        }
        $file = $request->file('file')->getClientOriginalExtension();
            if($file == 'pdf') {
                $filename_to_store = $filename.'_'.time().'.'.$request->file->extension();
                $request->file->move(public_path('/storage/uploads/pdf_image/'), $filename_to_store);
            }
            // $notice->file_image= $filename_to_store;


            Notice::where('id', $id)->update([
                'description' => $request->description,
                'file_image' => $filename_to_store,
                'title' => $request->title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
                'publish_date' => $request->published_date,
                'slug' => $request->slug,
            ]);

            $message = 'Notice Update !!!';

            return redirect()->route('notice.index')->withSuccess('Notice Update !!!')->withMessage($message);
        }
            catch (\Throwable $th) {
                throw $th;
            }

        }
    public function delete($id){
        $notice = Notice::findOrFail($id);
        $notice->delete();
        $message = 'Notice Delete Successfully';
        return redirect()->back()->withSuccess('Category Delete !!!')->withMessage($message);
    }

 }
