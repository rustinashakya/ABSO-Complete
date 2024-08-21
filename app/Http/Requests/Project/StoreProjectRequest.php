<?php

namespace App\Http\Requests\Project;

use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->hasPermissionTo('Project create')) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:150', Rule::unique('projects', 'slug')->withoutTrashed(), new SlugRule],
            'short_description' => 'required|string|max:3000',
            'description' => 'required',
            'project_type_id' => 'required|exists:project_types,id',
            'page_id' => 'required|exists:pages,id',
            'service_id' => 'nullable|exists:pages,id',
            'stage' => 'required|in:completed,ongoing',
            'show_on_menu' => 'nullable|boolean',
            'show' => 'nullable|boolean',

            //images
            'main_image' => 'required|array|min:1',
            'main_image.*' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:width=1340,height=960',
            'mobile_image' => 'required|array|min:1',
            'mobile_image.*' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:2048|dimensions:width=767,height=767',

            //meta data
            'html_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keyword' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'slug.required' => 'The slug field is required.',
            'slug.string' => 'The slug must be a string.',
            'slug.max' => 'The slug may not be greater than 50 characters.',
            'slug.unique' => 'The slug has already been taken.',
            'short_description.required' => 'The short description field is required.',
            'short_description.max' => 'The short description may not be greater than 2000 characters.',
            'description.required' => 'The description field is required.',
            'description.max' => 'The description may not be greater than 64KB.',
            'project_type_id.required' => 'The project type field is required.',
            'project_type_id.exists' => 'The project type field is invalid.',
            'page_id.required' => 'The Sector field is required.',
            'page_id.exists' => 'The Sector field is invalid.',
            'service_id.exists' => 'The Service field is invalid.',
            'stage.required' => 'The stage field is required.',
            'stage.in' => 'The stage field is invalid.',
            'show_on_menu.boolean' => 'The show on menu field is invalid.',
            'show.boolean' => 'The show field is invalid.',
            //images
            'main_image.required' => 'The main images field is required.',
            'mobile_image.required' => 'The mobile images field is required.',
            'main_image.*.mimes' => 'The Image must be a file of type: jpeg, png, jpg, gif, svg, pdf.',
            'mobile_image.*.mimes' => 'The Image must be a file of type: jpeg, png, jpg, gif, svg, pdf.',
            'main_image.*.max' => 'The Image may not be greater than 2 MB.',
            'mobile_image.*.max' => 'The Image may not be greater than 2 MB.',
            'main_image.*.dimensions' => 'Main Image size must be 1340px X 960px.',
            'mobile_image.*.dimensions' => 'Mobile Image size must be 767px x 767px.',

            //meta data
            'html_title.required' => 'The html title field is required.',
            'meta_description.required' => 'The meta description field is required.',
            'meta_keyword.required' => 'The meta keyword field is required.',
        ];
    }
}
