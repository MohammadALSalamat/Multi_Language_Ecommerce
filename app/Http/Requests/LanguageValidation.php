<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LanguageValidation extends FormRequest
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
            //set the valdation
            'name' => 'required|string|max:100',
            'abbr' => 'required|string|max:10',
            'direction' => 'required|in:rtl,ltr',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'الحقل مطلوب',
            'name.string' => 'الرجاء ادخال احرف فقط',
            'name.max' => 'الرجاء ادخال 100 حرف فقط',
            'abbr.string' => 'الرجاء ادخال احرف فقط',
            'abbr.max' => 'الرجاء ادخال 10 حرف فقط',
            'abbr.required' => 'الحقل مطلوب',
            'direction.required' => 'الحقل مطلوب',
        ];
    }
}
