<?php

namespace App\Http\Requests\Ivestment;

use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreInvestmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (auth()->user()->can('Investment create')) {
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
            'title' => ['required', 'string', 'max:200'],
            'slug' => ['required', 'string', Rule::unique('investments', 'slug')->withoutTrashed(), new SlugRule],
            'description' => ['required', 'string'],
            'capital' => ['required'],
            'start_year' => ['required'],
            'payback_period' => ['required'],
            'roi' => ['required'],
            'page_id' => ['nullable', Rule::exists('pages', 'id')->withoutTrashed()],
            'project_type_id' => ['nullable', Rule::exists('project_types', 'id')->withoutTrashed()],
            'stage' => ['nullable', 'in:completed,ongoing'],
            'short_description' => ['nullable', 'string'],
            'main_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048', 'dimensions:width=1340,height=960'],
            'mobile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg', 'max:2048', 'dimensions:width=767,height=767'],

            //meta data
            'html_title' => 'required|string',
            'meta_description' => 'required|string',
            'meta_keyword' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'main_image.dimensions' => 'Main image should be 1340px x 960px',
            'mobile_image.dimensions' => 'Mobile image should be 767px x 767px',
            'page_id.exists' => 'Sector does not exist',
            'project_type_id.exists' => 'Project type does not exist',
        ];
    }
}
