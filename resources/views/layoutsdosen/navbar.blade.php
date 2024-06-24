  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <b class="nav-link"></b>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
        <b class="nav-link">Presensi Universitas Andalas </b>
    </li>
</ul>

<!-- Right navbar links -->
<ul class="navbar-nav ml-auto">

    <li class="nav-item dropdown user-menu">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
{{-- <img src="{{ asset('images/Logo Unand.png') }}" class="user-image img-circle elevation-2" alt="User Image"> --}}

        </a>
        <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">

            <!-- Menu Footer-->
            <li class="user-footer">
                <p><span class="text-primary">
                        {{-- @if(Auth::check()) {{ Auth::user()->name }} @endif
                    </span></p>
<br>
                @if (Auth::check())

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn btn-dark btn-flat float-right" type="submit">Logout</button>
                </form> --}}
<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
Ubah Password
</button>

<!-- Modal -->

                {{-- @endif --}}

            </li>
        </ul>
    </li>

    <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
        </a>
    </li>
</ul>
