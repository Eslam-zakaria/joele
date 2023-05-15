<?php

namespace Modules\ContactUs\Http\Requests;

use App\Enums\GeneralEnums;
use Illuminate\Foundation\Http\FormRequest;

class ContactUsStoreRequest extends FormRequest
{
        /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'name' => ['required', 'max:255'],
            'phone' => ['required', 'max:20'],
            'message' => ['required'],
            'subject' => ['required', 'in:' . implode(',', array_keys(GeneralEnums::Contact_Us_Topic))],
        ];
    }

}
