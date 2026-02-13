<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessServiceController extends Controller
{
    //
    public function index(){
        return view('external.business-service');
    }
    public function payingCards(){
        return view('external.paying-cards');
    }
}
