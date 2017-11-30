<div class="navbar-default sidebar" role="navigation" style="background-color: #fff">
    <div class="sidebar-nav navbar-collapse" style="background-color: #fff">
            <ul class="nav" id="side-menu" style="background-color: #fff">
                <li class="href">
                    <a href="#"><i class="fa fa-dashboard fa-fw"></i>Home<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ url('/about') }}">
                                <span><i class="fa fa-exclamation-circle fa-fw"></i>Acerca de</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}">
                                <span><i class="fa fa-exclamation-circle fa-fw"></i>Acerca de</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/about') }}">
                                <span><i class="fa fa-exclamation-circle fa-fw"></i>Persona</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="href">
                    <a href="#"><i class="fa fa-users fa-fw"></i>Gestionar Persona<span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li>
                            <a href="{{ url('/personas') }}">
                                <span><i class="fa fa-list fa-fw"></i>Lista</span>
                            </a>
                            <router-link v-bind:to="{name: 'personas'}">Personas</router-link>
                        </li>
                        <li>
                            <a href="{{ url('/persona') }}">
                                <span><i class="fa fa-plus fa-fw"></i>Crear Persona</span>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>