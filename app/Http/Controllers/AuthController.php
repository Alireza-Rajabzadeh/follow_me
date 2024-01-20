<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {


        $response = [
            "email"=>"romaine65@example.net",
            "token"=>env('TEST_TOKEN')
        ];

        return apiResponse(true,$response);
        dd($request);
    }
}
