<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;//Para relectar datos pasados por metodos http
use App\Http\Requests;
use Illuminate\Support\Facades\DB;//Para base de datos
use Illuminate\Support\Facades\Storage;//Subir archivos y almacenarlos
use Symfony\Component\HttpFoundation\Response;//Response para enviar resp
//Netbeans lo rellena automaticamente

use App\Video;
use App\Comment;
use App\User;//entidad de usuario

class UserController extends Controller
{

    public function channel($user_id) {
    	$user = User::find($user_id);
    	if(!is_object($user)) {
    		return redirect()->route('home');
    	}
    	$videos = Video::where('user_id', $user_id)->paginate(5);
    	return view('user.channel', array('user' => $user, 'videos' => $videos));
    }

}
