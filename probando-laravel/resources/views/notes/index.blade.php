<h1>Aplicacion de notas</h1>
<a href="{{ url('/notas/create') }}">Crear nota</a>
@if(session('status'))
	<p>{{ session('status') }}</p>
@endif
<h3>Listado de notas</h3>
<ul>
@foreach($notes as $note)
	<li>
		<ul>
			<li>{{ $note->title }}</li>
			<li><a href="{{ url('/notas/'.$note->id) }}">Ver</a></li>
			<li>
				<form action="{{ url('/notas/'.$note->id) }}" method="POST">
					<input type="hidden" name="_method" value="DELETE">
					<input type="submit" name="enviar" value="Eliminar" />
				</form>
			</li>
			<li><a href="{{ url('/notas/'.$note->id.'/edit') }}">Editar</a></li>
		</ul>
	</li>
@endforeach
</ul>