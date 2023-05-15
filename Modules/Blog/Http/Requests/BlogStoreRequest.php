<?php

namespace Modules\Blog\Http\Requests;

use App\Enums\GeneralEnums;
use App\Rules\CategoryActiveRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BlogStoreRequest extends FormRequest
{

    /**use Modules\Blog\Http\Requests\BlogUpdateRequest;
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Gate::allows('create blog') )
            return false;

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            # Model validation.
            'image' => ['required', 'image', 'mimes:' . GeneralEnums::mimesType],
            'category_id' => ['required', 'numeric', 'exists:categories,id', new CategoryActiveRule('blogs')],
            'doctor_id' => ['required', 'numeric', 'exists:doctors,id'],
            'parent_id' => ['nullable', 'numeric', 'exists:blogs,id'],
            'title' => ['required', 'max:255'],
            'title_header_optional' => ['required', 'in:h1,h2,h3,h4,h5,h6'],
            'description' => ['required'],
            'locale' => ['required'],
            #'en.content' => ['required'],
            #'ar.content' => ['required'],

            # Sections validation.
            //'sections.*.en.section_color' => ['nullable'],
            'sections.*.section_color' => ['required'],
            //'sections.*.en.title' => ['nullable', 'max:255'],
            //'sections.*.en.content' => ['nullable'],
            'sections.*.title' => ['required', 'max:255'],
            'sections.*.content' => ['required'],
            'sections.*.color_border' => ['nullable'],
            'sections.*.h_optionl' => ['required'],
            'sections.*.sorting' => ['required'],

            # Social media validation.
            //'en.meta_title' => ['nullable', 'max:255'],
            'meta_title' => ['nullable', 'max:255'],
            //'en.canonical' => ['nullable', 'max:255'],
            'canonical' => ['nullable', 'max:255'],
            //'en.slug' => ['nullable', 'unique:blogs,slug', 'max:255'],
            'slug' => ['required', 'unique:blogs,slug', 'max:255'],
            //'en.new_slug' => ['nullable', 'unique:blogs,new_slug', 'max:255'],
            'new_slug' => ['nullable', 'unique:blogs,new_slug', 'max:255'],
            //'en.meta_description' => ['nullable'],
            'meta_description' => ['nullable'],
            //'en.meta_keywords' => ['nullable', 'max:255'],
            'meta_keywords' => ['nullable', 'max:255'],
            //'en.alt_image' => ['nullable', 'max:255'],
            'alt_image' => ['nullable', 'max:255'],

            # Question validation.
            //'experience.*.en.question' => ['required', 'max:255'],
            'experience.*.question' => ['required', 'max:255'],
            //'experience.*.en.answer' => ['required'],
            'experience.*.answer' => ['required'],
        ];
    }
}
