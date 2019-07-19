<div>
	<pre>
		Hello you,
		You have an invitation from a friend.
		Information of your friend: email: {{Auth::user()->email}}
		{{Session::get('link')}}
	</pre>
</div>