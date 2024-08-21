<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class SiteSettingController extends Controller
{
    public function edit($id)
    {
        $site_setting = SiteSetting::findOrFail($id);
        $languages = Language::get();
        return view('setting', compact('site_setting', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $site_setting = SiteSetting::findOrFail($id);
        $data = $request->all();

        $validator = Validator::make(
            $data,
            [
                'title' => 'required|string|max:150',
                'phone_no' => [
                    'required',
                    'regex:/^\+?[0-9\s\-\(\)]{7,15}$/'
                ],
                'email' => 'required|email|max:200',
                'facebook' => ['nullable', 'regex:/^(https?:\/\/)?(www\.)?facebook\.com\/[a-zA-Z0-9._-]+\/?$/'],
                'youtube_link' => ['nullable', 'url'],
                'google_map'=> ['sometimes', 'required', 'regex:/^(https?:\/\/)?(www\.)?google\.com\/.*$/'],
                'twitter' => ['sometimes', 'nullable', 'regex:/^https?:\/\/(?:www\.)?x\.com\/[a-zA-Z0-9_]{1,15}$/'],
                'instagram' => ['nullable', 'regex:/^https?:\/\/(?:www\.)?instagram\.com\/[a-zA-Z0-9_\.]+(?:\/\?hl=en)?$/'],
                'pinterest' => ['nullable', 'url'],
                'site_logo' => ['nullable', 'image', 'mimes:jpg,png,jpeg,webp,gif', 'max:2048'],
                'site_favicon' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
                'html_title' => 'nullable|string',
                'meta_keyword' => 'nullable|string',
                'meta_description' => 'nullable|string',
                'site_description'=> ['nullable'],
                'address' => ['required', 'string'],
                'postal_code' => 'nullable',
            ],
            $messages = [
                'title.required' => 'Title field is required.',
                'title.max' => 'Title should not be more than 150 characters.',
                'google_map.required' => 'Google map field is required.',
                'site_logo.required' => 'Site Logo field is required.',
                'address.required' => 'Address field is required.',
                'phone_no.required' => 'Head office number field is required.',
                'phone_no.regex' => 'Enter a valid number.',
                'email.required' => 'Email field is required.',
                'email.email' => 'Enter a valid email.',
                'facebook.regex' => 'Enter a valid facebook page link.',
                'instagram.regex' => 'Enter a valid instagram page link.',
                'twitter.regex' => 'Enter a valid youtube page link.',
                'instagram.regex' => 'Enter a valid Instagram page link.',
                'site_logo.image' => 'Enter a valid image.',
                'site_logo.required' => 'Site Logo field is required.',
                'site_favicon.image' => 'Enter a valid image.',
                'site_favicon.required' => 'Site favicon field is required.',
                'site_logo.max' => 'The image size should not be more than 2MB.',
                'site_favicon.max' => 'The image size should not be more than 2MB.',
                'meta_description.required' => 'Meta description field is required.',
                'html_title.required' => 'Html title field is required.',
                'meta_keyword.required' => 'Meta keyword field is required.',
                'site_description.required' => 'Description field is required.',
            ]
        );

        if ($validator->fails()) {
            return back()
                ->withErrors($validator)
                ->withInput();
        }

        $time = time();

            if ($request->hasfile('site_logo')) {
                if($site_setting->site_logo){
                    Storage::delete('storage/uploads/site_setting/site_logo/'.$site_setting->site_logo);
                }
                $filenamewithextension = $request->file('site_logo')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('site_logo')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('site_logo');
                $originalPath = public_path() . '/storage/uploads/site_setting/site_logo/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                $categoryImage = Image::make($main_image);
                $categoryImage->backup();

                $categoryImage->save($originalPath . $filename_to_store);
                $site_logo = $filename_to_store;
            }

            if ($request->hasfile('site_favicon')) {

                if($site_setting->site_favicon){
                    Storage::delete('storage/uploads/site_setting/site_favicon/' .$site_setting->site_favicon);
                }
                $filenamewithextension = $request->file('site_favicon')->getClientOriginalName();
                $filename1 = pathinfo($filenamewithextension, PATHINFO_FILENAME);
                $filename = str_replace(' ', '_', $filename1);
                $extension = $request->file('site_favicon')->getClientOriginalExtension();
                //filename to store
                $filename_to_store = $filename . '_' . $time . '.' . $extension;

                $main_image = $request->file('site_favicon');
                $originalPath = public_path() . '/storage/uploads/site_setting/site_favicon/';
                if (!File::isDirectory($originalPath)) {
                    File::makeDirectory($originalPath, 0777, true, true);
                }
                $categoryImage = Image::make($main_image);
                $categoryImage->backup();

                $categoryImage->save($originalPath . $filename_to_store);
                $site_favicon = $filename_to_store;
            }

        $site_setting->Update([
            'title' => $data['title'] ?? null,
            'phone_no' => $data['phone_no'] ?? null,
            'email' => $data['email'] ?? null,
            'language_id' => $data['language_id'] ?? null,
            'google_map' => $data['google_map'] ?? null,
            'facebook' => $data['facebook'] ?? null,
            'youtube_link' => $data['youtube_link'] ?? null,
            'instagram' => $data['instagram'] ?? null,
            'google_plus' => $data['google_plus'] ?? null,
            'twitter'=> $data['twitter'] ?? null,
            'address' => $data['address'] ?? null,
            'pinterest' => $data['pinterest'] ?? null,
            'postal_code' => $data['postal_code'] ?? null,
            'site_description'=> $data['site_description'] ?? null,
            'site_favicon' => $site_favicon ?? $site_setting->site_favicon,
            'site_logo' => $site_logo ?? $site_setting->site_logo,
            'html_title' => $data['html_title'] ?? null,
            'meta_description' => $data['meta_description'] ?? null,
            'meta_keyword' => $data['meta_keyword'] ?? null,

        ]);
        $message = 'Setting Updated Successfully!';
        return redirect()->back()->withSuccess('Setting Updated Successfully!')->withMessage($message);
    }
}
