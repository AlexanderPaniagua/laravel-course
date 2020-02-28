<?php

namespace App\Http\Middleware;

use Closure;

class EsAdmin
{
    //se ejecuta antes o despues de ejecutar una accion de nuestro controlador, cuando llamamos ruta o pgina y esa ruta tiene asignado algun middleware, se ejecuta el middleware primero y hace filtro o coprobacion pra dejar pasar a pagina o accion de controlador, se puede colocar despues de la accion de un controlador tambien.
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(is_null($request->route('admin'))) {
            //modos de redireccion
            //return redirect('fruteria/peras');
            //return back();//Nos lleva a la ruta anterior
            return redirect()->action('FrutasController@peras', [ 'parametrosPorArray' => 'xdd' ])->withInput();//Se puede mandar parametros y datos al metodo peras.
        }
        return $next($request);
    }
}
