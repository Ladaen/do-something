<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Landing extends Controller
{
    public function Land()
    {
        $title = '| Feeds';
        return view('landing',compact('title'));
    }
}
