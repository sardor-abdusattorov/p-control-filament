<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\MainHero;
use App\Models\Material;
use App\Models\PageSettings;
use App\Models\TextBlock;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }
}

