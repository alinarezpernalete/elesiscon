<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Sistema') }} - @yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
   
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        table th { width: 140px; text-align: center; }
        table td { width: 140px; text-align: center; }
    </style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Sistema') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->

                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Administración
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route ('hoursManagement') }}">Manejo de horas</a>
                                <a class="dropdown-item" href="{{ route ('employees') }}">Empleados</a>
                                <a class="dropdown-item" href="{{ route ('customers') }}">Clientes</a>
                                <a class="dropdown-item" href="{{ route ('providers') }}">Proveedores</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('managementMaintenance') }}">Mantenimiento</a>
                            </div>
                        </li>
                        <!-- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Ventas
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route ('quotation') }}">Cotización</a>
                                <a class="dropdown-item" href="{{ route ('saleOrder') }}">Pedido</a>
                                <a class="dropdown-item" href="{{ route ('deliveryNote') }}">Nota de Entrega</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('bill') }}">Factura de Venta</a>
                            </div>
                        </li>
                        <!-- -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Compras
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route ('purchaseOrder') }}">Orden de Compra</a>
                                <a class="dropdown-item" href="{{ route ('receiptNote') }}">Nota de Recepción</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('invoice') }}">Factura de Compra</a>
                            </div>
                        </li>
                        @if(Auth::user()->name == "Administrador")
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Inventario
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route ('articles') }}">Artículos</a>
                            </div>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Finanzas
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route ('AP') }}">Facturas pagadas</a>
                                <a class="dropdown-item" href="{{ route ('AR') }}">Facturas cobradas</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('financeMaintenance') }}">Mantenimiento</a>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                              Reportes
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item disabled" href="#">Administración</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('hmReport') }}">Manejo de horas</a>
                                <a class="dropdown-item" href="{{ route ('empReport') }}">Empleados</a>
                                <a class="dropdown-item" href="{{ route ('custReport') }}">Clientes</a>
                                <a class="dropdown-item" href="{{ route ('provReport') }}">Proveedores</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#">Ventas</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('quoReport') }}">Cotizaciones</a>
                                <a class="dropdown-item" href="{{ route ('SOReport') }}">Pedidos</a>
                                <a class="dropdown-item" href="{{ route ('delNoteReport') }}">Notas de entrega</a>
                                <a class="dropdown-item" href="{{ route ('billReport') }}">Facturas de venta</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#">Compras</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('POReport') }}">Órdenes de compra</a>
                                <a class="dropdown-item" href="{{ route ('recNoteReport') }}">Notas de recepción</a>
                                <a class="dropdown-item" href="{{ route ('invoiceReport') }}">Facturas de compra</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#">Inventario</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('articleReport') }}">Artículos</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item disabled" href="#">Finanzas</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route ('APReport') }}">Facturas pagadas</a>
                                <a class="dropdown-item" href="{{ route ('ARReport') }}">Facturas cobradas</a>
                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('js/jquery-3.5.0.js') }}"></script>
    @yield('scripts')

</body>
</html>
