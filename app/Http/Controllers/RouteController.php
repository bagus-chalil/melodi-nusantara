<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function redirect()
    {
        return redirect()->route('login');
    }
}
