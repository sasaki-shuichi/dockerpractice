<div class='container'>
	@yield('button')
	@if ($model->isError())
	<div class="alert alert-danger">
		<ul>
			@foreach ($model->errors as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	@if ($model->isInfo())
	<div class="alert alert-info">
		<ul>
			@foreach ($model->infos as $info)
			<li>{{ $info }}</li>
			@endforeach
		</ul>
	</div>
	@endif
	@yield('content')
</div>