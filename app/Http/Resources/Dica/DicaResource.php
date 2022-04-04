<?php

namespace App\Http\Resources\Dica;

use App\Http\Resources\Tipo\TipoResourceCollection;
use App\Models\Tipo;
use App\Services\ResponseService;
use Illuminate\Http\Resources\Json\JsonResource;

class DicaResource extends JsonResource
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
            'descricao' => $this->descricao,
            'numero' => $this->numero,
            'tipo' => $this->veiculo->tipo->descricao,
            'tipo_id' => $this->veiculo->tipo_id,
            'veiculo_id' => $this->veiculo_id,
            'marca_id' => $this->veiculo->modelo->marca_id,
            'marca' => $this->veiculo->modelo->marca->descricao,
            'modelo_id' => $this->veiculo->modelo_id,
            'modelo' => $this->veiculo->modelo->descricao,
            'versao_id' => $this->veiculo->versao_id,
            'versao' => $this->veiculo->versao->descricao ?? null,
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
