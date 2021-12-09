@extends('layouts.base2')
@section('title', '入力画面')

@section('button')
<div class="col-20 clearfix">
	<div class="col text-right">
		<a href="{{route('input.back')}}" class="btn btn-primary w-25" tabindex="-1" role="button">戻る</a>
		<a href="{{route('login.lift')}}" class="btn btn-primary w-25" tabindex="-1" role="button">ログアウト</a>
	</div>
</div>
@endsection

@section('content')

{{Form::open(['method' => 'post', 'id' => 'form'])}}
{{Form::hidden('userId', $model->f_userId)}}

<!--氏名-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="name">氏名</label>
		{{Form::text('name', $model->f_name, ['class' => 'form-control', 'placeholder' => '山田太郎'])}}
	</div>
</div>
<!--/氏名-->

<!--Eメール-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="email">Eメール</label>
		{{Form::email('email', $model->f_email, ['class' => 'form-control', 'placeholder' => 'xxx@xxx.co.jp'])}}
	</div>
</div>
<!--/Eメール-->

<!--パスワード-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="password">パスワード</label>
		{{Form::password('password', ['class' => 'form-control'])}}
	</div>
</div>
<!--/パスワード-->

<!--住所-->
<div class="form-row mb-3">
	<div class="col-md-6">
		<label for="address">住所</label>
		{{Form::text('address', $model->f_address, ['class' => 'form-control', 'placeholder' => '9990000 東京都XX市XX町1-1-1', 'maxlength' => '100'])}}
	</div>
</div>
<!--住所-->

<!--電話番号-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="tel">電話番号</label>
		{{Form::text('tel', $model->f_tel, ['class' => 'form-control', 'placeholder' => '0220000000'])}}
	</div>
</div>
<!--電話番号-->

<!--ユーザー名-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="userName">ユーザー名</label>
		{{Form::text('userName', $model->f_userName, ['class' => 'form-control', 'placeholder' => 'Sasaki Syuichi'])}}
	</div>
</div>
<!--ユーザー名-->

<!--国名-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="country">国名</label>
		{{Form::select('country', $model->countries, $model->f_country, ['class' => 'form-control'])}}
	</div>
</div>
<!--国名-->

<!--会社名-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="company">会社名</label>
		{{Form::text('company', $model->f_company, ['class' => 'form-control', 'placeholder' => '株式会社 あいうえお'])}}
	</div>
</div>
<!--会社名-->

<!--性別-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="element">性別</label>
		</br>
		<div class="form-check-inline">
			<div class="radio-inline">
				{{Form::radio('element', $model->man, $model->f_element === $model->man)}}
				<label for="man">男性</label>
			</div>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			<div class="radio-inline">
				{{Form::radio('element', $model->woman, $model->f_element === $model->woman)}}
				<label for="woman">女性</label>
			</div>
		</div>
	</div>
</div>
<!--性別-->

<!--生年月日-->
<div class="form-row mb-3">
	<div class="col-md-3">
		<label for="birth">生年月日</label>
		{{Form::date('birth', $model->f_birth, ['class' => 'form-control'])}}
	</div>
</div>
<!--生年月日-->

<!--コメント-->
<div class="form-row mb-3">
	<div class="col-md-6">
		<label for="comment">コメント</label>
		{{Form::textarea('comment', $model->f_comment, ['class' => 'form-control', 'placeholder' => '入力してください', 'rows' => '5'])}}
	</div>
</div>
<!--コメント-->

<br><br>
<div class="text-center">
	{{Form::button('登録', ['class' => 'btn btn-outline-primary btn-lg w-25', 'onclick' => '_regist()'])}}
	{{Form::button('削除', ['class' => 'btn btn-outline-primary btn-lg w-25', 'onclick' => '_delete()'])}}
</div>
{{ Form::close() }}
</div>

<script type="text/javascript">
	function _delete() {
		$('form').attr('action', "{{route('input.delete')}}");
		$('#form').submit();
	}

	function _regist(userId) {
		$('form').attr('action', "{{route('input.regist')}}");
		$('#form').submit();
	}
</script>

@endsection