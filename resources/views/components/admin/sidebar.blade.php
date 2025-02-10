<nav id="sidebar" class="active">
    <div class="sidebar-header">
        <img src="assets/img/bootstraper-logo.png" alt="bootraper logo" class="app-logo">
    </div>
    <ul class="list-unstyled components text-secondary">
            <x-admin.sidebar.link href="{{ route('admin.dashboard') }}" :active="request()->routeIs('admin.dashboard')">
                <x-slot name="icon">fa-home</x-slot>
                Dashboard
            </x-admin.sidebar.link>
            <x-admin.sidebar.link href="{{ route('admin.members.index') }}" :active=" request()->routeIs('admin.members.*') ">
                <x-slot name="icon">fa-user</x-slot>
                Member
            </x-admin.sidebar.link>
            <x-admin.sidebar.link href="{{ route('admin.pages.index') }}" :active=" request()->routeIs('admin.pages.*') ">
                <x-slot name="icon">fa-file</x-slot>
                Halaman
            </x-admin.sidebar.link>
            <x-admin.sidebar.link href="{{ route('admin.banners.index') }}" :active=" request()->routeIs('admin.banners.*') ">
                <x-slot name="icon">fa-image</x-slot>
                Banner
            </x-admin.sidebar.link>
        <li>
            <a href="#uielementsmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-layer-group"></i> UI Elements</a>
            <ul class="collapse list-unstyled" id="uielementsmenu">
                <li>
                    <a href="ui-buttons.html"><i class="fas fa-angle-right"></i> Buttons</a>
                </li>
                <li>
                    <a href="ui-badges.html"><i class="fas fa-angle-right"></i> Badges</a>
                </li>
                <li>
                    <a href="ui-cards.html"><i class="fas fa-angle-right"></i> Cards</a>
                </li>
                <li>
                    <a href="ui-alerts.html"><i class="fas fa-angle-right"></i> Alerts</a>
                </li>
                <li>
                    <a href="ui-tabs.html"><i class="fas fa-angle-right"></i> Tabs</a>
                </li>
                <li>
                    <a href="ui-date-time-picker.html"><i class="fas fa-angle-right"></i> Date & Time Picker</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#authmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-user-shield"></i> Authentication</a>
            <ul class="collapse list-unstyled" id="authmenu">
                <li>
                    <a href="login.html"><i class="fas fa-lock"></i> Login</a>
                </li>
                <li>
                    <a href="signup.html"><i class="fas fa-user-plus"></i> Signup</a>
                </li>
                <li>
                    <a href="forgot-password.html"><i class="fas fa-user-lock"></i> Forgot password</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="#pagesmenu" data-bs-toggle="collapse" aria-expanded="false" class="dropdown-toggle no-caret-down"><i class="fas fa-copy"></i> Pages</a>
            <ul class="collapse list-unstyled" id="pagesmenu">
                <li>
                    <a href="blank.html"><i class="fas fa-file"></i> Blank page</a>
                </li>
                <li>
                    <a href="404.html"><i class="fas fa-info-circle"></i> 404 Error page</a>
                </li>
                <li>
                    <a href="500.html"><i class="fas fa-info-circle"></i> 500 Error page</a>
                </li>
            </ul>
        </li>
        <li>
            <a href="users.html"><i class="fas fa-user-friends"></i>Users</a>
        </li>
        <li>
            <a href="settings.html"><i class="fas fa-cog"></i>Settings</a>
        </li>
    </ul>
</nav>
