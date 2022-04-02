<?php

namespace App\Http\Controllers;

use App\Http\Requests\ModeloRequest;
use App\Http\Resources\Modelo\ModeloResource;
use App\Http\Resources\Modelo\ModeloResourceCollection;
use App\Models\Modelo;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class ModeloController extends Controller
{

    private $modelo;

    public function __construct(Modelo $modelo)
    {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return ModeloResourceCollection
     */
    public function index()
    {
        return new ModeloResourceCollection($this->modelo->index());
    }

    /**
     * Display a listing of search the resource.
     *
     * @return ModeloResourceCollection
     */
    public function search(Request $request)
    {
        return new ModeloResourceCollection($this->modelo->search($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|ModeloResource
     */
    public function store(ModeloRequest $request)
    {
        try {
            $data = $this->modelo->createOrUpdate($request->all());
        }catch (Throwable | Exception $e){
            return ResponseService::exception('model.store', null, $e);
        }

        return new ModeloResource($data, array('type' => 'store', 'route' => 'model.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|ModeloResource
     */
    public function show($id)
    {
        $data = $this->modelo->show($id);

        return new ModeloResource($data, array('type' => 'show', 'route' => 'model.show'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|ModeloResource
     */
    public function update(ModeloRequest $request, $id)
    {
        try {
            $data = $this->modelo->createOrUpdate($request->all(),$id);
        }catch (Throwable | Exception $e){
            return ResponseService::exception('model.update', $id, $e);
        }

        return new ModeloResource($data, array('type' => 'update', 'route' => 'model.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|ModeloResource
     */
    public function destroy($id)
    {
        try {
            $data = $this->modelo->remove($id);
        }catch (Exception $e){
            return ResponseService::exception('model.destroy', $id, $e);
        }

        return new ModeloResource($data, array('type' => 'destroy', 'route' => 'model.destroy'));
    }
}
