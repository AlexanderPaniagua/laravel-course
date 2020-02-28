//importanto componentes internos de angular para quye funcione
//component obj para definir component y oninit provee interfaz que nos provea un metodo que se ejecut eprimer que todo en el comp
import { Component, OnInit } from '@angular/core';
import { Router, ActivatedRoute, Params } from '@angular/router';
import { User } from '../../models/user';
import { UserService } from '../../services/user.service';

@Component({
	selector: 'default',
	templateUrl: './default.component.html',
	providers: [ UserService ]
})//no se cierra con ; solo es decorador de la clase definida:

export class DefaultComponent implements OnInit {
	public title:string;

	constructor(
		/*private _route: ActivatedRoute,
		private _router: Router*/
		private _route: ActivatedRoute,
		private _router: Router,
		private _userService: UserService
	) {
		this.title = 'Inicio';
	}

	ngOnInit() {
		console.log('default.component cargado!');
	}

}