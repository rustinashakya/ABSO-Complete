<?php

namespace App\Http\Requests\News;

use App\Rules\SlugRule;
use App\Rules\ValidYouTubeLink;
use Illuminate\Foundation\Http\FormRequest;

class UpdateNewsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->can('News create')) {
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
        $request = request();
        return [
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', 'alpha_dash', new SlugRule],
            'published_date' => ['required', 'date'],
            'type' => ['required', 'in:youtube,image'],
            'youtube_link' => $request->type == 'youtube' ? ['required', new ValidYouTubeLink] : 'nullable',
            'main_image' => $request->type == 'image' ? 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048|dimensions:width=1540,height=810' : 'nullable',
            'description' => 'required|string',
            'html_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keyword' => 'required|string',
            'author'=> ['required', 'string', 'max:155'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title field is required.',
            'slug.required' => 'Slug field is required',
            'slug.unique' => 'Slug already exists',
            'published_date.required' => 'Slug field is required',
            'published_date.date' => 'Publish date is not valid',
            'youtube_link.required' => 'Youtube link field is required',
            'youtube_link.regex' => 'Youtube link is not valid',
            'main_image.required' => 'Main image field is required',
            'main_image.mimes' => 'Main image should be of type jpeg,png,jpg,gif,svg',
            'main_image.max' => 'Main image should be less than 2MB',
            'main_image.dimensions'=>'Image should be of size 1540px X 810px',
            'description.required' => 'Description field is required',
            'description.max' => 'Description should be less than 64KB',
            'author.required' => 'Author field is required',
            'author.max' => 'Author name should be less than 155 characters',

            //meta data
            'meta_description.required' => 'Meta description field is required',
            'meta_keyword.required' => 'Meta keyword field is required',
            'html_title.required' => 'HTML title field is required',
        ];
    }
}
