<!DOCTYPE html>
<html>
<head>
	<title>Travel.abc</title>
	<link rel="stylesheet"  href="/css/bootstrap.css">
	<script src="/js/jquery-2.2.4.min.js"></script>
	<script src="/js/bootstrap.min.js"></script>
</head>
<body>
	@include('includes.header')
	<div class="container">
	<div class="col-md-12">
		@yield('content')
	</div>
	<div class="col-md-3">
	@section('menu')
	<ul>
		<li> Home </li>
		<li> Services </li>
		<li> Contact Us </li>
	</ul>
	</div>
	<div class="col-md-9">
	@section('main')
	@show
	</div>
	</div>
	@include('includes.footer')
</body>
</html>