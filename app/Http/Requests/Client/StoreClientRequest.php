<?php

namespace App\Http\Requests\Client;

use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=> ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:50', Rule::unique('clients', 'slug')->withoutTrashed(), new SlugRule],
            'designation' => ['nullable', 'string', 'max:100'],
            'profile_image' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048', 'dimensions:width=500,height=500'],
            'organisation_logo' => ['required', 'image', 'mimes:jpg,png,jpeg', 'max:2048', 'dimensions:width=150,height=150'],
            'description' => ['nullable', 'string'],
            'url'=> ['nullable', 'url'],

            //meta data
            'html_title' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'meta_keyword' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required',
            'profile_image.required' => 'Profile Image field is required',
            'organisation_logo.required' => 'Organisation Logo field is required',
            'description.required' => 'Description field is required',
            'url.required' => 'Organisation website is required',
            'designation.required' => 'Designation field is required',
            'profile_image.image' => 'Profile Image must be an image',
            'organisation_logo.image' => 'Organisation Logo must be an image',
            'url.url' => 'Organisation website must be a valid URL',
            'profile_image.dimensions' => 'Profile Image dimensions must be 500px x 500px',
            'organisation_logo.dimensions' => 'Organisation Logo dimensions must be 150px x 150px',
            'slug.unique' => 'Slug must be unique',
            'slug.required' => 'Slug field is required',

            //meta data 
            'html_title.required' => 'The html title field is required.',
            'meta_description.required' => 'The meta description field is required.',
            'meta_keyword.required' => 'The meta keyword field is required.',
        ];
    }
}
