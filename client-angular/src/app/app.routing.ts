//Configurar todo el sistema de rutas que tendra angular
import { ModuleWithProviders } from '@angular/core';//Modulo para conf rutas
import { Routes, RouterModule } from '@angular/router';

//importar componetns
import { LoginComponent } from './components/login/login.component';
import { RegisterComponent } from './components/register/register.component';
import { DefaultComponent } from './components/default/default.component';

//json por cada ruta
const appRoutes: Routes = [
	{ path: '', component: DefaultComponent },
	{ path: 'home', component: DefaultComponent },
	{ path: 'login', component: LoginComponent },
	{ path: 'registro', component: RegisterComponent },
	{ path: 'logout/:sure', component: LoginComponent },
	{ path: '**', component: DefaultComponent }
];

//permitir luego inyectar servicio o cargar servicio dentro de frameworl
export const appRoutingProviders: any[] = [];
//exportar toda conf de la ruta
export const routing: ModuleWithProviders = RouterModule.forRoot(appRoutes);//De este modo todas las rutas conf en appRoutes se cargan dentro del servicio de ruta y funciona
//Luego este archivo se debe importar en app.module.ts para que todo esto funcione

