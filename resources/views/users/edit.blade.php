@extends('layouts.index')
@section('content')  
    {!! Form::model($user, ['method' => 'PATCH', 'action' => ['UserController@update', $user->id], 'id' => 'user_create_form']) !!}
    @include('users.form')
@endsection