<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingsRequest extends FormRequest
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
            'id' => 'required|exists:settings',
            'value' => 'required',
            'plain_value' => 'required|nullable|numeric',
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
