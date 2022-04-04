<?php

namespace App\Http\Resources\Veiculo;

use App\Http\Resources\Tipo\TipoResourceCollection;
use App\Models\Tipo;
use App\Services\ResponseService;
use Illuminate\Http\Resources\Json\JsonResource;

class VeiculoResource extends JsonResource
{
    public function __construct($resource, $config = array())
    {
        // Ensure you call the parent constructor
        parent::__construct($resource);

        $this->config = $config;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'veiculo' => $this->veiculo,
            'tipo_id' => $this->tipo_id,
            'tipo' => $this->tipo->descricao,
            'marca_id' => $this->modelo->marca_id,
            'marca' => $this->modelo->marca->descricao,
            'modelo_id' => $this->modelo_id,
            'modelo' => $this->modelo->descricao,
            'versao_id' => $this->versao_id,
            'versao' => $this->versao ? $this->versao->descricao : null,
            'user_id' => $this->user_id,
            'user' => $this->usuario->name,
        ];
    }

    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request  $request
     * @return array
     */
    public function with($request)
    {
        return ResponseService::default($this->config,$this->id);
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request
     * @param  \Illuminate\Http\Response
     * @return void
     */
    public function withResponse($request, $response)
    {
        $response->setStatusCode(200);
    }
}
