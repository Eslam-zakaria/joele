<?php

namespace Modules\Doctor\Http\Requests;

use App\Enums\GeneralEnums;
use App\Rules\CategoryActiveRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class DoctorStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Gate::allows('create doctor') )
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
            # Model validation
            'language' => ['required', 'in:1,2,3'], # 1 => English | 2 => Arabic | 3 => Both
            'image' => ['required', 'image', 'mimes:' . GeneralEnums::mimesType],
            'title_header_option' => ['required', 'in:h1,h2,h3,h4,h5,h6'],
            'specialization_title_header_option' => ['required', 'in:h1,h2,h3,h4,h5,h6'],
            'en.name' => 'required_if:language,1,3',
            'ar.name' => 'required_if:language,2,3',
            'en.description' => 'required_if:language,1,3',
            'ar.description' => 'required_if:language,2,3',
            'category_id' => ['required', 'numeric', 'exists:categories,id', new CategoryActiveRule('blogs')],
            'services' => ['required', 'array'],
            'services.*' => ['exists:services,id'],
            'en.experience_years' => ['required_if:language,1,3'],
            'ar.experience_years' => ['required_if:language,2,3'],

            # Branches validation.
            'branches' => ['required', 'array'],
            'branches.*' => ['exists:branches,id'],

            # Specializations validation.
            'specializations' => ['required', 'array'],
            'specializations.*' => ['exists:specializations,id'],

            # Experience validation.
            'experience.*.en.company_name' => ['required_if:language,1,3', 'max:255'],
            'experience.*.ar.company_name' => ['required_if:language,2,3', 'max:255'],
            'experience.*.en.specialization' => ['required_if:language,1,3', 'max:255'],
            'experience.*.ar.specialization' => ['required_if:language,2,3', 'max:255'],

            # Social media validation.
            'social.instagram' => ['nullable', 'url', 'max:255'],
            'social.youtube' => ['nullable', 'url', 'max:255'],
            'social.facebook' => ['nullable', 'url', 'max:255'],
            'social.twitter' => ['nullable', 'url', 'max:255'],
            'social.snapchat' => ['nullable', 'url', 'max:255'],
            'social.whats_app' => ['nullable', 'url', 'max:255'],
            'social.email' => ['nullable', 'email:rfc', 'max:255'],

            # Seo validation.
            'en.meta_title' => ['nullable', 'max:255'],
            'ar.meta_title' => ['nullable', 'max:255'],
            'en.canonical' => ['nullable', 'max:255'],
            'ar.canonical' => ['nullable', 'max:255'],
            'en.slug' => ['required_if:language,1,3', 'unique:doctor_translations,slug', 'max:255'],
            'ar.slug' => ['required_if:language,2,3', 'unique:doctor_translations,slug', 'max:255'],
            'en.new_slug' => ['nullable', 'unique:doctor_translations,new_slug', 'max:255'],
            'ar.new_slug' => ['nullable', 'unique:doctor_translations,new_slug', 'max:255'],
            'en.meta_description' => ['nullable'],
            'ar.meta_description' => ['nullable'],
            'en.meta_keywords' => ['nullable', 'max:255'],
            'ar.meta_keywords' => ['nullable', 'max:255'],
            'en.alt_image' => ['nullable', 'max:255'],
            'ar.alt_image' => ['nullable', 'max:255'],
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
            'en.experience_years.required_if' => 'The English experience years field is required.',
            'ar.experience_years.required_if' => 'The Arabic experience years field is required.',
        ];
    }
}
