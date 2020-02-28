<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\DB;//Para base de datos
use Symfony\Component\HttpFoundation\Response;//Response para enviar resp

use App\Helpers\JwtAuth;

use App\Car;

class CarController extends Controller
{

	public function index(Request $request) {
		//echo "Index de CarController";
		//die();
		$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
		$hash = $request->header('Authorization', null);
		$jwtAuth = new JwtAuth();
		$resCheckToken = $jwtAuth->CheckToken($hash, false);
		if($resCheckToken['status'] == 'success') {
			if($resCheckToken['data']) {
				//echo "Autenticado";
				$cars = Car::all()->load('user');
				$result['status'] = 'success';
				$result['code'] = 200;
				$result['message'] = 'ok';
				$result['data'] = array('cars' => $cars);
			}
			else {
				echo "No autenticado";
			}
		}
		else {
			echo $resCheckToken['message'];
		}
		return response()->json($result, 200);
	}

	public function store(Request $request) {
		$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
		try {
			$hash = $request->header('Authorization', null);
			$jwtAuth = new JwtAuth();
			$resCheckToken = $jwtAuth->CheckToken($hash, false);
			if($resCheckToken['status'] == 'success') {
				if($resCheckToken['data']) {
					//Obtener datos post
					$json = $request->input('json', null);
					$params = json_decode($json);
					$params_array = json_decode($json, true);

					//validacion
					////$request->merge($params_array);
					//$validate = $this->validate($request, array('title' => 'required|min:5','description' => 'required','price' => 'required','status' => 'required'));
					/*Validacion de form laravel comun y corriente, pero se mejorara esta validacion al usar apis, se comenta el validate y el request->merge*/
					//$validate = $request->validate(['title' => 'required|min:5','description' => 'required','price' => 'required','status' => 'required']);
					$validate = \Validator::make($params_array, ['title' => 'required|min:5','description' => 'required','price' => 'required','status' => 'required']);

					if(!$validate->fails()) {
						$resCheckToken2 = $jwtAuth->CheckToken($hash, true);
						$user = $resCheckToken2['status'] == 'success' ? $resCheckToken2['data'] : null;
						//guardar coche
						$car = new Car();
						$car->user_id = $user->sub;
						$car->title = $params->title;
						$car->description = $params->description;
						$car->price = $params->price;
						$car->status = $params->status;
						$car->save();
						$result['status'] = 'success';
						$result['code'] = 200;
						$result['message'] = 'ok';
						$result['data'] = null;
					}
					else {
						$result['status'] = 'error';
						$result['code'] = 400;
						$result['message'] = json_encode($validate->errors());
						$result['data'] = null;
					}


					//$errors = $validate->errors();
					//if(!$errors) {
					//	//conseguir usuario identificado
					//	$resCheckToken2 = $jwtAuth->CheckToken($hash, true);
					//	$user = $resCheckToken2['status'] == 'success' ? $resCheckToken2['data'] : null;
					//	//guardar coche
					//	$car = new Car();
					//	$car->user_id = $user->sub;
					//	$car->title = $params->title;
					//	$car->description = $params->description;
					//	$car->price = $params->price;
					//	$car->status = $params->status;
					//	$car->save;
					//	$result['status'] = 'success';
					//	$result['code'] = 200;
					//	$result['message'] = 'ok';
					//	$result['data'] = null;
					//}
					//else {
					//	$result['status'] = 'error';
					//	$result['code'] = 400;
					//	$result['message'] = 'Validation error';
					//	$result['data'] = $errors->toJson();
					//}
				}
				else {
					//devolver error
					$result['status'] = $resCheckToken['status'];
					$result['code'] = $resCheckToken['code'];
					$result['message'] = $resCheckToken['message'];
					$result['data'] = $resCheckToken['data'];
				}
			}
			else {
				//error no controlado
				$result['status'] = $resCheckToken['status'];
				$result['code'] = $resCheckToken['code'];
				$result['message'] = $resCheckToken['message'];
				$result['data'] = $resCheckToken['data'];
			}
		}
		catch(\Illuminate\Validation\ValidationException $ex) {
			//https://laravel.com/api/5.8/Illuminate/Validation/ValidationException.html
			$errors = $ex->errors();
			//$errorsList = '';
			$errorsList = json_encode($errors);
			/*if($errors->any()) {
				foreach($errors->all() as $error) {
					$errorsList .= $error . ',';
				}
			}*/
			$result['status'] = 'error';
			$result['code'] = 400;
			$result['message'] = 'ValidationException: ' . $ex->getMessage() . ': ' . $errorsList;
			$result['data'] = null;
		}
		catch(Exception $ex) {
			$result['status'] = 'error';
			$result['code'] = 400;
			$result['message'] = 'Exception: ' . $ex->getMessage();
			$result['data'] = null;
		}
		return response()->json($result, 200);
	}

	public function show($id) {
		$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
		$car = Car::find($id)->load('user');/*Para que cargue los datos de usuario que ha creado el coche, esto lo debemos hacer al crear una API por que la parte de cargar esa proopiedad en un proyecto monolitico de laravel la hace automaticamente la vista de blade entonces no se hace el load. Como no tenemos vista y no reccorrmos nada mediante laravel simplemente devolvemos json, debemos hacer load para cargar los datos del usuario del registro*/
		$result['status'] = 'success';
		$result['code'] = 200;
		$result['message'] = 'ok';
		$result['data'] = array('car' => $car);
		return response()->json($result, 200);
	}

	public function update($id, Request $request) {
		$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
		$hash = $request->header('Authorization', null);
		$jwtAuth = new JwtAuth();
		$resCheckToken = $jwtAuth->CheckToken($hash, false);
		if($resCheckToken['status'] == 'success') {
			if($resCheckToken['data']) {
				//echo "Autenticado";
				//$cars = Car::all()->load('user');
				//Recoger parametros post
				$json = $request->input('json', null);
				$params = json_decode($json);
				$params_array = json_decode($json, true);
				//Validar datos
				$validate = \Validator::make($params_array, ['title' => 'required|min:5','description' => 'required','price' => 'required','status' => 'required']);

				if(!$validate->fails()) {
					//$resCheckToken2 = $jwtAuth->CheckToken($hash, true);
					//$user = $resCheckToken2['status'] == 'success' ? $resCheckToken2['data'] : null;
					//Actualizar registro
					$car = Car::where('id', $id)->update($params_array);
					$result['status'] = 'success';
					$result['code'] = 200;
					$result['message'] = 'ok';
					$result['data'] = array('car' => $params);
				}
				else {
					$result['status'] = 'error';
					$result['code'] = 400;
					$result['message'] = json_encode($validate->errors());
					$result['data'] = null;
				}
			}
			else {
				$result['status'] = 'error';
				$result['code'] = 400;
				$result['message'] = 'No autorizado.';
				$result['data'] = null;
			}
		}
		else {
			$result['status'] = 'error';
			$result['code'] = 400;
			$result['message'] = $resCheckToken['message'];
			$result['data'] = null;
		}
		return response()->json($result, 200);
	}

	public function destroy($id, Request $request) {
		$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
		$hash = $request->header('Authorization', null);
		$jwtAuth = new JwtAuth();
		$resCheckToken = $jwtAuth->CheckToken($hash, false);
		if($resCheckToken['status'] == 'success') {
			if($resCheckToken['data']) {
				//echo "Autenticado";
				//Comprobar que existe registro
				$car = Car::find($id);
				//Borrarlo
				$car->delete();
				//Devolverlo
				$result['status'] = 'success';
				$result['code'] = 200;
				$result['message'] = 'Registro eliminado.';
				$result['data'] = array('car' => $car);
			}
			else {
				$result['status'] = 'error';
				$result['code'] = 400;
				$result['message'] = 'No autorizado.';
				$result['data'] = null;
			}
		}
		else {
			$result['status'] = 'error';
			$result['code'] = 400;
			$result['message'] = $resCheckToken['message'];
			$result['data'] = null;
		}
		return response()->json($result, 200);
	}

}
