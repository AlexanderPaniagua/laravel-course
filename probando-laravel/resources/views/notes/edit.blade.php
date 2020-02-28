<h1>Editando nota</h1>

<form action="{{ url('/notas/'.$note->id) }}" method="POST">
	<input type="hidden" name="_method" value="PUT">
	<p>
		<label for="title">Titulo</label>
	</p>
	<p>
		<input type="text" name="title" value="{{ $note->title }}" />
	</p>
	<p>
		<label for="description">Descripcion</label>
	</p>
	<p>
		<textarea name="description">{{ $note->description }}</textarea>
	</p>
	<input type="submit" name="enviar" value="Guardar">
</form>
<a href="{{ url('/notas') }}">Notas</a>