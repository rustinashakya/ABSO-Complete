<?php

namespace App\Http\Requests\Team;

use App\Enums\TeamTypeEnum;
use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTeamRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->can('Team create')) {
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
            'name' => ['required', 'string', 'max:200'],
            'slug' => ['nullable', Rule::unique('teams', 'slug')->withoutTrashed(), new SlugRule],
            'profile_image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048', 'dimensions:height=340,width=450'],
            'type'=> ['nullable', Rule::in(array_column(TeamTypeEnum::cases(), 'value'))],
            'order_by' => ['nullable', 'numeric', Rule::unique('teams', 'order_by')],
            'designation_id' => ['Required', Rule::exists('designations', 'id')->withoutTrashed()],
            'experience' => ['nullable', 'string'],
            'facebook' => ['nullable', 'url'],
            'twitter' => ['nullable', 'url'],
            'instagram' => ['nullable', 'url'],
            'description' => ['nullable'],
            'speciality' => ['nullable'],

            'html_title' => ['nullable'],
            'meta_keyword' => ['nullable'],
            'meta_description' => ['nullable'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is required.',
            'name.max' => 'The name may not be greater than 200 characters.',
            'slug.required' => 'The slug field is required.',
            'slug.unique' => 'The slug has already been taken.',
            'profile_image.required' => 'The image field is required.',
            'profile_image.image' => 'The image must be an image.',
            'profile_image.dimensions' => 'The image should be 450px x 340px',
            'type.required' => 'The type field is required.',
            'order_by.unique' => 'The order by has already been taken.',
            'position.required' => 'The Designation field is required.',
            'experience.required' => 'The experience field is required.',
            'description.required' => 'The description field is required.',
            'description.max' => 'The description may not be greater than 64KB.',
            'facebook.url' => 'The facebook field must be a valid URL.',
            'twitter.url' => 'The twitter field must be a valid URL.',
            'instagram.url' => 'The instagram field must be a valid URL.',
            'speciality.required' => 'The speciality field is required.',

            //meta data
            'meta_description.required' => 'The meta description field is required.',
            'meta_keyword.required' => 'The meta keyword field is required.',
            'html_title.required' => 'The html title field is required.',
        ];
    }
}
