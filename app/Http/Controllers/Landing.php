<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Landing extends Controller
{
    public function Land()
    {
        $title = '| Welcome';
        return view('landing',compact('title'));
    }
}
