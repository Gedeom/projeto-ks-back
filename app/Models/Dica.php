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

class Dica extends Model
{
    use HasFactory;

    protected $table = 'dica';

    public function index()
    {
        return self::selectRaw('dica.id, descricao, numero, veiculo_id, user_id')
            ->get();
    }

    public function show($id)
    {
        $dica = self::selectRaw('dica.id, descricao, numero, veiculo_id, user_id')
            ->where('dica.id', '=', $id)
            ->first();


        if (!$dica) {
            throw new Exception('Nada Encontrado', -404);
        }

        return $dica;
    }

    public function remove($id)
    {
        try {
            DB::beginTransaction();
            $dica = Dica::find($id);

            if (!$dica) {
                throw new Exception('Nada Encontrado', -404);
            }

            $dica_temp = $this->show($dica->id);

            $dica->delete();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage(), $e->getCode());
        }

        return $dica_temp;
    }

    public function search($data)
    {
        $dica = self::selectRaw('dica.id, descricao, numero, veiculo_id, user_id');

        $dica = (SearchUtils::createQuery($data, $dica))->get();

        return $dica;
    }

    public function createOrUpdate($fields, $id = null)
    {
        try {
            DB::beginTransaction();

            $fields = (object)$fields;
            $dica = Dica::findOrNew($id);
            $dica->user_id = $fields->user_id;
            $dica->veiculo_id = $fields->veiculo_id;
            $dica->descricao = $fields->descricao;
            $dica->numero = $id ? $dica->numero : self::getNextNumero();
            $dica->save();

            DB::commit();
        } catch (Throwable | Exception $e) {
            DB::rollBack();
            throw new Exception($e);
        }

        return $this->show($dica->id);
    }

    //--------------------- Relacionamentos

    public function usuario(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function veiculo(){
        return $this->belongsTo(Veiculo::class,'veiculo_id');
    }

    public static function getNextNumero(){
        $numero = self::selectRaw('coalesce(max(numero),0) + 1 as numero')
            ->first()
            ->numero;

        return $numero;
    }
}
