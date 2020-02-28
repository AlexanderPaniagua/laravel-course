<?php

namespace App\Helpers;

use Firebase\JWT\JWT;
use Illuminate\Support\Facades\DB;
use App\User;

class JwtAuth {

	/*
	Para qie funcion debemos crear un provider
	en terminal escribir y ejecutar: php artisan make:provider JwtAuthServiceProvider y la creara en carpeta de providers. Modificar metodo register para cargar la clase del servicio, escribir require_once app_path() . '/Helpers/JwtAuth/php'
	Anadirlo a la configuracion en app.php y buscar la parte de ap service providers y agregar el servicio
	Luego buscar los alias de clases en el mismo app.php indicar el nombre y a donde se tiene el helper
	*/

	public $key;

	public function __construct() {
		$this->key = '5177818kK!';
	}

	//Metodo para generar token o un objeto de usuario identificado
	public function SignUp($email, $password, $getToken = false) {
		$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
		$getToken = is_null($getToken) ? false : $getToken;
		$user = User::where(array('email' => $email, 'password' => $password))->first();
		$signUp = is_object($user) ? true : false;
		if($signUp) {
			//Generar token y devolver
			//Dentro de JWT el id de un objeto o registro se utiliza la var o subindice sub, aunque se puede utilizar otro nombre de variable
			//utilizar siempre que se pueda comillas simples por que a nivel de rendimiento son mejo que las comillas dobles
			$currentTime = time();
			$token = array(
				'sub' => $user->id,
				'email' => $user->email,
				'name' => $user->name,
				'surname' => $user->surname,
				'iat' => $currentTime,//tiempo de cracion del token iat timestamp de cuando se ha creado el token
				'exp' => $currentTime+(7*24*60*60)//exp tiempo de expiracion del token 1 semana
			);
			$encodedJWT = JWT::encode($token, $this->key, 'HS256');
			$decodedJWT = JWT::decode($encodedJWT, $this->key, array('HS256'));
			
			$result['status'] = 'success';
			$result['code'] = 200;
			$result['message'] = 'SignUp success';
			$result['data'] = array('jwt' => ($getToken ? $encodedJWT : $decodedJWT));
		}
		else {
			//Error
			//return array('status' => 'error', 'code' => 400, 'message' => 'Login ha fallado.');
			$result['status'] = 'error';
			$result['code'] = 400;
			$result['message'] = 'Login ha fallado';
			$result['data'] = null;
		}
		return $result;
	}

	//Metodo para decodificar ese token para utilizarlo en cualquier parte. Recoger un tken de jwt y verificar si es correcto o incorrecto. el parametro getIdentity si es true devolvera identidad de usuario obj completo del usuario identificado, si es false devolvera si aut es correcta o incorrecta
	public function CheckToken($encodedJWT = null, $getIdentity = false) {
		$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
		$auth = false;
		//$data = array('auth' => false, 'jwt' => null);
		try {
			$decodedJWT = JWT::decode($encodedJWT, $this->key, array('HS256'));
			$auth = isset($decodedJWT) && is_object($decodedJWT) && isset($decodedJWT->sub) ? true : false;
			
			$result['status'] = 'success';
			$result['code'] = 400;
			$result['message'] = 'Token verificado';
			$result['data'] = $getIdentity ? $decodedJWT : $auth;
		}
		catch(\UnexpectedValueException $ex) {
			//$auth = false;
			$result['status'] = 'error';
			$result['code'] = 400;
			$result['message'] = 'UnexpectedValueException generated: ' . $ex->getMessage();
			$result['data'] = null;
		}
		catch(\DomainException $ex) {
			//$auth = false;
			$result['status'] = 'error';
			$result['code'] = 400;
			$result['message'] = 'DomainException generated: ' . $ex->getMessage();
			$result['data'] = null;
		}
		//return $auth;
		return $result;
	}

}