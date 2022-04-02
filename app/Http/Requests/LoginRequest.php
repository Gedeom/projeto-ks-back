<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
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
            'email' => 'email|required',
            'password' => 'required',
        ];
    }

    public function withValidator($validator)
    {

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json([
                'msg' => 'Falha ao suceder Login!',
                'status' => false,
                'errors' => $validator->errors(),
                'url' => route('user.login')
            ], 403));
        }
    }
}
