
        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-address-card"></i>
                </div>
                <div class="sidebar-brand-text mx-3">{{ config('app.name') }}</div>
            </a>
            
            <!-- Divider -->
            <hr class="sidebar-divider">

            @php
                $user_menu = \App\UserMenu::getMenuByRole(auth()->user()->role_id);                
            @endphp
            @foreach ($user_menu as $menu)
                <div class="sidebar-heading">
                    {{ $menu->menu }}
                </div>

                @php
                    $user_submenu = \App\UserSubmenu::getSubmenuByMenu($menu->id);
                @endphp

                @foreach ($user_submenu as $submenu)
                    @if ($title == $submenu->title)
                    <li class="nav-item active">
                    @else
                    <li class="nav-item">
                    @endif
                        <a class="nav-link pb-0" href="{{ url(''.$submenu->url) }}">
                            <i class="{{ $submenu->icon }}"></i>
                            <span>{{ $submenu->title }}</span>
                        </a>
                    </li>
                @endforeach

            <!-- Divider -->
            <hr class="sidebar-divider mt-3">
            @endforeach

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
