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
    <li class="dropdown  {{\Illuminate\Support\Facades\Request::is('*scott.royce/order*') ? 'active' : ''}}">
        <a href="{{route('admin.order')}}" class="nav-link"><i class="fas fa-archive"></i><span>Pesanan</span></a>
    </li>
    <li class="menu-header">Tables</li>

    <li class="dropdown  {{\Illuminate\Support\Facades\Request::is('*scott.royce/order*') ? 'active' : ''}}">
        <a href="" class="nav-link"><i class="fas fa-shopping-bag"></i><span>Produk</span></a>
    </li>

    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('*scott.royce/tables/categories*') ? 'active' : ''}}">
        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-database"></i><span>Kategori</span></a>
        <ul class="dropdown-menu">
            <li class="{{\Illuminate\Support\Facades\Request::is('*scott.royce/tables/categories/main*') ?
                'active' : ''}}"><a href="" class="nav-link">Kategori</a></li>
            <li class="{{\Illuminate\Support\Facades\Request::is('*scott.royce/tables/categories/sub*') ?
                'active' : ''}}"><a href="" class="nav-link">Sub Kategori</a></li>

        </ul>
    </li>

    <li class="dropdown {{\Illuminate\Support\Facades\Request::is('*scott.royce/tables/msc*') ? 'active' : ''}}">
        <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
            <i class="fas fa-cogs"></i><span>Lain Lain</span></a>
        <ul class="dropdown-menu">
            <li class="{{\Illuminate\Support\Facades\Request::is('*scott.royce/tables/msc/promo*') ?
                'active' : ''}}"><a href="{{route('admin.promo')}}" class="nav-link">Promo</a></li>
            {{--                <li class="{{\Illuminate\Support\Facades\Request::is('*scott.royce/tables/msc/privacy*') ?--}}
            {{--                'active' : ''}}"><a href="{{route('table.blog.posts')}}" class="nav-link">Privacy & Term</a></li>--}}
            <li class="{{\Illuminate\Support\Facades\Request::is('*scott.royce/tables/msc/setting*') ?
                'active' : ''}}"><a href="{{route('admin.setting.general')}}" class="nav-link">Pengaturan</a></li>
        </ul>
    </li>



    @if(Auth::user()->isRoot() || Auth::user()->isOwner())
        <li class="dropdown {{\Illuminate\Support\Facades\Request::is('*sys-admin/account*') ? 'active' : ''}}">
            <a href="javascript:void(0)" class="nav-link has-dropdown" data-toggle="dropdown">
                <i class="fas fa-user-cog"></i><span>Akun</span></a>
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
