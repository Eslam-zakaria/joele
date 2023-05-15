<?php

namespace Modules\Branch\Http\Requests;

use App\Enums\GeneralEnums;
use App\Rules\CategoryActiveRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BranchStoreRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Gate::allows('create branch') )
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
            'offer_image' => ['required', 'image', 'mimes:' . GeneralEnums::mimesType],
            'en.name' => ['required', 'max:255'],
            'ar.name' => ['required', 'max:255'],
            'en.slug' => ['required', 'max:255'],
            'ar.slug' => ['required', 'max:255'],
            'en.address' => ['required', 'max:255'],
            'ar.address' => ['required', 'max:255'],
            'categories' => ['required', 'array'],
            'categories.*.*' => [new CategoryActiveRule('branches')],
            'phone' => ['required', 'numeric'],
            'another_phone' => ['nullable', 'numeric'],
            'map_link' => ['required', 'string'],
        ];
    }

}
