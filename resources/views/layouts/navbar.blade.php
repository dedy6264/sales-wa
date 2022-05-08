<div class="navbar-brand">
	<a href="{{ route('dashboard') }}" class="d-inline-block">
		{{-- <img src="{{ asset('template-new/global_assets/images/logo_light.png') }}" alt=""> --}}
		<img src="{{ asset('custom-resources/images/navbar-icon.png') }}" alt="">
	</a>
</div>

<div class="d-md-none">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-mobile">
		<i class="icon-stack2"></i>
	</button>
	<button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
		<i class="icon-paragraph-justify3"></i>
	</button>
</div>

<div class="collapse navbar-collapse" id="navbar-mobile">
	<ul class="navbar-nav">
		<li class="nav-item">
			<a href="#" class="navbar-nav-link sidebar-control sidebar-main-toggle d-none d-md-block">
				<i class="icon-paragraph-justify3"></i>
			</a>
		</li>
	</ul>
	<span class="badge bg-warning ml-1">{{ date('l, d - m - Y') }}</span>
	<span class="badge bg-info ml-md-3 mr-md-auto">Online</span>


	<ul class="navbar-nav">
		<li class="nav-item dropdown dropdown-user">
			<a href="#" class="navbar-nav-link d-flex align-items-center dropdown-toggle" data-toggle="dropdown">
				<img src="{{ asset('custom-resources/images/usericon.png') }}" class="rounded-circle mr-2" height="34" alt="">
				<span>{{ auth()->user()->email }}</span>
			</a>

			<div class="dropdown-menu dropdown-menu-right">
				<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="icon-switch2"></i> Logout</a>
{{-- 				<a href="#" class="dropdown-item"><i class="icon-user-plus"></i> My profile</a>
				<a href="#" class="dropdown-item"><i class="icon-coins"></i> My balance</a>
				<a href="#" class="dropdown-item"><i class="icon-comment-discussion"></i> Messages <span class="badge badge-pill bg-blue ml-auto">58</span></a>
				<div class="dropdown-divider"></div>
				<a href="#" class="dropdown-item"><i class="icon-cog5"></i> Account settings</a> --}}
			</div>
		</li>
	</ul>
</div>