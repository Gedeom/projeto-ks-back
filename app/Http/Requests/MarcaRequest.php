<?php

namespace App\Http\Requests;

use App\Models\Marca;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation;

class MarcaRequest extends FormRequest
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
            'descricao' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'descricao.required' => 'Informe a descricão'
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Validation\Validator $validator
     * @return HttpResponseException
     */
    public function withValidator($validator)
    {
        $id = (int) $this->route('brand');

        $validation = $validator;

        if (Marca::hasMarca($this->descricao, $id)) {
            $validation->errors()->add('descricao', 'Já existe essa marca cadastrado!');
        }


        if ($validation->messages()->count()) {
            throw new HttpResponseException(response()->json([
                'msg' => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors' => $validator->messages(),
                'url' => $id ? route('brand.update', ['brand' => $id]) : route('brand.store')
            ], 403));
        }
    }
}
