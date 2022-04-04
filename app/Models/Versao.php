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

class Versao extends Model
{
    use HasFactory;

    protected $table = 'versao';

    public function index()
    {
        return self::selectRaw('id, descricao')
            ->orderBy('id')
            ->get();
    }

    public function show($id, $only_return = false)
    {
        $versao = self::selectRaw('id, descricao')
            ->where('id', '=', $id)
            ->first();


        if (!$versao && !$only_return) {
            throw new Exception('Nada Encontrado', -404);
        }

        return $versao;
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $versao = Versao::find($id);

            if (!$versao) {
                throw new Exception('Nada Encontrado', -404);
            }

            $versao_temp = $this->show($versao->id);

            $versao->delete();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $versao_temp;
    }

    public function search($data)
    {
        $versao = self::selectRaw('id, descricao');

        $versao = (SearchUtils::createQuery($data, $versao))->get();

        return $versao;
    }

    public function createOrUpdate($fields, $id = null)
    {
        try {
            DB::beginTransaction();

            $fields = (object)$fields;
            $versao = Versao::findOrNew($id);
            $versao->descricao = $fields->descricao;
            $versao->save();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }

        return $this->show($versao->id);
    }

    public static function hasVersao($versao, $id = 0)
    {
        return self::whereDescricao($versao)->where('id', '<>', $id)->first();
    }
}
