@include('main.components.sidebar.left-sidebar-admin')

<aside class="left-sidebar" data-sidebarbg="skin6">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar" data-sidebarbg="skin6">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="sidebar-item"><a class="sidebar-link sidebar-link" href="{{ URL('/home') }}"
                                            aria-expanded="false"><i data-feather="home" class="feather-icon"></i><span
                            class="hide-menu">Dashboard</span></a></li>

                @if (Auth::user()->role != 3)
                    <li class="list-divider"></li>

                    <li class="nav-small-cap"><span class="hide-menu">Data Pengguna</span></li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('/admin/user/create') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Pengguna
                            </span>
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('/admin/user/manage') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Manage
                            </span>
                        </a>
                    </li>

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">Konten</span></li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('news/create') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Tambah Konten
                        </span>
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('news/manage') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Manage Konten
                        </span>
                        </a>
                    </li>

                    <li class="list-divider"></li>
                    <li class="nav-small-cap"><span class="hide-menu">DATA KTP</span></li>

                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('ktp/create') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Tambah KTP
                        </span>
                        </a>
                    </li>
                    <li class="sidebar-item active">
                        <a class="sidebar-link" href="{{ URL('ktp/manage') }}" aria-expanded="false">
                            <i data-feather="tag" class="feather-icon"></i>
                            <span class="hide-menu">Manage KTP
                        </span>
                        </a>
                    </li>
                @endif

                <li class="list-divider"></li>


                <li class="nav-small-cap"><span class="hide-menu">Extra</span></li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

                <li class="sidebar-item"><a class="sidebar-link sidebar-link" href="{{ route('logout') }}"
                                            onclick="event.preventDefault();  document.getElementById('logout-form').submit();"
                                            aria-expanded="false"><i data-feather="log-out"
                                                                     class="feather-icon"></i><span
                            class="hide-menu">Logout</span></a></li>

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</aside>

