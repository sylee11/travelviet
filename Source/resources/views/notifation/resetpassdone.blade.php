@extends('layouts.app');
@section('content')
	<div class="container" style="margin-top:200px; margin-bottom: 100px;">
	<p class="text-center">	<h3>Reset password success</h3> </p> <a data-toggle="modal" data-target="#myModal"  href="{{ route('login') }}" style="color: blue; ">{{ __('Login here') }} </a> 

	</div>
@endsection('content')