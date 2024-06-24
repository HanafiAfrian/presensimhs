<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
		
		$user = session('user');
			
        return view('home', compact('user'));
    }
	
	 public function homedosen()
    {
		
		$user = session('user');
			
        return view('homedosen', compact('user'));
    }
}
