<ul class="sidebar-menu">
    <li class="menu-header">General</li>
    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('*sys-admin/dashboard*') ? 'active' : ''}}">
        <a href="{{route('admin.dashboard')}}" class="nav-link">
            <i class="fas fa-tachometer-alt"></i><span>Dashboard</span>
        </a>
    </li>

    @if(Auth::user()->isRoot() || Auth::user()->isOwner())
        <li class="dropdown {{\Illuminate\Support\Facades\Request::is('*sys-admin/inbox*') ? 'active' : ''}}">
            <a href="{{route('admin.inbox')}}" class="nav-link"><i
                    class="fas fa-envelope"></i><span>Kotak Masuk</span></a>
        </li>
    @endif

    <li class="menu-header">Tables</li>

    @if(Auth::user()->isRoot() || Auth::user()->isOwner())
        <li class="dropdown {{\Illuminate\Support\Facades\Request::is('*sys-admin/account*') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="fas fa-user-cog"></i><span>Privilege</span></a>
            <ul class="dropdown-menu">
                <li class="{{\Illuminate\Support\Facades\Request::is('*sys-admin/account/admins*') ?
                'active' : ''}}"><a href="{{route('admin.show.list')}}" class="nav-link">Admin</a></li>
                <li class="{{\Illuminate\Support\Facades\Request::is('*sys-admin/account/admins/user*') ?
                'active' : ''}}"><a href="{{route('admin.user.list')}}" class="nav-link">User</a></li>
                <li class="{{\Illuminate\Support\Facades\Request::is('*sys-admin/account/profile*') ?
                'active' : ''}}"><a href="{{route('admin.profil')}}" class="nav-link">Sunting Profil</a></li>
            </ul>
        </li>
    @endif
</ul>

<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
    <a href="{{route('beranda')}}" class="btn btn-primary btn-lg btn-block btn-icon-split">
        <b><i class="fas fa-rocket"></i> SITUS UTAMA</b></a>
</div>
