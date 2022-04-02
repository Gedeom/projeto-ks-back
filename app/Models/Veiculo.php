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

class Veiculo extends Model
{
    use HasFactory;

    protected $table = 'veiculo';

    public function index()
    {
        return self::selectRaw('veiculo.id, user_id, tipo_id, modelo_id, versao_id')
            ->get();
    }

    public function show($id)
    {
        $veiculo = self::selectRaw('veiculo.id, user_id, tipo_id, modelo_id, versao_id')
            ->where('veiculo.id', '=', $id)
            ->first();


        if (!$veiculo) {
            throw new Exception('Nada Encontrado', -404);
        }

        return $veiculo;
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $veiculo = Veiculo::find($id);

            if (!$veiculo) {
                throw new Exception('Nada Encontrado', -404);
            }

            $veiculo_temp = $this->show($veiculo->id);

            $veiculo->delete();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $veiculo_temp;
    }

    public function search($data)
    {
        $veiculo = self::selectRawselectRaw('veiculo.id, user_id, tipo_id, modelo_id, versao_id');

        $veiculo = (SearchUtils::createQuery($data, $veiculo))->get();

        return $veiculo;
    }

    public function createOrUpdate($fields, $id = null)
    {
        try {
            DB::beginTransaction();

            $fields = (object)$fields;
            $veiculo = Veiculo::findOrNew($id);
            $veiculo->user_id = $fields->user_id;
            $veiculo->tipo_id = $fields->tipo_id;
            $veiculo->modelo_id = $fields->modelo_id;
            $veiculo->versao_id = $fields->versao_id ?: null;
            $veiculo->save();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }

        return $this->show($veiculo->id);
    }

    public static function hasVeiculo($tipo, $modelo, $versao = 0, $id = 0)
    {
        $versao = (int)$versao;

        return self::whereTipoId($tipo)->whereModeloId($modelo)->whereRaw("coalesce(versao_id, 0) = {$versao}")
            ->where('id', '<>', $id)
            ->first();
    }

    //--------------------- Relacionamentos

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function tipo(){
        return $this->belongsTo(Tipo::class,'tipo_id');
    }

    public function modelo(){
        return $this->belongsTo(Modelo::class,'modelo_id');
    }

    public function versao(){
        return $this->belongsTo(Versao::class,'versao_id');
    }
}
