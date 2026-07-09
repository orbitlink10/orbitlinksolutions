@if(!Auth::user()->is_admin())
    <!-- User Dashboard -->
    <li class="nav-item">
        <a href="{{ route('account.dashboard') }}" class="nav-link {{ Route::is('account.dashboard') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-circle"></i>
            <p>Dashboard</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('account.orders') }}" class="nav-link {{ Route::is('account.orders') ? 'active' : '' }}">
            <i class="nav-icon fas fa-shopping-bag"></i>
            <p>My Orders</p>
        </a>
    </li>



    <li class="nav-item">
        <a href="{{ route('account.payments') }}" class="nav-link {{ Route::is('account.payments') ? 'active' : '' }}">
            <i class="nav-icon fas fa-wallet"></i>
            <p>Payments</p>
        </a>
    </li>


@else


<!-- Dashboard -->
<li class="nav-item">
    <a href="{{ route('home') }}" class="nav-link {{ request()->is('home') ? 'active' : '' }}">
        <i class="nav-icon fas fa-tachometer-alt"></i>
        <p>Dashboard</p>
    </a>
</li>


    <!-- Admin Content Management -->
    <li class="nav-header">Content Management</li>
    <li class="nav-item">
        <a href="{{ route('categories.index') }}" class="nav-link {{ request()->is('categories*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-list-alt"></i>
            <p>Categories</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('sub_categories.index') }}" class="nav-link {{ request()->is('sub_categories*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tags"></i>
            <p>Sub Categories</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('products.index') }}" class="nav-link {{ request()->is('products*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-boxes"></i>
            <p>Products</p>
        </a>
    </li>


    @if(in_array(request()->getHost(), ['gamun.co.ke','www.gamun.co.ke']))
    <li class="nav-item">
        <a href="{{ route('admin.welding-products.index') }}" class="nav-link {{ request()->is('admin/welding-products*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-boxes"></i>
            <p>Welding Products</p>
        </a>
    </li>
    @endif



    <li class="nav-item">
        <a href="{{ route('orders.index') }}" class="nav-link {{ request()->is('orders*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Orders</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('invoices.index') }}" class="nav-link {{ request()->is('invoices*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-invoice"></i>
            <p>Invoices</p>
        </a>
    </li>


    <li class="nav-item">
        <a href="{{ route('notifications.index') }}" class="nav-link {{ request()->is('notifications*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-bell"></i>
            <p>Requests</p>
        </a>
    </li>

    <li class="nav-item">
        <a href="{{ route('designs.index') }}" class="nav-link {{ request()->is('designs*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-bell"></i>
            <p>Designs</p>
        </a>
    </li>

    <!-- Admin Panel -->
    <li class="nav-header">Admin Panel</li>
    <li class="nav-item">
        <a href="{{ route('admin.users') }}" class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-users"></i>
            <p>Users</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.pages_content') }}" class="nav-link {{ request()->is('admin/pages*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Homepage Content</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('sliders.index') }}" class="nav-link {{ request()->is('sliders*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-images"></i>
            <p>Sliders</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('pages') }}" class="nav-link {{ request()->is('pages*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-edit"></i>
            <p>Pages</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('service.index') }}" class="nav-link {{ request()->is('service*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-tools"></i>
            <p>Services</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('testimonials.index') }}" class="nav-link {{ request()->is('testimonials*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-comment-alt"></i>
            <p>Testimonials</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('medias.index') }}" class="nav-link {{ request()->is('medias*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-photo-video"></i>
            <p>Media</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('menus.index') }}" class="nav-link {{ request()->is('menus*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-bars"></i>
            <p>Menus</p>
        </a>
    </li>
    <li class="nav-item">
        <a href="{{ route('admin.settings') }}" class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}">
            <i class="nav-icon fas fa-cogs"></i>
            <p>Settings</p>
        </a>
    </li>
@endif

<!-- Logout -->
<li class="nav-header">Account</li>


    <li class="nav-item">
        <a href="{{ route('account.details') }}" class="nav-link {{ Route::is('account.details') ? 'active' : '' }}">
            <i class="nav-icon fas fa-user-edit"></i>
            <p>Profile</p>
        </a>
    </li>


<li class="nav-item">
    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i class="nav-icon fas fa-sign-out-alt"></i>
        <p>Logout</p>
    </a>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</li>
