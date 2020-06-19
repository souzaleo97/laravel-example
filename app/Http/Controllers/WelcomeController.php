<?php

namespace App\Http\Controllers;

class WelcomeController extends Controller
{
    /**
     * Start of application.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(
            [
                'application_name' => config('app.name'),
                'message' => 'Unauthenticated'
            ],
            200
        );
    }
}
