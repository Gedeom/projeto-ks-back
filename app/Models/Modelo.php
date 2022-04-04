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

class Modelo extends Model
{
    use HasFactory;

    protected $table = 'modelo';

    public function index()
    {
        return self::selectRaw('modelo.id, modelo.descricao, marca_id')
            ->join('marca', 'marca.id', '=', 'marca_id')
            ->orderBy('modelo.id')
            ->get();
    }

    public function show($id)
    {
        $modelo = self::selectRaw('modelo.id, modelo.descricao, marca_id, modelo.descricao as modelo')
            ->join('marca', 'marca.id', '=', 'marca_id')
            ->where('modelo.id', '=', $id)
            ->orderBy('modelo.id')
            ->first();


        if (!$modelo) {
            throw new Exception('Nada Encontrado', -404);
        }

        return $modelo;
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $modelo = Modelo::find($id);

            if (!$modelo) {
                throw new Exception('Nada Encontrado', -404);
            }

            $modelo_temp = $this->show($modelo->id);

            $modelo->delete();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $modelo_temp;
    }

    public function search($data)
    {
        $modelo = self::selectRaw('modelo.id, modelo.descricao, marca_id, modelo.descricao as modelo')
            ->join('marca', 'marca.id', '=', 'marca_id')
            ->orderBy('modelo.id');

        $modelo = (SearchUtils::createQuery($data, $modelo))->get();

        return $modelo;
    }

    public function createOrUpdate($fields, $id = null)
    {
        try {
            DB::beginTransaction();

            $fields = (object)$fields;
            $modelo = Modelo::findOrNew($id);
            $modelo->marca_id = $fields->marca_id;
            $modelo->descricao = $fields->descricao;
            $modelo->save();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }

        return $this->show($modelo->id);
    }

    public static function hasModelo($modelo, $id = 0)
    {
        return self::whereDescricao($modelo)->where('id', '<>', $id)->first();
    }


    //----------------- Relacionamentos
    public function marca(){
        return $this->belongsTo(Marca::class,'marca_id');
    }
}
