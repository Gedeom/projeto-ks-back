<?php

namespace App\Models;

use App\Models\Utils\SearchUtils;
use App\Services\ResponseService;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Throwable;

class Marca extends Model
{
    use HasFactory;

    protected $table = 'marca';

    public function index()
    {
        return self::selectRaw('id, descricao')
            ->orderBy('id')
            ->get();
    }

    public function show($id)
    {
        $marca = self::selectRaw('id, descricao')
            ->where('id', '=', $id)
            ->first();


        if (!$marca) {
            throw new Exception('Nada Encontrado', -404);
        }

        return $marca;
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $marca = Marca::find($id);

            if (!$marca) {
                throw new Exception('Nada Encontrado', -404);
            }

            $marca_temp = $this->show($marca->id);

            $marca->delete();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $marca_temp;
    }

    public function search($data)
    {
        $marca = self::selectRaw('id, descricao');

        $marca = (SearchUtils::createQuery($data, $marca))->get();

        return $marca;
    }

    public function createOrUpdate($fields, $id = null)
    {
        try {
            DB::beginTransaction();

            $fields = (object)$fields;
            $marca = Marca::findOrNew($id);
            $marca->descricao = $fields->descricao;
            $marca->save();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }

        return $this->show($marca->id);
    }

    public static function hasMarca($marca, $id = 0){
        return self::whereDescricao($marca)->where('id','<>',$id)->first();
    }
}
