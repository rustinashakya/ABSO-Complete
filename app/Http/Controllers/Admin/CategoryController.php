<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index() {
        $category = Category::with('parentCategory')->latest()->Paginate(10);
        // dd($category);
        return view('category.index',compact('category'));
    }

    public function add() {
        $category = Category::where('category_parent_id',Null)->with('parentCategory')->get();
        return view('category.add',compact('category'));
    }

    /**
 * Create a thumbnail of specified size
 *
 * @param string $path path of thumbnail
 * @param int $width
 * @param int $height
 */
public function createThumbnail($path, $width, $height)
{
    $img = Image::make($path)->resize($width, $height, function ($constraint) {
        dd($constraint);
        $constraint->aspectRatio();
    });
    $img->save($path);
}

    public function store(Request $request) {
        // dd($request->all());
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                    'name' => 'required',
                    // 'nepali_name' => 'required',
                    'category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                    // 'category_parent_id' => ($request->category_parent_id =='' ?'nullable':'required'),
            ],$message = [
                'name' => 'Name field is required',
                // 'nepali_name' => 'Nepali name field is required',
                'category_image' => 'Category image field is required',
                'category_image.image' => 'Category image field is required'
            ]);

                if ($validator->fails()) {
                    return back()
                            ->withErrors($validator)
                            ->withInput();
                }
                // if ($validator->fails()) {
                //     return response()->json(['error' => $validator->errors(), 'error']);
                // }
            $category = new Category();

            if ($request->category_image) {
                $image=$request->file('category_image');
                //get filename with extension
                $filenamewithextension = $request->file('category_image')->getClientOriginalName();
                //get filename without extension
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename= str_replace(' ', '_', $filename1);
                //get file extension
                $extension = $request->file('category_image')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename.'_'.time().'.'.$extension;
                $originalPath = public_path('/storage/uploads/category_image/');
                $thumbnailPath = public_path('/storage/uploads/category_image/thumbnail/');
                if(!File::isDirectory($originalPath)){
                    File::makeDirectory($originalPath, 0777, true, true);

            // retry storing the file in newly created path.
                }
                if(!File::isDirectory($thumbnailPath)){
                    File::makeDirectory($thumbnailPath, 0777, true, true);

            // retry storing the file in newly created path.
                }
                $filename_to_store = $filename.'_'.time().'.'.$extension;
                $categoryImage = Image::make($image);
                $categoryImage->save($originalPath.$filename_to_store);
                $categoryImage->backup();

                    //verysmall thumbnail name
                    $vsmall_thumbnail = 'vsmall_'.$filename.'_'.time().'.'.$extension;
                    //small thumbnail name
                    $small_thumbnail = 'small_'.$filename.'_'.time().'.'.$extension;
                    //medium thumbnail name
                    $medium_thumbnail = 'medium_'.$filename.'_'.time().'.'.$extension;
                     //large thumbnail name
                     $large_thumbnail = 'large_'.$filename.'_'.time().'.'.$extension;






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
                    $categoryImage->resize(640, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$medium_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();

                    //resize for 414
                    $categoryImage->resize(896, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$large_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();




                $category->category_image= $filename_to_store;

            }
            else {
                $category->category_image = null;
            }

                    if($request->category_parent_id) {
                        $category->category_parent_id = $request->category_parent_id;
                    } else {
                        $category->category_parent_id = Null;
                    }

                    $category->name = $request->name;
                    $category->nepali_name = $request->nepali_name;
                    $category->is_menu = $request->is_menu;

                    $category->save();

                $message = 'Category Created !!!';
                    return redirect()->route('category.index')->withSuccess('Category Created !!!')->withMessage($message);
            }
            catch (\Throwable $th) {
                throw $th;
            }
    }

    public function edit($category_id) {
        $category = Category::findOrFail($category_id);
        // $categories = Category::get();
        // dd($category);
        return view('category.edit',compact('category'));
    }

    public function update(Request $request,$category_id) {
        // dd($request->all());
        try {

            $data = $request->all();

            $validator = Validator::make($data, [
                'name' => 'required',
                // 'nepali_name' => 'required',
                'category_image' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],$message = [
                'name' => 'Name field is required',
                // 'nepali_name' => 'Nepali name field is required',
                'category_image' => 'Category image field is required',
                'category_image.image' => 'Category image field is required'
            ]);
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }
                // if ($validator->fails()) {
                //     return response()->json(['error' => $validator->errors(), 'error']);
                // }
                        $category_image = Category::find($category_id);

                        if ($request->file('category_image') == null ) {

                                $oldIcon = $request->category_image1;

                                Category::where('id', $category_id)->Update([
                                'name'=> $request->name,
                                'nepali_name'=> $request->nepali_name,
                                'is_menu'=> $request->is_menu,
                                'category_image' => $oldIcon,
                                'category_parent_id'=> $category_image->category_parent_id,
                            ]);
                        }
                        else
                        {
                        $category_images = $request->file('category_image');
                        $destination = 'storage/uploads/category_image/'.$category_image->category_image;
                                if (File::exists($destination)) {
                                    File::delete($destination);
                                }

                        // $name = $category_images->hashName();
                        // $categoryImage = Image::make($category_images);
                        // $originalPath = public_path().'/storage/uploads/category_image/';
                        // $categoryImage->save($originalPath.time().$category_images->getClientOriginalName());
                        // $categoryImage->resize(500,500);
                        // $newIcon=time().$category_images->getClientOriginalName();

                        $filenamewithextension = $request->file('category_image')->getClientOriginalName();
                //get filename without extension
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename= str_replace(' ', '_', $filename1);

                //get file extension
                $extension = $request->file('category_image')->getClientOriginalExtension();
                //filename to store
                $newIcon = $filename.'_'.time().'.'.$extension;
                $originalPath = public_path('/storage/uploads/category_image/');
                $thumbnailPath = public_path('/storage/uploads/category_image/thumbnail/');
                if(!File::isDirectory($originalPath)){
                    File::makeDirectory($originalPath, 0777, true, true);

                } if(!File::isDirectory($thumbnailPath)){
                    File::makeDirectory($thumbnailPath, 0777, true, true);

                }
                $categoryImage = Image::make($category_images);
                $categoryImage->save($originalPath.$newIcon);
                $categoryImage->backup();

                    //verysmall thumbnail name
                    $vsmall_thumbnail = 'vsmall_'.$filename.'_'.time().'.'.$extension;
                    //small thumbnail name
                    $small_thumbnail = 'small_'.$filename.'_'.time().'.'.$extension;
                    //medium thumbnail name
                    $medium_thumbnail = 'medium_'.$filename.'_'.time().'.'.$extension;
                     //large thumbnail name
                     $large_thumbnail = 'large_'.$filename.'_'.time().'.'.$extension;






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
                    $categoryImage->resize(640, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$medium_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();

                    //resize for 414
                    $categoryImage->resize(896, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                    $categoryImage->save($thumbnailPath.$large_thumbnail);
                    //  reset image (return to backup state)
                    $categoryImage->reset();



                        Category::where('id',$category_id)->Update([
                            'name'=> $request->name,
                            'nepali_name'=> $request->nepali_name,
                            'is_menu'=> $request->is_menu,
                            'category_image' => $newIcon,
                            'category_parent_id'=> $category_image->category_parent_id,
                        ]);
                    }

                    // $category_image->levels()->sync($request->level);

                $message = 'Category Update !!!';

                return redirect()->route('category.index')->withSuccess('Category Update !!!')->withMessage($message);
            }
            catch (\Throwable $th) {
                throw $th;
            }
    }

    public function delete($category_id) {
        $student = Category::where('id',$category_id)->delete();
        $message = 'Category Delete';
        return redirect()->back()->withSuccess('Category Delete !!!')->withMessage($message);
    }
}
