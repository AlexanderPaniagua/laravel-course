@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="container">
        	<div class="col-md-2">
	            <h2>Busqueda: {{ $search }}</h2>
	        </div>

            <div class="col-md-8">
	            <form class="col-md-4 pull-right" action="{{ url('/buscar/'.$search) }}" method="GET">
	            	<label for="filter">Ordenar</label>
	            	<select name="filter" class="form-control">
	            		<option value="new">Mas nuevos primero</option>
	            		<option value="old">Mas antiguos primero</option>
	            		<option value="alfa">De la A a la Z</option>
	            	</select>
	            	<input type="submit" name="" value="Ordenar" class="btn btn-sm btn-primary" />
	            </form>
	        </div>
            
            <div class="clearfix"></div>
            @include('video.videosList')

        </div>
    </div>
</div>
@endsection
 