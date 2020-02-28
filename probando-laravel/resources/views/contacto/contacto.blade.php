{{-- COMENTARIO HTML --}}

@include('contacto.cabecera', array('nombre' => $nombre))

<h1>Formulario de contacto {{$nombre}} {{ isset($edad) && !is_null($edad) ? $edad : 'No existe edad' }}</h1>
<h2>Escapando el nombre {!!$nombre!!}</h2>
<p></p>
@if(!is_null($edad))
	Si existe edad {{$edad}}
@else
	No existe edad
@endif
<p></p>
@for($i = 0; $i <= 10; $i++)
	{{$i . ' x 2 = ' . ($i*2) . ''}} <br/>
@endfor

@include('contacto.cabecera', array('nombre' => $nombre))

<p></p>
{{-- Utilizar PHP para definir variables --}}
<?php $i = 1; ?>
@while($i <= 7)
	{{ 'Hola mundo ' . $i }}<br/>
	<?php $i++; ?>
@endwhile

<h1>Listado de frutas</h1>
@foreach($frutas as $fruta)
	<p>{{ $fruta }}</p>
@endforeach

