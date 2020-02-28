<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Illuminate\Support\Facades\DB;

use App\Helpers\JwtAuth;

class UserController extends Controller
{
    
    public function Register(Request $request) {
    	//echo "Accion registro";
    	//die();//no mostrar vista ni nada
    	$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
    	//Recoger post
    	$json = $request->input('json', null);
    	$params = json_decode($json);
    	$email = !is_null($json) && isset($params->email) ? $params->email : null;
    	$name = !is_null($json) && isset($params->name) ? $params->name : null;
    	$surname = !is_null($json) && isset($params->surname) ? $params->surname : null;
    	$role = 'ROLE_USER';
    	$password = !is_null($json) && isset($params->password) ? $params->password : null;

    	if(!is_null($email) &&         !is_null($name) && !is_null($password)) {
    		//Comprobar usuario duplicado
    		//$userCount = User::where('email', '=', $email)->first();//error al consumir con angular
            $userCount = User::where('email', '=', $email)->count();
    		if($userCount <= 0) {
    			//crear el usuario
	    		$passw = hash('sha256', $password);
	    		$user = new User();
	    		$user->email = $email;
	    		$user->name = $name;
	    		$user->surname = $surname;
	    		$user->role = $role;
	    		$user->password = $passw;

	    		$user->save();

	    		$result['status'] = 'success';
	    		$result['code'] = 200;
	    		$result['message'] = 'Usuario creado.';
    		}
    		else {
    			$result['status'] = 'error';
	    		$result['code'] = 400;
	    		$result['message'] = 'Usuario ya creado.';
    		}
    	}
    	else {
    		//$result = array('status' => 'error', 'code' => 400, 'message' => 'Usuario no creado');
    		$result['status'] = 'error';
    		$result['code'] = 400;
    		$result['message'] = 'Usuario no creado.';
    	}
    	return response()->json($result, 200);
    }

    public function Login(Request $request) {
    	$result = array('status' => 'unknown', 'code' => 200, 'message' => 'Not procesed', 'data' => null);
    	//echo "Accion login";
    	//die();//no mostrar vista ni nada
    	//para esta funcion se utilizara una libreria para trabajar con jwt que es firebase, se agrega en composer.json. Para instalarla abrir consola y directorio del proyecto y ejecutar composer update. Este comando hara actualizar las dependencias que necesiten ser actualizadas dentro del framework e instalar las nuevas dependencias anadidas al composer.json. Se creara un helper servicio que tendra clase con diferentes metodos paara trabajar con jwt para el login, token, codifiacion de token, etc. 
    	$jwtAuth = new JwtAuth();
    	//Recibir POST
    	$json = $request->input('json', null);
    	$params = json_decode($json);

    	$email = !is_null($json) && isset($params->email) ? $params->email : null;
    	$password = !is_null($json) && isset($params->password) ? $params->password : null;
    	$getToken = !is_null($json) && isset($params->getToken) ? $params->getToken : true;
    	//$getToken = !is_null($json) && isset($params->getToken) ? $params->getToken : false;

    	//Cifrar la contrasena
    	$passw = hash('sha256', $password);

    	if(!is_null($email) && !is_null($password) && !$getToken) {
    		//$signUp = $jwtAuth->SignUp($email, $passw);
    		$resSignUp = $jwtAuth->SignUp($email, $passw, $getToken);
    		$result['status'] = $resSignUp['status'];
            $result['code'] = $resSignUp['code'];
            $result['message'] = $resSignUp['message'];
            $result['data'] = $resSignUp['data'];
    	}
    	elseif(!is_null($getToken)) {
    		$resSignUp = $jwtAuth->SignUp($email, $passw, $getToken);
    		$result['status'] = $resSignUp['status'];
            $result['code'] = $resSignUp['code'];
            $result['message'] = $resSignUp['message'];
            $result['data'] = $resSignUp['data'];
    	}
    	else {
    		$result['status'] = 'error';
			$result['code'] = 400;
			$result['message'] = 'Envia tus datos por post';
			$result['data'] = null;
    	}
    	return response()->json($result, 200);
    }

}
