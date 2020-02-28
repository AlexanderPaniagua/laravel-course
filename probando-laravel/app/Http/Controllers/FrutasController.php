<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//use App\Http\Request;

class FrutasController extends Controller
{
    //Accion que devuelva una vista
    public function index() {
	//public function getIndex() {
    	return view('frutas.index')->with('frutas', array('naranja', 'pera', 'sandia', 'fresa', 'melon', 'pina'));
    }

    public function naranjas() {
    //public function getNaranjas() {
    	return 'Accion de NARANJAS';
    }

    public function peras() {
    //public function anyPeras() {
    	return 'Accion de PERAS';
    }

    public function recibirFormulario(Request $request) {
        $data = $request;
        //var_dump($request);
        //die();
        //return 'El nombre de la fruta es ' . $data['nombre'];
        return 'El nombre de la fruta es ' . $request->input('nombre');
    }

}
