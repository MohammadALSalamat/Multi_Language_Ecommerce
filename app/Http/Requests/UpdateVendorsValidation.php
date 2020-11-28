<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVendorsValidation extends FormRequest
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
            // validatoin
            'name' => 'required|string',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "هذا الحقل مطلوب",
            'email.email' => "ادخل عنوان بريد إلكتروني صالح.",
            'mobile.numeric' => "ادخل ارقام فقط.",
            'name.string' => 'ادخل احرف فقط'
        ];
    }
}
