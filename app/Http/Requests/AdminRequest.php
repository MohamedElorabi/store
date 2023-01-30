<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6',
        ];
    }


    public function messages()
    {
        return [

            'email.required' => 'يرجى إدخال البريد الإلكترونى',
            'email.email' => 'صيغة البريد الإلكترونى غير صحيحة',
            'password.required' => 'يرجى إدخال كلمة المرور',
            'password.min:6' => 'يجب كتابة كلمة المرور بحد أدنى 6 أحرف أو أرقام',
        ];
    }
}
