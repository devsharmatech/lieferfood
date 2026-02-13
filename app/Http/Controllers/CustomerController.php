<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    //
    public function index(){
        $users=User::latest()->where('role','user')->get();
        return view('admin.customers.all-customers',compact('users'));
    }
}
