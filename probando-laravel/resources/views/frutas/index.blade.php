<h1>Listado de frutas</h1>

<a href="{{-- action('FrutasController@naranjas') --}} {{ route('naranjitas') }}">Ir a Naranjas</a>
<br/>
<a href="{{ action('FrutasController@peras') }}">Ir a Peras</a>

<ul>
@foreach($frutas as $fruta)
	<li>{{ $fruta }}</li>
@endforeach
</ul>

<h1>Formulario en Laravel</h1>
<form action="{{ url('recibir') }}" method="POST">
	<p>
		<label for="nombre">Nombre de la fruta:</label>
		<input type="text" name="nombre" />
	</p>
	<p>
		<label for="descripcion">Nombre de la fruta:</label>
		<textarea name="descripcion"></textarea>
	</p>
	<input type="submit" value="Enviar" />
</form>