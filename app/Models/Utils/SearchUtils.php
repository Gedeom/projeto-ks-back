<?php

namespace App\Models\Utils;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class SearchUtils
{
    /*
     * Exemplo de Escopo:
     {
                "data": {
                    "search":[{
                        "operator": "is",
                        "field": "descricao",
                        "value": "teste"
                    }]
                }
            }
     */

    /**
     * Método Principal da classe
     * Retorna a Query de acordo com os parâmetros de busca
     * @param array $data
     * @param Model $model
     * @return Model
     */
    public static function createQuery($data, $model)
    {
        if (count($data)) {
            $data = json_decode(json_encode($data));
            $searches = $data->data->search ?? [];
            $orders = $data->data->sort ?? [];

            foreach ($searches as $s) {
                if (!self::isValidSearch($s))
                    continue;

                switch ($s->operator) {
                    case 'is':
                    {
                        $model->having($s->field, '=', $s->value);
                        break;
                    }
                    case 'more':
                    {
                        $model->having($s->field, '>', $s->value);
                        break;
                    }
                    case 'less':
                    {
                        $model->having($s->field, '<', $s->value);
                        break;
                    }
                    case 'between':
                    {
                        $model->havingBetween($s->field, $s->value);
                        break;
                    }
                    case 'begins':
                    {
                        $model->having($s->field, 'like', "$s->value%");
                        break;
                    }
                    case 'contains':
                    {
                        $model->having($s->field, 'like', "%$s->value%");
                        break;
                    }
                    case 'ends':
                    {
                        $model->having($s->field, 'like', "%$s->value");
                        break;
                    }
                    default:
                        break;
                }
            }

            if (count($orders)) {
                if (isset($model->orders) && count($model->orders)) {
                    $model->orders = null;
                }

                if (method_exists($model, 'getQuery')) {
                    $model->getQuery()->orders = null;
                }

                foreach ($orders as $r) {
                    if (!self::isValidOrder($s))
                        continue;

                    $model->orderBy($r->field, $r->direction);
                }
            }
        }

        return $model;
    }

    private static function isValidSearch($search)
    {
        $search = (array)$search;

        $validar = Validator::make($search, [
            'field' => 'required',
            'operator' => 'required',
            'value' => 'required',
        ]);

        if ($validar->fails()) {
            return 0;
        }

        return 1;
    }

    private static function isValidOrder($order)
    {
        $order = (array)$order;

        $validar = Validator::make($order, [
            'field' => 'required',
            'direction' => 'required',
        ]);

        if ($validar->fails()) {
            return 0;
        }

        return 1;
    }
}
