<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//Importando las clases necesarias para trabajar con la base de datos
use Illuminate\Support\Facades\DB;//Acceso a los metodos del query builder


class NotesController extends Controller
{
    public function index() {
    	//Conseguir todas las notas
    	$notes = DB::table('notes')->orderBy('id', 'desc')->get();
    	//dd($notas);
    	//foreach ($notes as $note) { echo $note->title . "<br/>"; }
    	//return 'Index notes';
    	return view('notes.index', array("notes" => $notes));
    }

    public function show($id) {
    	//Conseguir nota concreta
    	$note = DB::table('notes')->select('id', 'title', 'description')->where('id', $id)->first();
    	//Se puede utilizar tantos where como se necesiten. orWhere
    	//dd($note);
    	if(empty($note)) {
    		return redirect()->action('NotesController@index');
    	}
    	return view('notes.show', array("note" => $note));
    }

    public function store(Request $request) {
    	$note = DB::table('notes')->insert(array('title' => $request->input('title'), 'description' => $request->input('description')));
    	return redirect()->action('NotesController@index');
    	//
    }

    public function create() {
    	return view('notes.create');
    }

    public function destroy($id) {
    	$note = DB::table('notes')->where('id', $id)->delete();
    	return redirect()->action('NotesController@index')->with('status', 'Nota borrada correctamente.');
    }

    public function update($id, Request $request) {
    	$note = DB::table('notes')->where('id', $id)->update(array('title' => $request->input('title'), 'description' => $request->input('description')));
    	return redirect()->action('NotesController@index')->with('status', 'Nota actualizada correctamente.');
    }

    public function edit($id) {
    	$note = DB::table('notes')->select('id', 'title', 'description')->where('id', $id)->first();
    	//Se puede utilizar tantos where como se necesiten. orWhere
    	//dd($note);
    	if(empty($note)) {
    		return redirect()->action('NotesController@index');
    	}
    	return view('notes.edit', array("note" => $note));
    }

}
