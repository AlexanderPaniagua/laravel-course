//importanto componentes internos de angular para quye funcione
//component obj para definir component y oninit provee interfaz que nos provea un metodo que se ejecut eprimer que todo en el comp
import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { User } from '../../models/user';
import { UserService } from '../../services/user.service';

@Component({
	selector: 'login',
	templateUrl: './login.component.html',
	providers: [ UserService ]
})//no se cierra con ; solo es decorador de la clase definida:

export class LoginComponent implements OnInit {
	public title:string;
	public user:User;
	public token;
	public identity;

	constructor(
		/*private _route: ActivatedRoute,
		private _router: Router*/
		private _userService: UserService,
		private _route: ActivatedRoute,
		private _router: Router
	) {
		this.title = 'Identificate';
		this.user = new User(1, 'ROLE_USER', '', '', '', '');
	}

	ngOnInit() {
		console.log('login.component cargado!');
		//let user = this._userService.getIdentity();
		//(user != null ? console.log(user.name) : null);
		this.logout();
	}

	onSubmit(form) {
		//console.log(this.user);
		var result = { status: 'desconocido', code: 200, message: 'Not procesed', data: null };
		this._userService.signup(this.user, true).subscribe(
			response => {
				console.log(response);
				result = response;
				if(result.status == 'success') {
					//token
					//console.log('token');
					//console.log(response);
					this.token = response.data.jwt;
					localStorage.setItem('token', this.token);
					//Obj usuario identificado
					this._userService.signup(this.user, false).subscribe(
						response => {
							//console.log('obj');
							//console.log(response);
							this.identity = response.data.jwt;
							//console.log(this.identity);
							localStorage.setItem('identity', JSON.stringify(this.identity));
							//convertir obj de js en json string xq localStorage solo guardar string o numeros
							this._router.navigate(['home']);
						},
						error => { console.log(<any>error); }
					);
				}
				else {
					//
				}
			},
			error => {
				console.log(<any>error);
			}
		);
	}

	logout() {
		this._route.params.subscribe(params => {
			let logout = +params['sure'];
			if(logout > 0) {
				localStorage.removeItem('token');
				localStorage.removeItem('identity');
				this.token = this.identity = null;
				//redireccion
				this._router.navigate(['home']);
			}
		});
	}

}