<?php

namespace App\Repositories;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class BaseRepository
{
    private const ITEMS_PER_PAGE = 15;

    public function paginate($query, Collection $params)
    {
        if ($params->has('page')) {
            $result = $query
                ->paginate(self::ITEMS_PER_PAGE)
                ->appends($params->toArray());

            $resultArray = $result->toArray();

            if (Arr::get($resultArray, 'total') == 0) {
                return [];
            }
        } else {
            $result = $query->get();

            if (is_null($result)) {
                return [];
            }

            $resultArray = $result->toArray();
        }

        return $resultArray;
    }
}
