<?php

namespace Modules\Service\Http\Requests;

use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ServiceStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (! Gate::allows('create service'))
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
            'language' => ['required', 'in:1,2,3'], # 1 => English | 2 => Arabic | 3 => Both
            'image' => ['required', 'image', 'mimes:' . GeneralEnums::mimesType],
            'category_id' => ['required', 'exists:categories,id'],
            'title_header_option' => ['required', 'in:h1,h2,h3,h4,h5,h6'],
            'en.name' => ['required_if:language,1,3', 'max:255'],
            'ar.name' => ['required_if:language,2,3', 'max:255'],
            'en.slug' => ['required_if:language,1,3', 'unique:service_translations,slug'],
            'ar.slug' => ['required_if:language,2,3', 'unique:service_translations,slug'],
            'en.new_slug' => ['nullable', 'unique:blog_translations,new_slug', 'max:255'],
            'ar.new_slug' => ['nullable', 'unique:blog_translations,new_slug', 'max:255'],
            'en.description' => 'required_if:language,1,3',
            'ar.description' => 'required_if:language,2,3',
            'en.content' => 'required_if:language,1,3',
            'ar.content' => 'required_if:language,2,3',
            'en.meta_title' => ['nullable', 'max:255'],
            'ar.meta_title' => ['nullable', 'max:255'],
            'en.canonical' => ['nullable', 'max:255'],
            'ar.canonical' => ['nullable', 'max:255'],
            'en.meta_description' => ['nullable'],
            'ar.meta_description' => ['nullable'],
            'en.meta_keywords' => ['nullable', 'max:255'],
            'ar.meta_keywords' => ['nullable', 'max:255'],
            'en.alt_image' => ['nullable', 'max:255'],
            'ar.alt_image' => ['nullable', 'max:255'],

            # Question validation.
            'experience.*.en.question' => ['required_if:language,1,3', 'max:255'],
            'experience.*.ar.question' => ['required_if:language,2,3', 'max:255'],
            'experience.*.en.answer' => ['required_if:language,1,3'],
            'experience.*.ar.answer' => ['required_if:language,2,3'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'en.name.required_if' => 'The English name field is required.',
            'ar.name.required_if' => 'The Arabic name field is required.',
            'en.slug.required_if' => 'The English slug field is required.',
            'ar.slug.required_if' => 'The Arabic slug field is required.',
            'en.new_slug.required_if' => 'The English new slug field is required.',
            'ar.new_slug.required_if' => 'The Arabic new slug field is required.',
            'en.description.required_if' => 'The English description field is required.',
            'ar.description.required_if' => 'The Arabic description field is required.',
            'en.content.required_if' => 'The English content field is required.',
            'ar.content.required_if' => 'The Arabic content field is required.',
            'experience.*.en.question.required_if' => 'The English meta title field is required.',
            'experience.*.ar.question.required_if' => 'The Arabic meta title field is required.',
            'experience.*.en.answer.required_if' => 'The English canonical field is required.',
            'experience.*.ar.answer.required_if' => 'The Arabic canonical field is required.',
        ];
    }
}
