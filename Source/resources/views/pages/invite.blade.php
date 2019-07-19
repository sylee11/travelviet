@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: 100px;margin-bottom: 100px;">
	<form action="{{ route('process') }}" method="post">
		{{ csrf_field() }}
		<input type="email" name="email" />
		<button type="submit">Send invite</button>
	</form>
</div>
@endsection