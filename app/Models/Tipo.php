<?php

namespace App\Models;

use App\Models\Utils\SearchUtils;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Tipo extends Model
{
    use HasFactory;

    protected $table = 'tipo';

    public function index()
    {
        return self::selectRaw('id, descricao')
            ->get();
    }

    public function show($id)
    {
        $tipo = self::selectRaw('id, descricao')
            ->where('id', '=', $id)
            ->first();


        if (!$tipo) {
            throw new Exception('Nada Encontrado', -404);
        }

        return $tipo;
    }

    public function remove($id)
    {
        throw new Exception('Não suportado', -403);

    }

    public function search($data)
    {
        $tipo = self::selectRaw('id, descricao');

        $tipo = (SearchUtils::createQuery($data, $tipo))->get();

        return $tipo;
    }

    public function createOrUpdate($fields, $id = null)
    {
        throw new Exception('Não suportado', -403);
    }
}
