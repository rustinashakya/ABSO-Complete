<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::latest()
            ->searchClient($request->name, $request->slug, $request->designation)
            ->paginate(15);
        return view('admin.client.index', compact('clients'));
    }

    public function create()
    {
        return view('admin.client.create');
    }

    public function store(StoreClientRequest $request)
    {
        try {
            $time = time();

            if ($request->hasfile('profile_image')) {
                $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $home = 'home_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('profile_image');
                $thumbnailPath = public_path() . '/storage/uploads/clients/profile_image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/clients/profile_image/';
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
                $profile_image = $filename_to_store;

                //thumbnail for admin panel

                $categoryImage->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin, 90);
                $categoryImage->reset();

                //thumbnail for home page

                $categoryImage->resize(80, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $home, 90);
                $categoryImage->reset();
            } else {
                $profile_image = null;
            }

            if ($request->hasfile('organisation_logo')) {
                $filenamewithextension = $request->file('organisation_logo')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('organisation_logo')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $home = 'home_' . $filename . '_' . $time . '.' . $extension;
                $mobile = 'mobile_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('organisation_logo');
                $thumbnailPath = public_path() . '/storage/uploads/clients/organisation_logo/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/clients/organisation_logo/';
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
                $organisation_logo = $filename_to_store;

                //thumbnail for admin panel

                $categoryImage->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin, 90);
                $categoryImage->reset();

                //thumbnail for mobile panel

                $categoryImage->resize(145, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $mobile, 90);
                $categoryImage->reset();

                //thumbnail for home page

                $categoryImage->resize(490, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $home, 90);
                $categoryImage->reset();
            } else {
                $organisation_logo = null;
            }

            $page = Client::create([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'designation' => $request->designation,
                'description' => $request->description,
                'url' => $request->url,
                'organisation_logo' => @$organisation_logo,
                'profile_image' => @$profile_image,

                //meta data
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);

            $message = 'Client Created Successfully!';
            return redirect()->route('admin.client.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $client = Client::find($id);
        return view('admin.client.edit', compact('client'));
    }

    public function update(UpdateClientRequest $request, $id)
    {
        $client = Client::find($id);
        try {
            $time = time();

            if ($request->hasfile('profile_image')) {
                if ($client->profile_image) {
                    $path = public_path() . '/storage/uploads/clients/profile_image/' . $client->profile_image;
                    $adminPath = public_path() . '/storage/uploads/clients/profile_image/thumbnail/admin_' . $client->organisation_logo;
                    $homePath = public_path() . '/storage/uploads/clients/profile_image/thumbnail/home_' . $client->organisation_logo;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    if (File::exists($adminPath)) {
                        File::delete($adminPath);
                    }
                    if (File::exists($homePath)) {
                        File::delete($homePath);
                    }
                }
                $filenamewithextension = $request->file('profile_image')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('profile_image')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $home = 'home_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('profile_image');
                $thumbnailPath = public_path() . '/storage/uploads/clients/profile_image/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/clients/profile_image/';
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
                $profile_image = $filename_to_store;

                //thumbnail for admin panel

                $categoryImage->resize(200, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin, 90);
                $categoryImage->reset();

                //thumbnail for home page

                $categoryImage->resize(80, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $home, 90);
                $categoryImage->reset();
            }

            if ($request->hasfile('organisation_logo')) {
                if ($client->organisation_logo) {
                    $path = public_path() . '/storage/uploads/clients/organisation_logo/' . $client->organisation_logo;
                    $adminPath = public_path() . '/storage/uploads/clients/organisation_logothumbanil/admin_' . $client->organisation_logo;
                    $homePath = public_path() . '/storage/uploads/clients/organisation_logothumbanil/home_' . $client->organisation_logo;
                    if (File::exists($path)) {
                        File::delete($path);
                    }
                    if (File::exists($adminPath)) {
                        File::delete($adminPath);
                    }
                    if (File::exists($homePath)) {
                        File::delete($homePath);
                    }
                }

                $filenamewithextension = $request->file('organisation_logo')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('organisation_logo')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;
                $admin = 'admin_' . $filename . '_' . $time . '.' . $extension;
                $home = 'home_' . $filename . '_' . $time . '.' . $extension;
                $mobile = 'mobile_' . $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('organisation_logo');
                $thumbnailPath = public_path() . '/storage/uploads/clients/organisation_logo/thumbnail/';
                $originalPath = public_path() . '/storage/uploads/clients/organisation_logo/';
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
                $organisation_logo = $filename_to_store;

                //thumbnail for admin panel

                $categoryImage->resize(400, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $admin, 90);
                $categoryImage->reset();

                //thumbnail for mobile panel

                $categoryImage->resize(145, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $mobile, 90);
                $categoryImage->reset();

                //thumbnail for home page

                $categoryImage->resize(490, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $categoryImage->sharpen(10);
                $categoryImage->save($thumbnailPath . $home, 90);
                $categoryImage->reset();
            }

            $client->update([
                'name' => $request->name,
                'slug' => Str::slug($request->slug),
                'designation' => $request->designation,
                'description' => $request->description,
                'url' => $request->url,
                'organisation_logo' => $organisation_logo ?? $client->organisation_logo,
                'profile_image' => $profile_image ?? $client->profile_image,

                //meta data
                'html_title' => $request->html_title,
                'meta_description' => $request->meta_description,
                'meta_keyword' => $request->meta_keyword,
            ]);

            $message = 'Client Updated Successfully!';
            return redirect()->route('admin.client.index')->withMessage($message);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        return redirect()->route('admin.client.index')->withMessage('Client deleted successfully');
    }
}
