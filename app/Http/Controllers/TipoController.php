<?php

namespace App\Http\Controllers;

use App\Http\Resources\Tipo\TipoResource;
use App\Http\Resources\Tipo\TipoResourceCollection;
use App\Models\Tipo;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class TipoController extends Controller
{

    private $tipo;

    public function __construct(Tipo $tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return TipoResourceCollection
     */
    public function index()
    {
        return new TipoResourceCollection($this->tipo->index());

    }

    /**
     * Display a listing of search the resource.
     *
     * @return TipoResourceCollection
     */
    public function search(Request $request)
    {
        return new TipoResourceCollection($this->tipo->search($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|TipoResource
     */
    public function store(Request $request)
    {
        try {
            $data = $this->tipo->createOrUpdate($request->all());
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('type.store', null, $e);
        }

        return new TipoResource($data, array('type' => 'store', 'route' => 'type.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|TipoResource
     */
    public function show($id)
    {
        try {
            $data = $this->tipo->show($id);
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('type.show', $id, $e);
        }
        return new TipoResource($data, array('type' => 'show', 'route' => 'type.show'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|TipoResource
     */
    public function update(Request $request, $id)
    {
        try {
            $data = $this->tipo->createOrUpdate($request->all(), $id);
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('type.update', null, $e);
        }

        return new TipoResource($data, array('type' => 'store', 'route' => 'type.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|TipoResource
     */
    public function destroy($id)
    {
        try {
            $data = $this->tipo->remove($id);
        } catch (Throwable | Exception $e) {
            return ResponseService::exception('type.destroy', $id, $e);
        }

        return new TipoResource($data, array('type' => 'destroy', 'route' => 'type.destroy'));
    }
}
