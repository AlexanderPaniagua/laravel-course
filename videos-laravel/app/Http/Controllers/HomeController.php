<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Video;//Utilizando el model

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Utilizando el query builder
        //$video = DB::table('videos')->paginate(5);
        //Utilizando el modelo
        $videos = Video::orderBy('id', 'desc')->paginate(5);
        return view('home', array('videos' => $videos));
    }
}
