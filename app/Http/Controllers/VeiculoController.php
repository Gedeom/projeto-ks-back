<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeiculoRequest;
use App\Http\Resources\Veiculo\VeiculoResource;
use App\Http\Resources\Veiculo\VeiculoResourceCollection;
use App\Models\Veiculo;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class VeiculoController extends Controller
{

    private $veiculo;

    public function __construct(Veiculo $veiculo)
    {
        $this->veiculo = $veiculo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return VeiculoResourceCollection
     */
    public function index()
    {
        return new VeiculoResourceCollection($this->veiculo->index());
    }

    /**
     * Display a listing of search the resource.
     *
     * @return VeiculoResourceCollection
     */
    public function search(Request $request)
    {
        return new VeiculoResourceCollection($this->veiculo->search($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|VeiculoResource
     */
    public function store(VeiculoRequest $request)
    {
        try {
            $data = $this->veiculo->createOrUpdate($request->all());
        }catch (Throwable | Exception $e){
            return ResponseService::exception('vehicle.store', null, $e);
        }

        return new VeiculoResource($data, array('type' => 'store', 'route' => 'vehicle.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|VeiculoResource
     */
    public function show($id)
    {
        $data = $this->veiculo->show($id);

        return new VeiculoResource($data, array('type' => 'show', 'route' => 'vehicle.show'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|VeiculoResource
     */
    public function update(VeiculoRequest $request, $id)
    {
        try {
            $data = $this->veiculo->createOrUpdate($request->all(),$id);
        }catch (Throwable | Exception $e){
            return ResponseService::exception('vehicle.update', $id, $e);
        }

        return new VeiculoResource($data, array('type' => 'update', 'route' => 'vehicle.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|VeiculoResource
     */
    public function destroy($id)
    {
        try {
            $data = $this->veiculo->remove($id);
        }catch (Exception $e){
            return ResponseService::exception('vehicle.destroy', $id, $e);
        }

        return new VeiculoResource($data, array('type' => 'destroy', 'route' => 'vehicle.destroy'));
    }
}
