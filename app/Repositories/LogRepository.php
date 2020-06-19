<?php

namespace App\Repositories;

use App\Models\Log;

class LogRepository
{
    public function store($data)
    {
        $log = new Log();
        $log->fill($data);
        $log->save();

        return $log->getKey();
    }
}
