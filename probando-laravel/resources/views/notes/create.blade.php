<h1>Crear nota</h1>

<form action="{{ url('/notas') }}" method="POST">
	<input type="text" name="title" placeholder="Titulo de la nota" />
	<textarea name="description" placeholder="Descripcion de la nota"></textarea>
	<input type="submit" name="enviar" value="Guardar" />
</form>

<a href="{{ url('/notas') }}">Notas</a>