<?php

namespace App\Http\Controllers;

use App\Http\Requests\DicaRequest;
use App\Http\Resources\Dica\DicaResource;
use App\Http\Resources\Dica\DicaResourceCollection;
use App\Models\Dica;
use App\Services\ResponseService;
use Illuminate\Support\Facades\DB;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class DicaController extends Controller
{

    private $dica;

    public function __construct(Dica $dica)
    {
        $this->dica = $dica;
    }

    /**
     * Display a listing of the resource.
     *
     * @return DicaResourceCollection
     */
    public function index()
    {
        return new DicaResourceCollection($this->dica->index());
    }

    /**
     * Display a listing of search the resource.
     *
     * @return DicaResourceCollection
     */
    public function search(Request $request)
    {
        return new DicaResourceCollection($this->dica->search($request->all()));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse|DicaResource
     */
    public function store(DicaRequest $request)
    {
        try {
            $data = $this->dica->createOrUpdate($request->all());
        }catch (Throwable | Exception $e){
            return ResponseService::exception('tip.store', null, $e);
        }

        return new DicaResource($data, array('type' => 'store', 'route' => 'tip.store'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return JsonResponse|DicaResource
     */
    public function show($id)
    {
        $data = $this->dica->show($id);

        return new DicaResource($data, array('type' => 'show', 'route' => 'tip.show'));
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return JsonResponse|DicaResource
     */
    public function update(DicaRequest $request, $id)
    {
        try {
            $data = $this->dica->createOrUpdate($request->all(),$id);
        }catch (Throwable | Exception $e){
            return ResponseService::exception('tip.update', $id, $e);
        }

        return new DicaResource($data, array('type' => 'update', 'route' => 'tip.update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse|DicaResource
     */
    public function destroy($id)
    {
        try {
            $data = $this->dica->remove($id);
        }catch (Exception $e){
            return ResponseService::exception('tip.destroy', $id, $e);
        }

        return new DicaResource($data, array('type' => 'destroy', 'route' => 'tip.destroy'));
    }
}
