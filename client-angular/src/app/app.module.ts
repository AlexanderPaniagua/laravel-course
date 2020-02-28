import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { FormsModule } from '@angular/forms';
//para que un servicio funcione debemos utilizar una libreria que incluqe angular llamada httpclient o httpmodule los dos sirven pero el mas nuevo es el httpclient
import { HttpClientModule } from '@angular/common/http';
import { routing, appRoutingProviders } from './app.routing';//cargar el routing dentro de los imports

//Componentes. Aqui se importan los componentes. Se dan de alta
import { AppComponent } from './app.component';
import { LoginComponent } from './components/login/login.component';
import { RegisterComponent } from './components/register/register.component';
import { DefaultComponent } from './components/default/default.component';

@NgModule({
  declarations: [
    AppComponent,
    LoginComponent,
    RegisterComponent,
    DefaultComponent
  ],
  imports: [
    BrowserModule,
    routing//Aqui los imports lo que se cargan son los modulos y la varoable routing tiene un modulo asi que se carga ese mod de ruta para que toda esa conf se estableza en la conf del framework y tengamos las rutas conf
    , FormsModule,
    HttpClientModule
  ],
  providers: [
  	//Luego se debe cargar el servicio del as rutas
  	appRoutingProviders//parara que se cargue los serv necesarios para trabajar con la rutas
  ],
  bootstrap: [AppComponent]
})
export class AppModule { }

