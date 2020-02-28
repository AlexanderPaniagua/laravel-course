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

class VideoController extends Controller
{

    public function createVideo() {
    	return view('video.create');
    }

    public function saveVideo(Request $request) {
    	//La carpeta STORAGE de laravel es privada, no es publica. Se debera implementar un metodo para mostrarlo de manera publica
    	
    	//Validando formulario, buscar la documentacion de laravel, validation rules
    	$validateData = $this->validate($request, array('title' => 'required|min:5', 'description' => 'required', 'video' => 'mimes:mp4'));

    	//Guardar datos en base de datos con el ORM de laravel
    	$video = new Video();
    	$user = \Auth::user();
    	$video->user_id = $user->id;
    	$video->title = $request->input('title');
    	$video->description = $request->input('description');

    	//subida de miniatura
    	$image = $request->file('image');
    	if($image) {
    		$image_path = time().$image->getClientOriginalName();
    		//Los espacios donde se guardan los ficheros son discos. Ir a conf de laravel, filesystems.php buscar directiva disk y agregar los que se deseen. En este caso se creara el disco images
    		\Storage::disk('images')->put($image_path, \File::get($image));
    		$video->image = $image_path;
    	}

    	//subida de video
    	$video_file = $request->file('video');
    	if($video_file) {
    		$video_path = time().$video_file->getClientOriginalName();
    		//Los espacios donde se guardan los ficheros son discos. Ir a conf de laravel, filesystems.php buscar directiva disk y agregar los que se deseen. En este caso se creara el disco images
    		\Storage::disk('videos')->put($video_path, \File::get($video_file));
    		$video->video_path = $video_path;
    	}

    	$video->save();
    	return redirect()->route('home')->with(array('message' => 'El video se ha subido correctamente.'));
    }

    public function getImage($fileName) {
    	$file = Storage::disk('images')->get($fileName);
    	return new Response($file, 200);
    }

    public function getVideoDetail($video_id) {
        $video = Video::find($video_id);
        return view('video.detail', array('video' => $video));
    }

    public function getVideo($fileName) {
        $file = Storage::disk('videos')->get($fileName);
        return new Response($file, 200);
    }

    public function delete($video_id) {
        $user = \Auth::user();
        $video = Video::find($video_id);
        $comments = Comment::where('video_id', $video_id)->get();
        if($user && ($video->user_id == $user->id)) {
            //Solo usuario dueno de video
            if($comments && count($comments) > 0) {
                //$comments->delete();
                foreach ($comments as $comment) {
                    $comment->delete();
                }
            }
            Storage::disk('images')->delete($video->image);
            Storage::disk('videos')->delete($video->video_path);
            $video->delete();
        }
        return redirect()->route('home')->with(array('message' => 'Video eliminado correctamente.'));
    }

    public function edit($video_id) {
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        if($user && ($video->user_id == $user->id)) {
            return view('video.edit', array('video' => $video));
        }
        else {
            return redirect()->route('home');
        }
    }

    public function update($video_id, Request $request) {
        $validateData = $this->validate($request, array('title' => 'required|min:5', 'description' => 'required', 'video' => 'mimes:mp4'));
        $user = \Auth::user();
        $video = Video::findOrFail($video_id);
        $video->user_id = $user->id;
        $video->title = $request->input('title');
        $video->description = $request->input('description');

        //subida de miniatura
        $image = $request->file('image');
        if($image) {
            $image_path = time().$image->getClientOriginalName();
            //Los espacios donde se guardan los ficheros son discos. Ir a conf de laravel, filesystems.php buscar directiva disk y agregar los que se deseen. En este caso se creara el disco images
            \Storage::disk('images')->put($image_path, \File::get($image));
            $video->image = $image_path;
        }

        //subida de video
        $video_file = $request->file('video');
        if($video_file) {
            $video_path = time().$video_file->getClientOriginalName();
            //Los espacios donde se guardan los ficheros son discos. Ir a conf de laravel, filesystems.php buscar directiva disk y agregar los que se deseen. En este caso se creara el disco images
            \Storage::disk('videos')->put($video_path, \File::get($video_file));
            $video->video_path = $video_path;
        }

        $video->update();
        return redirect()->route('home')->with(array('message' => 'El video se ha actualizado correctamente.'));

    }

    public function search($search = null, $filter = null) {
        //$search = is_null($search) ? \Request::get('search') : $search;
        if(is_null($search)) {
            $search = \Request::get('search');
            if(is_null($search)) {
                return redirect()->route('home');
            }
            return redirect()->route('videoSearch', array('search' => $search));
        }

        if(is_null($filter) && \Request::get('filter') && !is_null($search)) {
            $filter = \Request::get('filter');
            return redirect()->route('videoSearch', array('search' => $search, 'filter' => $filter));
        }

        $column = 'id';
        $order = 'DESC';

        if(!is_null($filter)) {
            if($filter == 'new') {
                //$videos->orderBy('id', 'DESC');
                $column = 'id';
                $order = 'DESC';
            }
            elseif($filter == 'old') {
                //$videos->orderBy('id', 'ASC');
                $column = 'id';
                $order = 'ASC';
            }
            elseif($filter == 'alfa') {
                //$videos->orderBy('title', 'ASC');
                $column = 'title';
                $order = 'ASC';
            }
            else {
                //$videos->orderBy('id', 'DESC');
                $column = 'id';
                $order = 'DESC';
            }
        }

        $videos = Video::where('title', 'LIKE', '%'.$search.'%')->orderBy($column, $order)->paginate(5);
        
        return view('video.search', ['videos' => $videos, 'search' => $search]);
    }

}
