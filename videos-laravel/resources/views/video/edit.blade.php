@extends('layouts.app')

@section('content')
	<div class="container">
		<div class="row">
			<h2>Editar {{ $video->title }}</h2>
			<hr>
			<form action="{{-- url('/save-video') --}} {{ route('updateVideo', ['video_id' => $video->id]) }}" method="POST" enctype="multipart/form-data" class="col-lg-7">
				<!-- proteger formulario de ataques de dominio cruzado con helper de laravel -->
				{!! csrf_field() !!}
				<!-- Mostrar posibles errores -->
				<!-- El idioma de los errores se pueden cambiar en el archivo app.php y reemplazar prefijo de idioma por el deseado. Las cadenas de texto deben estar creadas en resources lang es validation.php etc -->
				@if($errors->any())
					<div class="alert alert-danger">
						<ul>
							@foreach($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif
				<!-- Si la validacion del formulario falla, utilizar helper para recordar el valor anterior -->
				<div class="form-group">
					<label for="title">Titulo</label>
					<input type="text" name="title" id="title" class="form-control" value="{{ $video->title }}" />
				</div>
				<div class="form-group">
					<label for="description">Descripcion</label>
					<textarea name="description" id="description" class="form-control" >{{ $video->description }}</textarea>
				</div>
				<div class="form-group">
					<label for="image">Miniatura</label>
					@if(Storage::disk('images')->has($video->image))
                                <div class="video-image-thumb col-md-3 pull-left">
                                    <div class="video-image-mask">
                                        <img width="300px" height="100px" src="{{ url('/thumb/'.$video->image) }}" class="video-image" />
                                    </div>
                                </div>
                            @endif
					<input type="file" name="image" id="image" class="form-control" />
				</div>
				<div class="form-group">
					<label for="video">Video</label>
					<video controls id="video-player">
						<source src="{{ route('fileVideo', [ 'filename' => $video->video_path ]) }}" type="">
						Tu navegador no es compatible con HTML5
					</video>
					<input type="file" name="video" id="video" class="form-control" />
				</div>
				<button type="submit" class="btn btn-success">Modificar video</button>
			</form>
		</div>
	</div>
@endsection