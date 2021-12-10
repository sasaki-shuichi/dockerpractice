@extends('layouts.base2')
@section('title', '検索画面')

@section('button')
<div class="col-20 clearfix">
	<div class="col text-right">
		<a href="{{route('input.new')}}" class="btn btn-primary w-25" tabindex="-1" role="button">新規登録</a>
		<a href="{{route('login.lift')}}" class="btn btn-primary w-25" tabindex="-1" role="button">ログアウト</a>
	</div>
</div>
@endsection

@section('content')
<h5>検索条件</h5>
<hr>
<div th:fragment="search">
	{{Form::open(['method' => 'post', 'id' => 'form', 'class' => 'form-search'])}}
	{{Form::hidden('userId', $model->f_userId, ['id' => 'userId'])}}
	{{Form::hidden('page', $model->f_page, ['id' => 'page'])}}
	<div class="form-group form-inline input-group-sm">
		<label for="name" class="col-md-2 control-label">名前</label>
		{{Form::text('name', $model->f_name, ['class' => 'form-control col-md-3'])}}
	</div>

	<div class="form-group form-inline">
		<label for="prefectures" class="col-md-2 control-label">都道府県</label>
		{{Form::select('prefectures[]', $model->prefectures, $model->f_prefectures, ['class' => 'form-control col-md-3','multiple' => 'multiple','size' => '5'])}}
	</div>

	<div class="form-group form-inline input-group-sm">
		<label for="publisher" class="col-md-2 control-label">性別</label>
		{{Form::checkbox('man', $model->man, $model->f_man, ['class'=>'form-check-input'])}}<span>&nbsp;男</span>
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		{{Form::checkbox('woman', $model->woman, $model->f_woman, ['class'=>'form-check-input'])}}<span>&nbsp;女</span>
	</div>

	<div class="form-group form-inline input-group-sm">
		<label for="price_from" class="col-md-2 control-label">生年月日</label>
		{{Form::date('birthFrom', $model->f_birthFrom, ['class' => 'form-control col-md-3', 'id' => 'birthFrom'])}}
		<label class="col-md-1 control-label">～</label>
		{{Form::date('birthTo', $model->f_birthTo, ['class' => 'form-control col-md-3', 'id' => 'birthTo'])}}
		<div class="col-md-3"></div>
	</div>

	<div class="text-center">
		{{Form::button('検索', ['class' => 'btn btn-outline-primary btn-lg w-25', 'onclick' => '_search()'])}}
	</div>

	{{ Form::close() }}

</div>
<hr>

</br></br>
<h5>検索一覧</h5>
@if(!$model->users->isEmpty())
{{$model->users->links('pagination.custom');}}
@endif
<table class="table table-striped">
	<thead>
		<tr>
			<th scope="col">No</th>
			<th scope="col">ユーザーID</th>
			<th scope="col">名前</th>
			<th scope="col">電話番号</th>
			<th scope="col">住所</th>
			<th scope="col">性別</th>
			<th scope="col">生年月日</th>
		</tr>
	</thead>
	<tbody>
		@foreach ($model->users as $user)
		<tr>
			<th scope="row">{{$loop->iteration}}</th>
			<td>{{Form::button($user->user_id, ['class' => 'btn btn-outline-primary btn-lg', 'tabindex' => '-1', 'role' => 'button', 'onclick' => '_edit(\'' . $user->user_id . '\')'])}}</td>
			<td>{{$user->name}}</td>
			<td>{{$user->tel}}</td>
			<td>{{$user->address}}</td>
			<td>{{$user->element}}</td>
			<td>{{$user->birth}}</td>
		</tr>
		@endforeach
	</tbody>
	{{Log::debug('BRADE...End');}}
</table>
@if(!$model->users->isEmpty())
{{$model->users->links('pagination.custom');}}
@endif
</div>

<script type="text/javascript">
	function _search() {
		$('form').attr('action', "{{route('disp.search')}}");
		$('#form').submit();
	}

	function _page(page) {
		$('input:hidden[name="page"]').val(page);
		$('form').attr('action', "{{route('disp.page')}}");
		$('#form').submit();
	}

	function _edit(userId) {
		$('input:hidden[name="userId"]').val(userId);
		$('form').attr('action', "{{route('disp.edit')}}");
		$('#form').submit();
	}
</script>

@endsection