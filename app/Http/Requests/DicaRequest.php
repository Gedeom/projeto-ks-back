<?php

namespace App\Http\Requests;

use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Tipo;
use App\Models\User;
use App\Models\Veiculo;
use App\Models\Versao;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation;
use Illuminate\Validation\Rule;

class DicaRequest extends FormRequest
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
            'veiculo_id' => [
                'required',
                Rule::in(Veiculo::pluck('id', 'id'))
            ],
            'user_id' => [
                'required',
                Rule::in(User::pluck('id', 'id'))
            ],
        ];
    }

    public function messages()
    {
        return [
            'veiculo_id.required' => 'Informe o Veículo',
            'user_id.required' => 'Informe o usuário',
            'descricao.required' => 'Informe a descrição'
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
        $id = (int) $this->route('tip');
        $validation = $validator;


        if ($validation->errors()->count()) {
            throw new HttpResponseException(response()->json([
                'msg' => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors' => $validation->messages(),
                'url' => $id ? route('tip.update', ['tip' => $id]) : route('tip.store')
            ], 403));
        }
    }
}
