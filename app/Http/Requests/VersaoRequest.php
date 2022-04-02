<?php

namespace App\Http\Requests;

use App\Models\Marca;
use App\Models\Versao;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation;
use Illuminate\Validation\Rule;

class VersaoRequest extends FormRequest
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
        $id = (int) $this->route('version');
        $validation = $validator;

        if (Versao::hasVersao($this->descricao, $id)) {
            $validation->errors()->add('descricao', 'Já existe essa versão cadastrada!');
        }

        if ($validation->errors()->count()) {
            throw new HttpResponseException(response()->json([
                'msg' => 'Ops! Algum campo obrigatório não foi preenchido.',
                'status' => false,
                'errors' => $validation->messages(),
                'url' => $id ? route('version.update', ['version' => $id]) : route('version.store')
            ], 403));
        }
    }
}
