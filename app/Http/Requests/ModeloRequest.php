<?php

namespace App\Http\Requests;

use App\Models\Marca;
use App\Models\Modelo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation;
use Illuminate\Validation\Rule;

class ModeloRequest extends FormRequest
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
            'marca_id' => [
                'required',
                Rule::in(Marca::pluck('id', 'id'))
            ],
            'descricao' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'marca.required' => 'Informe a marca',
            'marca.in' => 'Marca não encontrada',
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
        $id = (int) $this->route('model');
        $validation = $validator;

        if (Modelo::hasModelo($this->descricao, $id)) {
            $validation->errors()->add('descricao', 'Já existe esse modelo cadastrado!');
        }

        if ($validation->errors()->count()) {
            throw new HttpResponseException(response()->json([
                'msg' => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors' => $validation->messages(),
                'url' => $id ? route('model.update', ['model' => $id]) : route('model.store')
            ], 403));
        }
    }
}
