<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InputRequest extends FormRequest
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
            'budget' => 'required',
            'money' => 'required|integer',
            'memo' => 'max:30',
        ];
    }
    public function messages()
    {
        return [
            'budget.required' => '入力してください',
            'money.required' => '入力してください',
            'money.integer' => '数字で入力してください',
            'memo.,max' => '30文字以内で入力してください',
        ];
    }
}
