<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ServiceApiController extends Controller
{
    public function index()
    {
        $services = Service::select(
            'id',
            'service_name',
            'service_image',
            'service_mobile_image',
            'service_description',
            'home_icon',
            'slug'
        )
            ->get();
        if (count($services) > 0) {
            return response()->json(
                [
                    'status' => true,
                    'message' => 'Data fetched successfully!',
                    'data' => $services,
                ],
                200
            );
        } else {
            return response()->json(
                [

                    'status' => false,
                    'message' => 'Service not found',
                ],
                400
            );
        }
    }

    public function getServicesBySlug($slug)
    {
        $service = Service::where('slug', $slug)->first();

        if (!$service) {
            return response()->json([
                'status' => false,
                'error' => 'Service not found'], 404);
        }

        return response()->json(['service' => $service], 200);
    }
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'service_name' => 'required',
                'service_description' => 'required',
                'service_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:height=230,width=230',
            ],
            $message = [
                'service_name' => 'Service Name field is required',
                'service_description' => 'Service Description field is required',
                'service_image' => 'Service image field is required',
                'service_image.image' => 'Service image must be an image',
                'service_image.dimensions' => 'Service should be of 230*230 size',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $services = new Service();
            $services = new Service();

            if ($request->service_image) {


                $service_image = $request->file('service_image')->getClientOriginalName();
                $filename1 = pathinfo($service_image, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('service_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . time() . '.' . $extension;
                //vsmall thumbnail name
                $vsmall_thumbnail = 'vsmall_' . $filename . '_' . time() . '.' . $extension;
                //small thumbnail name
                $small_thumbnail = 'small_' . $filename . '_' . time() . '.' . $extension;
                //medium thumbnail name
                $medium_thumbnail = 'medium_' . $filename . '_' . time() . '.' . $extension;
                //large thumbnail name
                $large_thumbnail = 'large_' . $filename . '_' . time() . '.' . $extension;

                //rezie for modal
                $modal_pic = 'modal_' . $filename . '_' . time() . '.' . $extension;

                $services->service_image = $filename_to_store;

                $s_image = $request->file('service_image');
                $serviceImage = Image::make($s_image);
                $serviceImage->backup();
                $thumbnailPath = public_path() . '/storage/uploads/service_image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/service_image/';

                //orignial
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);

                    // retry storing the file in newly created path.
                }

                $serviceImage->save($originalPath . $filename_to_store);
                //for modal
                $serviceImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $modal_pic);
                $serviceImage->reset();
                //for large
                $serviceImage->resize(202, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $large_thumbnail);
                $serviceImage->reset();
                //thumbnail for medium
                $serviceImage->resize(185, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $medium_thumbnail);
                $serviceImage->reset();
                //thumbnail for small

                $serviceImage->resize(151, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $small_thumbnail);
                $serviceImage->reset();
                //thumbnail for small

                $serviceImage->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $vsmall_thumbnail);
                $serviceImage->reset();

            } else {
                $services->service_image = null;
            }

            $services->service_name = $request->service_name;
            $services->service_description = $request->service_description;
            $services->meta_keyword = $request->meta_keyword;
            $services->meta_description = $request->meta_description;
            $services->save();

            $message = 'Service Created !!!';

            return response()->json(['message' => 'Service Created !!!'], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => 'Failed to create data'
            ], 500);
        }
    }

    public function update(Request $request, $service_id)
    {
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'service_name' => 'required',
                'service_description' => 'required',
                'service_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // dimensions:height=230,width=230
            ],
            $message = [
                'service_name' => 'Service Name field is required',
                'service_description' => 'Service Description field is required',
                'service_image.image' => 'Service image must be an image',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        try {
            $service = Service::find($service_id);

            if ($request->hasFile('service_image')) {
                $service_image = $request->file('service_image');

                // Delete old image
                $old_image_path = 'storage/uploads/service_image/' . $service->service_image;
                if (File::exists($old_image_path)) {
                    File::delete($old_image_path);
                }

                // Save new image

                $service_image = $request->file('service_image')->getClientOriginalName();
                $filename1 = pathinfo($service_image, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);

                $extension = $request->file('service_image')->getClientOriginalExtension();
                $filename_to_store = $filename . '_' . time() . '.' . $extension;
                //vsmall thumbnail name
                $vsmall_thumbnail = 'vsmall_' . $filename . '_' . time() . '.' . $extension;
                //small thumbnail name
                $small_thumbnail = 'small_' . $filename . '_' . time() . '.' . $extension;
                //medium thumbnail name
                $medium_thumbnail = 'medium_' . $filename . '_' . time() . '.' . $extension;
                //large thumbnail name
                $large_thumbnail = 'large_' . $filename . '_' . time() . '.' . $extension;
                //rezie for modal
                $modal_pic = 'modal_' . $filename . '_' . time() . '.' . $extension;

                // dd($filename_to_store);
                $service->service_image = $filename_to_store;

                $p_image = $request->file('service_image');
                $serviceImage = Image::make($p_image);
                $serviceImage->backup();
                $thumbnailPath = public_path() . '/storage/uploads/service_image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/service_image/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);

                }
                if (!File::isDirectory($thumbnailPath)) {
                    File::makeDirectory($thumbnailPath, 0777, true, true);

                }
                //orignial
                $serviceImage->save($originalPath . $filename_to_store);
                // for modal pic
                $serviceImage->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $modal_pic);
                $serviceImage->reset();
                //for large
                $serviceImage->resize(202, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $large_thumbnail);
                $serviceImage->reset();
                //thumbnail for medium
                $serviceImage->resize(185, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $medium_thumbnail);
                $serviceImage->reset();
                //thumbnail for small

                $serviceImage->resize(151, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $small_thumbnail);
                $serviceImage->reset();
                //thumbnail for vsmall

                $serviceImage->resize(100, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
                $serviceImage->save($thumbnailPath . $vsmall_thumbnail);
                $serviceImage->reset();



            }

            // Update Service details
            $service->service_name = $request->service_name;
            $service->service_description = $request->service_description;
            $service->meta_keyword = $request->meta_keyword;
            $service->meta_description = $request->meta_description;

            $service->update();

            $message = 'Service Update !!!';

            return response()->json(['message' => 'Service Updated !!!'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => 'Failed to update data'
            ], 500);
        }
    }

    public function destroy($service_id)
    {
        try {
            Service::findOrFail($service_id)->delete();

            return response()->json(['message' => 'Service Deleted !!!'], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'error' => 'Failed to delete data'
            ], 500);
        }
    }
}
