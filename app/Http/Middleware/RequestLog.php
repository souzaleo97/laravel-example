<?php

namespace App\Http\Middleware;

use App\Repositories\ErrorLogRepository;
use App\Repositories\LogRepository;
use Closure;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RequestLog
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->server->has('X-Forwarded-For')) {
            $clientAddress = $request->server->get('X-Forwarded-For');
        } elseif ($request->server->has('Proxy-Client-IP')) {
            $clientAddress = $request->server->get('Proxy-Client-IP');
        } elseif ($request->server->has('WL-Proxy-Client-IP')) {
            $clientAddress = $request->server->get('WL-Proxy-Client-IP');
        } elseif ($request->server->has('HTTP_CLIENT_IP')) {
            $clientAddress = $request->server->get('HTTP_CLIENT_IP');
        } elseif ($request->server->has('HTTP_X_FORWARDED_FOR')) {
            $clientAddress = $request->server->get('HTTP_X_FORWARDED_FOR');
        } elseif ($request->server->has('REMOTE_ADDR')) {
            $clientAddress = $request->server->get('REMOTE_ADDR');
        } else {
            $clientAddress = '0.0.0.0';
        }

        $data = $request->all();

        if (Arr::has($data, 'password')) {
            $data['password'] = Str::upper(__('messages.hidden_data'));
        }

        $log = new LogRepository();

        $idLog = $log->store([
            'user_logged_id' => Auth::id() ?? null,
            'client_address' => $clientAddress,
            'device_app_version' => $request->header('deviceappversion'),
            'device_name' => $request->header('devicename'),
            'device_os' => $request->header('deviceos'),
            'device_uuid' => $request->header('deviceuuid'),
            'data' => json_encode($data),
            'header_request' => json_encode($request->headers->all()),
            'method_request' => $request->server->get('REQUEST_METHOD'),
            'uri_request' => $request->server->get('REQUEST_URI')
        ]);

        $response = $next($request);

        if ($response->isClientError() || $response->isServerError()) {
            $errorLog = new ErrorLogRepository();
            $errorLog->store([
                'log_id' => $idLog,
                'status_code' => $response->status(),
                'exception' => $response->content()
            ]);
        }

        return $response;
    }
}
