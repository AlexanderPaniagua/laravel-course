@extends('layouts.app')
@section('content')
<div class="col-md-10 col-md-offset-2">
	<h2>{{ $video->title }}</h2>
	<hr/>
	<div class="col-md-8">
		<video controls id="video-player">
			<source src="{{ route('fileVideo', [ 'filename' => $video->video_path ]) }}" type="">
			Tu navegador no es compatible con HTML5
		</video>

		<div class="card video-data">
			<div class="card-heading">
				<div class="card-title">
					Subido por <strong><a href="{{ route('channel', [ 'user_id' => $video->user->id ]) }}">{{ $video->user->name.' '.$video->user->surname }}</a></strong> el {{ \FormatTime::LongTimeFilter($video->created_at) }}
				</div>
			</div>
			<div class="card-body">
				{{ $video->description }}
			</div>
		</div>

		@include('video.comments')
		

	</div>
</div>
@endsection