<ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">
    <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->
    <li class="nav-item">
        <a href="{{route('home')}}" class="nav-link @stack('menu-active-dashboard')">
            <i class="nav-icon fas fa-home"></i>
            <p>Home</p>
        </a>
    </li>


    <li class="nav-item">
        <a href="{{route('kelas.index')}}" class="nav-link @stack('menu-active-kelas')">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>Kelas</p>
        </a>
    </li>
  
    <li class="nav-item">
        <a href="{{route('mhs.absensi.report.list')}}" class="nav-link @stack('menu-active-kelas')">
            <i class="nav-icon fas fa-graduation-cap"></i>
            <p>Report Absensi Perkuliahan</p>
        </a>
    </li>
 

    <li class="nav-item">
        <a href="{{ route('logout.authsso') }}" class="nav-link ">
            <i class="nav-icon fas fa-door-open"></i>
            <p>Back to Dashboard SSO</p>
        </a>
    </li>















</ul>
