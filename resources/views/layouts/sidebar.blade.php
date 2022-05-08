<!-- Sidebar mobile toggler -->
<div class="sidebar-mobile-toggler text-center">
	<a href="#" class="sidebar-mobile-main-toggle">
		<i class="icon-arrow-left8"></i>
	</a>
	Navigation
	<a href="#" class="sidebar-mobile-expand">
		<i class="icon-screen-full"></i>
		<i class="icon-screen-normal"></i>
	</a>
</div>
<!-- /sidebar mobile toggler -->


<!-- Sidebar content -->
<div class="sidebar-content">

	<!-- User menu -->
	<div class="sidebar-user">
		<div class="card-body">
			<div class="media">
				<div class="mr-3">
					<a href="javascript:void(0)"><img src="{{ asset('custom-resources/images/usericon.png') }}" width="38" height="38" class="rounded-circle" alt=""></a>
				</div>

				<div class="media-body align-self-center">
					<div class="media-title font-weight-semibold">{{ auth()->user()->name }}</div>
				</div>
			</div>
		</div>
	</div>
	<!-- /user menu -->


	<!-- Main navigation -->
	<div class="card card-sidebar-mobile">
		<ul class="nav nav-sidebar" data-nav-type="accordion">

			<li class="nav-item-header"><div class="text-uppercase font-size-xs line-height-xs">Main</div> <i class="icon-menu" title="Main"></i></li>
			<li class="nav-item">
				<a href="{{ route('dashboard') }}" class="nav-link {{ $activeMenu == 'dashboard' ? 'active' : '' }}">
					<i class="icon-home4"></i>
					<span>Dashboard</span>
				</a>
			</li>

			<li class="nav-item nav-item-submenu 
			{{ in_array($activeMenu, ['user']) ? 'nav-item-expanded nav-item-open' : '' }}">
				<a href="#" class="nav-link"><i class="icon-user"></i> <span>User Management</span></a>
				<ul class="nav nav-group-sub" data-submenu-title="User Admin">
					<li class="nav-item"><a href="{{ url()->to('user') }}" class="nav-link {{ $activeMenu == 'user' ? 'active' : '' }}">User</a></li>
				</ul>
			</li>

			<li class="nav-item nav-item-submenu 
			{{ in_array($activeMenu, [ 'client', 'message', 'send', 'merchant', 'merchantOutlet']) ? 'nav-item-expanded nav-item-open' : '' }}">
				<a href="#" class="nav-link"><i class="icon-city"></i> <span>Corporate</span></a>
				<ul class="nav nav-group-sub" data-submenu-title="Corporate">
					<li class="nav-item"><a href="{{ route('client.index') }}" class="nav-link {{ $activeMenu == 'client' ? 'active' : '' }}">Client</a></li>
					<li class="nav-item"><a href="{{ route('message.index') }}" class="nav-link {{ $activeMenu == 'message' ? 'active' : '' }}">Message</a></li>
					<li class="nav-item"><a href="{{ route('send.index') }}" class="nav-link {{ $activeMenu == 'send' ? 'active' : '' }}">Send</a></li>
					
				</ul>
			</li>
			
			<li class="nav-item">
				<a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();" >
					<i class="icon-exit2"></i>
					<span>Keluar</span>
				</a>
				
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
			</li>

		</ul>
	</div>
	<!-- /main navigation -->

</div>
<!-- /sidebar content -->