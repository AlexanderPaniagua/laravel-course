import { Component, OnInit, DoCheck } from '@angular/core';
import { UserService } from './services/user.service';

@Component({
  selector: 'app-root',
  templateUrl: './app.component.html',
  styleUrls: ['./app.component.css'],
  providers: [ UserService]
})
export class AppComponent implements OnInit, DoCheck {
  //title = 'client-angular';
  public identity;
  public token;

  constructor(
  	private _userService: UserService
  ) {
  	this.identity = this._userService.getIdentity();
  	this.token = this._userService.getToken();
  }

  ngOnInit() {
  	console.log('app.component cargado');
  }

  ngDoCheck() {
    //cada vez que se produce un cambio a nivel de componente o nivel interno de la app ejecuta este codigo
    //cuando loguea y hay cambio en entidad de componente, se ejcutara esto
    this.identity = this._userService.getIdentity();
    this.token = this._userService.getToken();
  }

}
