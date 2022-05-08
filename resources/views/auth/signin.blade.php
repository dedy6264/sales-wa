<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Dashboard API</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
	<script src="{{ asset('template/global_assets/js/main/jquery.min.js') }}"></script>
	<script src="{{ asset('template/global_assets/js/main/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('template/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ asset('template/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body>

	<!-- Page content -->
    <div class="page-content" style="background: url('{{ asset('custom-resources/images/login-bg.jpg') }}') no-repeat fixed;
    background-size: auto; background-size: cover;">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Content area -->
			<div class="content d-flex justify-content-center align-items-center">

				<!-- Login card -->
				<form class="login-form" method="POST" action="{{ route('login') }}">
					@csrf
					<div class="card mb-0">
						<div class="card-body">
							<div class="text-center mb-3">
								<img src="{{ asset('custom-resources/images/logo-api.png') }}" width="95%">
							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input name="username" type="text" class="form-control" placeholder="Email/Username" @error('username') is-invalid @enderror value="{{ old('username') }}" required autocomplete="username" autofocus>
								<div class="form-control-feedback">
									<i class="icon-user text-muted"></i>
								</div>

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror

							</div>

							<div class="form-group form-group-feedback form-group-feedback-left">
								<input type="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password" name="password" required autocomplete="current-password">
								<div class="form-control-feedback">
									<i class="icon-lock2 text-muted"></i>
								</div>

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
							</div>

							<div class="form-group">
								<button type="submit" class="btn bg-grey btn-block  btn-ladda" data-style="zoom-out">Login <i class="icon-circle-right2 ml-2"></i></button>
							</div>

							<span class="form-text text-center text-muted">&copy; 2021. Prowered by API Biller</span>
						</div>
					</div>
				</form>
				<!-- /login card -->

			</div>
			<!-- /content area -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->

</body>
</html>
