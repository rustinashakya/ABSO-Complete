<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;

class StoreCampaignRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->can('Campaign create')) {
            return true;
        } else {
            return false;
        }
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
            'status' => 'nullable|boolean',
            'url'=> 'nullable|url',
            'images' =>'required|array',
            'images.*'=> 'image|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:min_width=576,min_height=576',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title field is required',
            'title.string' => 'Title field must be a string',
            'title.max' => 'Title field must not be greater than 255 characters',
            'youtube_link.required' => 'Youtube link field is required',
            'status.required' => 'Status field is required',
            'status.boolean' => 'Status field must be an Boolean',
            'images.required' => 'Image field is required',
            'images.array' => 'Images field must be an array',
            'images.*.max' => 'Images field must not be greater than 2MB',
            'images.*.mimes' => 'Images field must be an image',
            'images.*.image' => 'Images field must be an image',
            'images.*.dimensions' => 'Images size must be at least 576px X 576px',
        ];
    }
}
