<?php

namespace App\Repositories;

use App\Models\ErrorLog;

class ErrorLogRepository
{
    public function store($data)
    {
        $errorLog = new ErrorLog();
        $errorLog->fill($data);
        $errorLog->save();

        return $errorLog->getKey();
    }
}
