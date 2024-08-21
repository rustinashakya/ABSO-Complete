<?php

namespace App\Http\Requests\Vacancy;

use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VacancyStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(auth()->user()->can('Vacancy create')) {
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
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'max:100', new SlugRule, Rule::unique('vacancies', 'slug')->withoutTrashed()],
            'image'=> ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'vacancy_level_id'=> ['required', Rule::exists('vacancy_levels', 'id')],
            'deadline' => ['required', 'date'],
            'short_description'=> ['required', 'max:2000'],
            'reports_to'=> ['nullable', 'string', 'max:120'],
            'status'=> ['required', 'string'],
            'description' => ['required'],
            'html_title'=> ['required', 'string'],
            'meta_description'=> ['required', 'string'],
            'meta_keyword'=> ['required', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'The title field is required.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'slug.required' => 'The slug field is required.',
            'slug.max' => 'The slug may not be greater than 100 characters.',
            'image.required' => 'The image field is required.',
            'image.image' => 'The image must be an image.',
            'image.max' => 'The image may not be greater than 2048 characters.',
            'vacancy_level_id.required' => 'The level field is required.',
            'deadline.required' => 'The deadline field is required.',
            'short_description.required' => 'The short description field is required.',
            'reports_to.required' => 'The reports to field is required.',
            'status.required' => 'The status field is required.',
            'description.required' => 'The description field is required.',
            'description.max' => 'The description may not be greater than 64KB.',
            'html_title.required' => 'The html title field is required.',
            'meta_description.required' => 'The meta description field is required.',
            'meta_keyword.required' => 'The meta keyword field is required.',
        ];
    }
}
