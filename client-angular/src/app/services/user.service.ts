//importar modulos y librerias necesarias para poder trabajar con servicios
import { Injectable } from '@angular/core';//permite inyectar esta clase en los dif construct de dif conmponentes
import { HttpClient, HttpHeaders } from '@angular/common/http';//Permitir peticiones ajax al server y conf cabecera
import { Observable } from 'rxjs/Observable';//para recoger la repsuesta del servicio read del backend
import { GLOBAL } from './global';//
import { User } from '../models/user';

//utilizar dentro de conmp sin neceisdad de hacer new userservice sino que inyectando la clase en una propiedad
@Injectable()
export class UserService {
	public url:string;
	public identity;
	public token;

	constructor(
		public _http: HttpClient//con guion bajo para diferenciar que es un servicio
	) {
		this.url = GLOBAL.url;
	}

	pruebas() {
		return 'Hola mundo';
	}

	register(user): Observable<any> {
		let json = JSON.stringify(user);
		let params = 'json='+json;
		let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
		return this._http.post(this.url+'register', params, { headers: headers });
	}

	signup(user, getToken = false): Observable<any> {
		user.getToken = getToken ? true : false;
		let json = JSON.stringify(user);
		let params = 'json='+json;
		let headers = new HttpHeaders().set('Content-Type', 'application/x-www-form-urlencoded');
		return this._http.post(this.url+'login', params, { headers: headers });
	}

	getIdentity() {
		let identity = JSON.parse(localStorage.getItem('identity'));
		this.identity = identity != 'undefined' ? identity : null;
		return this.identity;
	}

	getToken() {
		//let token = JSON.parse(localStorage.getItem('token'));
		let token = localStorage.getItem('token');
		this.token = token != 'undefined' ? token : null;
		return this.token;
	}

}





