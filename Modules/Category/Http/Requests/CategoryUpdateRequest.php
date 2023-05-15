<?php

namespace Modules\Category\Http\Requests;

use  App\Enums\CategoriesRelationEnum;
use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class CategoryUpdateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Gate::allows('edit category') )
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
            'image' => ['nullable', 'image', 'mimes:' . GeneralEnums::mimesType],
            'ar.name' => ['required', 'string', 'max:255'],
            'en.name' => ['required', 'string', 'max:255'],
            'ar.slug' => ['required', 'string', 'max:255'],
            'en.slug' => ['required', 'string', 'max:255'],
            'ar.description' => ['nullable', 'string', 'max:255'],
            'en.description' => ['nullable', 'string', 'max:255'],
            'ar.alt_image' => ['nullable', 'string', 'max:255'],
            'en.alt_image' => ['nullable', 'string', 'max:255'],
            'ar.meta_title' => ['nullable', 'string', 'max:255'],
            'en.meta_title' => ['nullable', 'string', 'max:255'],
            'ar.meta_description' => ['nullable', 'string'],
            'en.meta_description' => ['nullable', 'string'],
            'ar.meta_keywords' => ['nullable', 'string', 'max:255'],
            'en.meta_keywords' => ['nullable', 'string', 'max:255'],
            'ar.canonical' => ['nullable', 'string', 'max:255'],
            'en.canonical' => ['nullable', 'string', 'max:255'],
            'display_in' => ['required', 'array'],
            'display_in.*' => ['in:' . implode(',', CategoriesRelationEnum::Models)],
            'service_items_per_row' => ['nullable', Rule::requiredIf( function (){
                return in_array('services', request()->display_in);
            }), 'in:' . implode(',',array_keys(CategoriesRelationEnum::GridOptions))],
        ];
    }

}
