<?php

namespace App\Http\Controllers;

use App\Http\Requests\MarcaRequest;
use App\Http\Resources\Marca\MarcaResource;
use App\Http\Resources\Marca\MarcaResourceCollection;
use App\Models\Marca;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class MarcaController extends Controller
{

    private $marca;

    public function __construct(Marca $marca)
    {
        $this->marca = $marca;
    }

    /**
     * Display a listing of the resource.
     *
     * @return MarcaResourceCollection
     */
    public function index()
    {
        return new MarcaResourceCollection($this->marca->index());
    }

    /**
     * Display a listing of search the resource.
     *
     * @return MarcaResourceCollection
     */
    public function search(Request $request)
    {
        return new MarcaResourceCollection($this->marca->search($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|MarcaResource
     */
    public function store(MarcaRequest $request)
    {
        try {
            $data = $this->marca->createOrUpdate($request->all());
        }catch (Throwable | Exception $e){
            return ResponseService::exception('brand.store', null, $e);
        }

        return new MarcaResource($data, array('type' => 'store', 'route' => 'brand.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|MarcaResource
     */
    public function show($id)
    {
        $data = $this->marca->show($id);

        return new MarcaResource($data, array('type' => 'show', 'route' => 'brand.show'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|MarcaResource
     */
    public function update(MarcaRequest $request, $id)
    {
        try {
            $data = $this->marca->createOrUpdate($request->all(),$id);
        }catch (Throwable | Exception $e){
            return ResponseService::exception('brand.update', $id, $e);
        }

        return new MarcaResource($data, array('type' => 'update', 'route' => 'brand.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|MarcaResource
     */
    public function destroy($id)
    {
        try {
            $data = $this->marca->remove($id);
        }catch (Exception $e){
            return ResponseService::exception('brand.destroy', $id, $e);
        }

        return new MarcaResource($data, array('type' => 'destroy', 'route' => 'brand.destroy'));
    }
}
