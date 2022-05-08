<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('custom-resources/images/MKP - LOGO API.ico') }}">
	<title>Dashboard API Biller</title>

	<!-- Global stylesheets -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,300,100,500,700,900" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/global_assets/css/icons/icomoon/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/global_assets/css/icons/fontawesome/styles.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/bootstrap_limitless.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/layout.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/components.min.css') }}" rel="stylesheet" type="text/css">
	<link href="{{ asset('template/css/colors.min.css') }}" rel="stylesheet" type="text/css">
	<!-- /global stylesheets -->

	<!-- Custom stylesheets -->
	<link href="{{ asset('css/custom.css') }}" rel="stylesheet" type="text/css">
	@stack('css')
	<!-- /custom stylesheets -->
</head>

<body class="navbar-top">

	<!-- Main navbar -->
	<div class="navbar navbar-expand-md navbar-dark fixed-top">
		@include('layouts.navbar')
	</div>
	<!-- /main navbar -->


	<!-- Page content -->
	<div class="page-content" id="app">

		<!-- Main sidebar -->
		<div class="sidebar sidebar-dark sidebar-main sidebar-expand-md">
			@include('layouts.sidebar')			
		</div>
		<!-- /main sidebar -->


		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Page header/breadcrumb -->
			<div class="page-header page-header-light">
				@yield('breadcrumb')
			</div>
			<!-- /page header/breadcrumb -->


			<!-- Content area -->
			<div class="content">
				<div v-cloak>
					@yield('content')
				</div>
			</div>
			<!-- /content area -->


			<!-- Footer -->
			<div class="navbar navbar-expand-lg navbar-light">
				<div class="text-center d-lg-none w-100">
					<button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-footer">
						<i class="icon-unfold mr-2"></i>
						Footer
					</button>
				</div>

				<div class="navbar-collapse collapse" id="navbar-footer">
					<span class="navbar-text">
						&copy; 2020. Prowered by PT. Aplikasi Pembayaran Indonesia
					</span>
				</div>
			</div>
			<!-- /footer -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	<!-- Core JS files -->
	<script src="{{ asset('js/app.js') }}"></script>
	<script src="{{ asset('template/global_assets/js/plugins/loaders/blockui.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ asset('template/global_assets/js/plugins/extensions/jquery_ui/interactions.min.js') }}"></script>
	<script src="{{ asset('template/global_assets/js/plugins/tables/datatables/datatables.min.js') }}"></script>
	<script src="{{ asset('template/global_assets/js/plugins/forms/selects/select2.min.js') }}"></script>
	<script src="{{ asset('template/global_assets/js/plugins/forms/styling/uniform.min.js') }}"></script>
	<script src="{{ asset('template/global_assets/js/plugins/buttons/spin.min.js') }}"></script>
	<script src="{{ asset('template/global_assets/js/plugins/buttons/ladda.min.js') }}"></script>
	<script src="{{ asset('template/js/app.js') }}"></script>

	<script>
        $.extend( $.fn.dataTable.defaults, {
            autoWidth: false,
            dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
			// scrollX: true,
			pageLength: 25,
			lengthMenu: [25, 50,100],
            language: {
                search: '<span>Search:</span> _INPUT_',
                searchPlaceholder: 'Type to search...',
                lengthMenu: '<span>Show:</span> _MENU_',
                paginate: { 'first': 'First', 'last': 'Last', 'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;', 'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;' }
            }
        });
	</script>
	<!-- /theme JS files -->

	<!-- Custom JS files -->
	@include('layouts.partials.custom-script')
	@stack('js')
	<!-- /custom JS files -->

</body>
</html>