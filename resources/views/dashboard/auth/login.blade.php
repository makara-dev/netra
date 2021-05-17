<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1" name="viewport" />
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	{{-- CSRF TOKEN --}}
	<meta name="csrf-token" content="{{ csrf_token() }}">

	{{-- title --}}
	<link rel="shortcut icon" href="{{asset('icon/netra-icon.svg')}}" />
	<title>
		Dashboard Login
	</title>

	{{-- font --}}
	<link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro&display=swap" rel="stylesheet">

	<link rel="stylesheet" href="{{ asset('css/dashboard.min.css') }}">
	<style>
		.login-form {
			font-family: 'Source Sans Pro', sans-serif, 'Courier New', Courier, monospace;
			max-width: 500px;
			margin: auto;
		}

		html,
		body {
			height: 100%;
		}

		.form-wrapper {
			width: 100%;
			max-width: 330px;
			padding: 15px;
			margin: auto;
		}
	</style>
</head>

<body class="h-100">
	{{-- wrapper --}}
	<div class="container-fluid dashboard-content h-100 d-flex text-center">
		{{-- Dashboard Content --}}
		<div class="form-wrapper">
			@include('partials.flash-message')
			<form action="{{ url('dashboard/login') }}" method="POST">
				@csrf
				<img src="{{asset('icon/netra.svg')}}" alt="Netra-logo" width="72" height="72" />
				<div class="form-group text-left">
					<label>User Name</label>
					<input name="name" type="text" class="form-control bg-white" placeholder="User Name" required autofocus>
				</div>
				<div class="form-group text-left">
					<label>Password</label>
					<input name="password" type="password" class="form-control bg-white" placeholder="Password" required
						minlength="6">
				</div>
				<div class="checkbox text-right">
					<label>
						<input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
						{{ __('Remember Me') }}
					</label>
				</div>
				<button class="btn btn-lg bg-purple text-white btn-block ml-auto mb-2" type="submit">Sign in</button>
			</form>
		</div>
	</div>
</body>


<script src="{{asset('js/app.js')}}"></script>