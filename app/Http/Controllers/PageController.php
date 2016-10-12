<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;

class PageController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
