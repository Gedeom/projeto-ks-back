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

class VeiculoRequest extends FormRequest
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
            'tipo_id' => [
                'required',
                Rule::in(Tipo::pluck('id', 'id'))
            ],
            'user_id' => [
                'required',
                Rule::in(User::pluck('id', 'id'))
            ],
            'modelo_id' => [
                'required',
                Rule::in(Modelo::pluck('id', 'id'))
            ],
            'versao_id' => [
                'present',
                'nullable',
                Rule::in(Versao::pluck('id', 'id'))
            ],
        ];
    }

    public function messages()
    {
        return [
            'tipo_id.required' => 'Informe o tipo',
            'user_id.required' => 'Informe o usuário',
            'modelo_id.required' => 'Informe o modelo'
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
        $id = (int) $this->route('vehicle');
        $validation = $validator;

        if (Veiculo::hasVeiculo((int)$this->tipo_id, (int)$this->modelo_id, (int)$this->versao_id, $id)) {
            $validation->errors()->add('veiculo', 'Já existe esse veículo cadastrado!');
        }

        if ($validation->errors()->count()) {
            throw new HttpResponseException(response()->json([
                'msg' => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors' => $validation->messages(),
                'url' => $id ? route('vehicle.update', ['vehicle' => $id]) : route('vehicle.store')
            ], 403));
        }
    }
}
