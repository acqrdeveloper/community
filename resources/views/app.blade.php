<!doctype html>
<html lang="en">
<head>
    <title>Laravel vs Vue2js</title>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @include('layouts.top')
</head>
<body id="super-body">

{{--Wrapper--}}
<div id="wrapper">

    {{--Navigation--}}
    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">

        {{--Navbar-Header--}}
        @include('layouts.nav-left')

        {{--Navbar-Top-Links--}}
        @include('layouts.nav-right')

        {{--Sidebar Collapse--}}
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav dev-nav" id="side-menu">
                    <li class="href">
                        <router-link :to="{name: 'home'}"><i class="fa fa-dashboard fa-fw"></i>&nbsp;&nbsp;Home</router-link>
                    </li>
                    <li class="href">
                        <a href="#"><i class="fa fa-users fa-fw"></i>&nbsp;&nbsp;Persona<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <router-link :to="{name: 'personas'}"><i class="fa fa-list fa-fw"></i>Lista</router-link>
                            </li>
                            <li>
                                <router-link :to="{name: 'persona-create'}"><i class="fa fa-plus fa-fw"></i>Nuevo</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="href">
                        <a href="#"><i class="fa fa-users fa-fw"></i>&nbsp;&nbsp;Empresa<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <router-link :to="{name: 'empresa-create'}"><i class="fa fa-plus fa-fw"></i>Nuevo</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="href">
                        <a href="#"><i class="fa fa-cogs fa-fw"></i>&nbsp;&nbsp;Mantenimiento<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <router-link :to="{name: 'tablas'}"><i class="fa fa-list fa-fw"></i>Lista</router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="href">
                        <a href="#"><i class="fa fa-money fa-fw"></i>&nbsp;&nbsp;Comprobante Pago<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <li>
                                <router-link :to="{name: 'home'}"><i class="fa fa-list fa-fw"></i>Lista</router-link>
                            </li>
                            <li>
                                <router-link :to="{name: 'comprobante-create'}"><i class="fa fa-plus fa-fw"></i>Nuevo</router-link>
                            </li>
                            <li>
                                <router-link :to="{name: 'home'}"><i class="fa fa-filter fa-fw"></i>Filtro Especificado</router-link>
                            </li>
                            <li>
                                <router-link :to="{name: 'home'}"><i class="fa fa-file fa-fw"></i>Reportes</router-link>
                            </li>
                            <li>
                                <router-link :to="{name: 'home'}"><i class="fa fa-history fa-fw"></i>Movimientos</router-link>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>

    </nav>

    {{--Page-Wrapper--}}
    <div id="page-wrapper">

        <div id="alert_flash"></div>
        <div id="alert_error"></div>
        <router-view></router-view>

    </div>

</div>

@include('layouts.bottom')

</body>
</html>

