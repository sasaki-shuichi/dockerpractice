@extends('layouts.base1')
@section('title', 'ログイン画面')
@section('button', '')

@section('content')
{{Form::open(['method' => 'post', 'url' => route('login.auth'), 'id' => 'form', 'class' => 'form-signin'])}}
<h5 class="h5 mb-3 font-weight-normal">Login</h5>
<label for="inputEmail" class="sr-only">Email address</label>
{{Form::email('email', $model->f_email, ['class' => 'form-control', 'id' => 'inputEmail', 'placeholder' => 'Email address'])}}
<label for="inputPassword" class="sr-only">Password</label>
{{Form::password('password', ['class' => 'form-control', 'id' => 'inputPassword', 'placeholder' => 'Password'])}}
<button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
{{Form::close()}}
{{
    Log::debug('brade Facade getCounter():' . TestSrv::getCounter())
}}
@endsection