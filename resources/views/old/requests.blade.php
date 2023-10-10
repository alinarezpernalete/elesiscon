@extends('layouts.app')

@section('title', 'Compras | Solicitudes')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Panel de Opciones') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="col">
                            <div class="row mx-auto w-100 justify-content-center">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#solicitud">Solicitud</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#articulos">Artículos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#solicitudes">Solicitudes</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!---------------->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="myTabContent" class="tab-content">      
                    <div class="tab-pane fade active show">
                        <div class="col-md-12 text-center my-5">Seleccione una de las opciones mostradas en el navegador</div>
                    </div>
                    <div class="tab-pane fade" id="solicitud">
                        <form action="" method="POST">
                            @method('POST')
                            @csrf
                            <div class="form-group mt-4">
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" name="" class="form-control col-md-12 my-1" id="" placeholder="Código">
                                    </div>
                                    <div class="col">
                                        <select class="browser-default custom-select col-md-12 my-1">
                                            <option selected="">Cond. Pago</option>
                                            <option value="1">...</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <input type="date" name="" class="form-control col-md-12 my-1" id="">
                                    </div>
                                    <div class="col">
                                        <input type="date" name="" class="form-control col-md-12 my-1" id="">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <select class="browser-default custom-select col-md-12 my-1">
                                            <option selected="">Proveedor</option>
                                            <option value="1">...</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="" class="form-control col-md-12 my-1" id="" placeholder="Descripción">
                                    </div>
                                </div>
                                        
                                <hr class="my-4">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary col">Solicitar</button>
                            </div>
                        </form> 
                    </div>
                    <div class="tab-pane fade" id="articulos">
                        <div class="form-group mt-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="" method="GET">
                                        <div class="input-group mb-4">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" value="">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive-sm table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Empleado</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>1</td>
                                                    <td>q</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="solicitudes">
                        <div class="form-group mt-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="" method="GET">
                                        <div class="input-group mb-4">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" value="">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive-sm table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Empleado</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <th scope="row">2</th>
                                                    <td>1</td>
                                                    <td>q</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>           
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
    });
</script>
@endsection('scripts')
