    <!-- Preloader-->
    {{-- <div class="preloader" id="preloader">
        <div class="spinner-grow text-secondary" role="status">
          <div class="sr-only"></div>
        </div>
      </div> --}}
      <!-- Header Area -->
      <div class="header-area" id="headerArea">
        <div class="container h-100 d-flex align-items-center justify-content-between d-flex rtl-flex-d-row-r">
          <!-- Logo Wrapper -->
          <div class="logo-wrapper"><a href="home.html"><img src="{{ asset('logo.png') }}" style="height: 35px" alt=""> </a></div>
          <div class="navbar-logo-container d-flex align-items-center">
            <!-- Cart Icon -->

            <!-- User Profile Icon -->
            @auth
            <div class="cart-icon-wrap"><a href="cart.html"><i class="ti ti-basket-bolt"></i><span>13</span></a></div>
            <div class="user-profile-icon ms-2"><a href="profile.html"><img src="img/bg-img/9.jpg" alt=""></a></div>
            @else
            <div class="ms-2"><a wire:navigate href="{{ route('login') }}" class="btn  btn-md btn-primary"><i class="ti ti-login"></i> Masuk</a></div>

            <div class="ms-2"><a wire:navigate href="{{ route('login') }}" class="btn  btn-md btn-warning"><i class="ti ti-pencil"></i> Daftar </a></div>
            @endauth
            <!-- Navbar Toggler -->

          </div>
        </div>
      </div>
      <x-sidebar/>
