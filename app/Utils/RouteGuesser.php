<?php

namespace App\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class RouteGuesser
{
    public function fromUrl(string $url): \Illuminate\Routing\Route
    {
        $request = Request::create($url, 'GET');

        return Route::getRoutes()->match($request);
    }
}
