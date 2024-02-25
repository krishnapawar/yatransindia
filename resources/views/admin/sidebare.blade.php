<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white shadow-sm">
    <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
            <a href="{{ route('home') }}"
                class="list-group-item list-group-item-action py-2 ripple {{ request()->is('dashboard') ? 'active' : '' }}"
                aria-current="true">
                <i class="fas fa-tachometer-alt fa-fw me-3"></i><span>Main dashboard</span>
            </a>

            <a href="{{ route('profile') }}"
                class="list-group-item list-group-item-action py-2 ripple {{ request()->is('dashboard/profile*') ? 'active' : '' }}">
                <i class="fas fa-user fa-fw me-3"></i><span>Profile</span>
            </a>

            <a href="{{ route('users.index') }}"
                class="list-group-item list-group-item-action py-2 ripple {{ request()->is('dashboard/users*') ? 'active' : '' }}">
                <i class="fas fa-users fa-fw me-3"></i><span>Users</span>
            </a>
            <a class="list-group-item list-group-item-action py-2 ripple " href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                <i class="fas fa-sign-out-alt fa-fw me-3"></i><span>{{ __('Logout') }}</span>

            </a>


        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
