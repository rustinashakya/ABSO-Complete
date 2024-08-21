<?php

namespace App\Http\Requests\Service;

use App\Http\Livewire\ServiceAccordion;
use App\Rules\SlugRule;
use App\Rules\ValidYouTubeLink;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends FormRequest
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
            'youtube_link' => $request->media_type == 'youtube1' ? ['nullable', new ValidYouTubeLink] : 'nullable',
            'name' => 'required|max:200',
            'slug' => ['nullable', 'max:100', Rule::unique('pages', 'slug')->withoutTrashed(), new SlugRule],
            'sub_title' => ['nullable', 'string', 'max:255'],
            'description' => 'nullable',
            'html_title' => 'nullable',
            'meta_description' => 'nullable',
            'meta_keyword' => 'nullable',
            'main_image' => $request->media_type == 'image1' ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'dimensions:width=1540,height=850'] : 'nullable',
            'mobile_image' => $request->media_type == 'image1' ? ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'dimensions:width=767,height=767'] : 'nullable',
            'order_by'=> ['nullable', 'numeric', Rule::unique('pages', 'order_by')->where('type', 'service')->withoutTrashed()],
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
            'sub_title.max' => 'The Sub Title field length should not be greater than 255',
            'html_title' => 'The Html Title field is required',
            'main_image.required' => 'Main image field is required',
            'mobile_image.required' => 'Main image field is required',
            'description.required' => 'Description field is required',
            'description.max' => 'The Description field length should not be greater than 64KB',
            'main_image.image' => 'Main image must be image',
            'mobile_image.required' => 'Mobile image field is required',
            'mobile_image.image' => 'Mobile image must be image',
            'main_image.max' => 'Main image maximum size is 2MB',
            'main_image.dimensions' => 'Main image must be 1540px X 850px.',
            'mobile_image.dimensions' => 'Mobile image must be 767px X 767px',
            'mobile_image.max' => 'Main image maximum size is 2MB',
            'youtube_link.required' => 'The youtube link field is required.',
            'youtube_link.regex' => 'The youtube link is Invalid.',
            'order_by.numeric' => 'The order by field must be a number.',

            //accordion validation
            'rows.*.title.required' => 'The Title field is required',
            'rows.*.title.max' => 'The Title field length should not be greater than 150',
            'rows.*.body.required' => 'The Body field is required',
        ];
    }
}
