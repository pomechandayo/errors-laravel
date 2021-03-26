<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required | email',
            'password' => 'required | min:6',
            'title' => 'required | max:100' ,
            'body' =>  'required',
        ];
       
    }

    public function messages() {
        return [
            'title.required' => 'タイトルは必須です' ,
            'title.min' => 'タイトルは100文字までです' ,
            'body.required' => '本文は必須です' ,
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'ユーザー名',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'title' => 'タイトル',
            'body' => '本文',
        ];
    }
}
