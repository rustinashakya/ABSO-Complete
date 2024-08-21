<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSectorRequest extends FormRequest
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
        $request = request();
        return [
            'youtube_link' => $request->media_type == 'youtube1' ? ['nullable', 'url'] : 'nullable',
            'name' => 'required|max:200',
            'slug' => ['nullable', 'max:100'],
            'parent_id' => ['nullable', 'numeric', 'exists:pages,id'],
            'sub_title' => $request->type == 'static_page' ? ['nullable', 'string', 'max:255'] : 'nullable|string|max:255',
            'description' => 'required',
            'html_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keyword' => 'nullable',
            'main_image' => $request->media_type == 'image1' ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'dimensions:width=700,height=700'] : 'nullable',
            'mobile_image' => $request->media_type == 'image1' ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'dimensions:width=770,height=770'] : 'nullable',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'The Title field is required',
            'name.max' => 'The Title field length should not be greater than 200',
            'slug.max' => 'The slug field length should not be greater than 100',
            'slug.required' => 'The slug field is required',
            'sub_title.required' => 'The Sub Title field is required',
            'sub_title.max' => 'The Sub Title field length should not be greater than 200',
            'html_title' => 'The Html Title field is required',
            'main_image.required' => 'Main image field is required',
            'description.required' => 'Description field is required',
            'description.max' => 'Description maximum size is 64KB',
            'main_image.image' => 'Main image must be image',
            'mobile_image.required' => 'Mobile image field is required',
            'mobile_image.image' => 'Mobile image must be image',
            'main_image.max' => 'Main image maximum size is 2MB',
            'main_image.dimensions' => 'Main image must be 700px X 700px.',
            'mobile_image.dimensions' => 'Mobile image must be 770px X 770px',
            'mobile_image.max' => 'Main image maximum size is 2MB',
            'youtube_link.required' => 'The youtube link field is required.',
            'youtube_link.regex' => 'The youtube link is Invalid.',
            'parent_id.exists' => 'The selected parent id is invalid.',
        ];
    }
}
