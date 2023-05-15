<?php

namespace Modules\Slider\Http\Requests;

use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SliderStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ( ! Gate::allows('create slider') )
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
            'upload_type' => ['required', 'in:upload,link'],
            'image' => ['required_if:upload_type,==,upload', 'image', 'mimes:' . GeneralEnums::mimesType],
            'link' => ['required_if:upload_type,==,link', 'url'],
            'ar.first_title' => ['required', 'string', 'max:255'],
            'en.first_title' => ['required', 'string', 'max:255'],
            'ar.second_title' => ['required', 'string', 'max:255'],
            'en.second_title' => ['required', 'string', 'max:255'],
            'ar.description' => ['required', 'string', 'max:255'],
            'en.description' => ['required', 'string', 'max:255'],
        ];
    }

}
