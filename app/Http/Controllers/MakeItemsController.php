<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MakeItemsController extends Controller
{
    public function index(){
        return view('pos.make-item.make-items');
    }
}
