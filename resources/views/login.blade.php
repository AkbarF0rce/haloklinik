
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Muhamad Nauval Azhar">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="description" content="This is a login page template based on Bootstrap 5">
	<title>Login Haloklinik</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-sm-center h-100">
				<div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9 mt-5">
					<div class="card shadow-lg mt-5">
						<div class="text-center mt-5">
							<img src="{{asset('auth/logo.png')}}" class="shadow-sm rounded" width="100">
						</div>
						<div class="card-body p-5">
							<h1 class="fs-4 card-title fw-bold mb-4">Login</h1>
							<form method="POST" class="needs-validation" action="{{route('loginProses')}}">
								@csrf
								<div class="input-group mb-4">
									<div class="input-group-append">
										<span class="input-group-text" id="basic-addon1"><i class="bi bi-person-fill"></i></span>
									</div>
									<input type="text" class="form-control" placeholder="Username" id="username" aria-label="Username" aria-describedby="basic-addon1" name="username">
								</div>

								<div class="input-group mb-4">
									<div class="input-group-prepend">
										<span class="input-group-text" id="basic-addon1"><i class="bi bi-key"></i></span>
									</div>
									<input type="password" class="form-control" id="password" placeholder="Password"  aria-label="Username" aria-describedby="basic-addon1" name="password">
								</div>

								<div class="d-flex align-items-center">
									<div class="form-check">
										<input type="checkbox" name="remember" id="remember" class="form-check-input">
										<label for="remember" class="form-check-label">Remember Me</label>
									</div>
									<button type="submit" class="btn btn-primary ms-auto">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="text-center mt-5 text-muted">
						Copyright &copy; 2017-2021 &mdash; Your Company 
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="{{asset('auth/script.js')}}"></script>

	@if($message = Session::get('failed'))
		<script type="module">
			Swal.fire({
				title: "{{ $message }}",
				icon: "error"
			});
		</script>
	@endif
</body>
</html>
