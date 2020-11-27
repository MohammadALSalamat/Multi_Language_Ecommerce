<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorsValidation extends FormRequest
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
            'email' => 'required|email|unique:vendors,email',
            'mobile' => 'required|numeric|unique:vendors,mobile',
            'password' => 'required|min:5',
            'logo' => 'required|mimes:png,jpg',
            'category_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => "هذا الحقل مطلوب",
            'email.unique' => "هذا البريد مستخدم بالفعل الرجاء تغيير البريد الالكتروني",
            'mobile.unique' => "هذا الرقم مستخدم بالفعل الرجاء تغيير الرقم",
            'email.email' => "ادخل عنوان بريد إلكتروني صالح.",
            'mobile.numeric' => "ادخل ارقام فقط.",
            'password.min' => "كلمة السر يجب ان تكون اكثر من 5 احرف.",
            'name.string' => 'ادخل احرف فقط'

        ];
    }
}
