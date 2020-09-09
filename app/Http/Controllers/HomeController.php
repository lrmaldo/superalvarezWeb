<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use App\Role;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* $sucursales = User::with(['roles'=>function($q){
            $q->where('role_id','=','2');
        }])->get(); */
      /*   $sucursales =User::where() */
       /*  $sucursales = User::where('roles.id','=',2)->get(); */
        //$sucursales = User::with('roles')->except('');
     /*    $sucursales = User::all()->roles()->where('name','user')-; */
    $sucursales =  Role::where('name', 'user')->first()->users()->get();
        return view('home',compact('sucursales'));
      /* return $sucursales; */
       
    }
}
