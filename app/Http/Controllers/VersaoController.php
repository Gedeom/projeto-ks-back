<?php

namespace App\Http\Controllers;

use App\Http\Requests\VersaoRequest;
use App\Http\Resources\Versao\VersaoResource;
use App\Http\Resources\Versao\VersaoResourceCollection;
use App\Models\Versao;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class VersaoController extends Controller
{

    private $versao;

    public function __construct(Versao $versao)
    {
        $this->versao = $versao;
    }

    /**
     * Display a listing of the resource.
     *
     * @return VersaoResourceCollection
     */
    public function index()
    {
        return new VersaoResourceCollection($this->versao->index());
    }

    /**
     * Display a listing of search the resource.
     *
     * @return VersaoResourceCollection
     */
    public function search(Request $request)
    {
        return new VersaoResourceCollection($this->versao->search($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|VersaoResource
     */
    public function store(VersaoRequest $request)
    {
        try {
            $data = $this->versao->createOrUpdate($request->all());
        }catch (Throwable | Exception $e){
            return ResponseService::exception('version.store', null, $e);
        }

        return new VersaoResource($data, array('type' => 'store', 'route' => 'version.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|VersaoResource
     */
    public function show($id)
    {
        $data = $this->versao->show($id);

        return new VersaoResource($data, array('type' => 'show', 'route' => 'version.show'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|VersaoResource
     */
    public function update(VersaoRequest $request, $id)
    {
        try {
            $data = $this->versao->createOrUpdate($request->all(),$id);
        }catch (Throwable | Exception $e){
            return ResponseService::exception('version.update', $id, $e);
        }

        return new VersaoResource($data, array('type' => 'update', 'route' => 'version.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|VersaoResource
     */
    public function destroy($id)
    {
        try {
            $data = $this->versao->remove($id);
        }catch (Exception $e){
            return ResponseService::exception('version.destroy', $id, $e);
        }

        return new VersaoResource($data, array('type' => 'destroy', 'route' => 'version.destroy'));
    }
}
