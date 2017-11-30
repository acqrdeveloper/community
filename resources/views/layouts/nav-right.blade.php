<ul class="nav navbar-top-links navbar-right">
    <!-- /.dropdown -->
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <span class="text-capitalize">{{ auth()->user()->nombres }}</span>&nbsp;
            <span class="small">(administrator)</span>
{{--            <span class="small">({{ strtolower(session('session_type_user')->name) }})</span>&nbsp;&nbsp;--}}
            <span class="avatar-image"><img alt="User" src="{{ !empty(auth()->user()->imagen) ? ASSET_USERS.auth()->user()->imagen : auth()->user()->imagen }}" width="100%" height="100%" style="max-height: 20px;max-width: 20px" ></span>&nbsp;&nbsp;
            <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li><a href="{{ url('/') }}"><i class="fa fa-cogs fa-fw"></i>&nbsp;Configuración</a></li>
            <li><a href="{{ url('/') }}"><i class="fa fa-user-secret fa-fw"></i>&nbsp;Administración</a></li>
            <li><a href="{{ url('/') }}"><i class="fa fa-user-circle fa-fw"></i>&nbsp;Información del Usuario</a></li>
            <li class="divider"></li>
            <li><a href="{{ url('/logout') }}"><i class="fa fa-sign-out fa-fw"></i>&nbsp;Logout</a></li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>