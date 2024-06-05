<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SetController extends Controller
{
    public function Setitem(){
        return view('pos.set.set-item-add');
    }
}
