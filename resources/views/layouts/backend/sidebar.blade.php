 <nav class="navbar-default navbar-static-side" role="navigation">
        <div class="sidebar-collapse">
            <ul class="nav" id="side-menu">
                <li class="nav-header">
                    <div class="dropdown profile-element"> <span>
                            <img alt="image" style="max-width: 48px" class="img-circle" src="{{\Auth::user()->getAvatarurl()}}"/>
                             </span>
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">{{\Auth::user()->getNameOrEmail(true)}}</strong>
                             </span> <span class="text-muted text-xs block">{{\Auth::user()->role->name}} <b class="caret"></b></span> </span> </a>
                        <ul class="dropdown-menu animated fadeInRight m-t-xs">
                           
                        </ul>
                    </div>
                    <div class="logo-element">
                        Rollo
                    </div>
                </li>                
                <li>
                    <a href="{{route('dashboard.index')}}"><i class="fa fa-diamond"></i> <span class="nav-label">Dashboard</span></a>
                </li>
                @if(auth()->user()->isAdmin())
                <li class="">
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">RBAC</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li class="active"><a href="{{route('users.index')}}">Users</a></li>
                        <li><a href="{{route('roles.index')}}">Roles</a></li>
                        <li><a href="{{route('permissions.index')}}">Permissions</a></li>
                    </ul>
                </li>  
                @endif

                <li class="">
                    <a href="#"><i class="fa fa-user"></i> <span class="nav-label">Barang</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li><a href="{{route('products.index')}}">List Barang</a></li>
                        <li><a href="{{route('product.add')}}">Tambah Barang</a></li>    
                                           
                    </ul>
                </li>  
                
                <li>
                    <a href="{{route('orders.index')}}"><i class="fa fa-money"></i> <span class="nav-label">Penjualan</span></a>
                </li>
                @if(auth()->user()->isAdmin())            
                <li>
                    <a href="{{route('kasir.index')}}"><i class="fa fa-money"></i> <span class="nav-label">Kasir</span></a>
                </li> 
                @endif           
                
                <li>
                    <a href="{{route('report.index')}}"><i class="fa fa-pie-chart"></i> <span class="nav-label">Laporan</span></a>
                </li>  
                <li style="background-color: red;">
                    @if(getSetting('kasir_is_blocked') == '1')
                        <a href="{{route('toggle.block.app','open')}}"><i class="fa fa-exclamation"></i> <span class="nav-label">Buka Aplikasi</span></a>
                    @else
                        <a href="{{route('toggle.block.app','close')}}"><i class="fa fa-exclamation"></i> <span class="nav-label">Tutup Aplikasi</span></a>
                    @endif
                </li>            


            </ul>

        </div>
    </nav>