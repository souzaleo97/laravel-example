<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_logged_id',
        'client_address',
        'device_app_version',
        'device_name',
        'device_os',
        'device_uuid',
        'data',
        'header_request',
        'method_request',
        'uri_request'
    ];
}
