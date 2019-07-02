@extends('layouts.app');
@section('content')
	<div class="container" style="margin:200px;">
	<p class="text-center">	Reset password success </p> <a data-toggle="modal" data-target="#myModal"  href="{{ route('login') }}" style="color: black; ">{{ __('Login here') }} </a> 

	</div>
@endsection('content')