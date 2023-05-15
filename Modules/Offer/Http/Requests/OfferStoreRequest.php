<?php

namespace Modules\Offer\Http\Requests;


use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class OfferStoreRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Gate::allows('create offer') )
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
            'image' => ['required', 'image', 'mimes:' . GeneralEnums::mimesType],
            'en.name' => ['required', 'max:255'],
            'ar.name' => ['required'],
            'price' => ['required', 'numeric', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'branches' => ['required', 'array'],
            'branches.*' => ['exists:branches,id'],
        ];
    }

}
