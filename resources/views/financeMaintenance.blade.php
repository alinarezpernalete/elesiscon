@extends('layouts.app')

@section('title', 'Mantenimiento')

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
                                    @if($filterSearch == "")
                                    <li class="nav-item">
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-bancos">Bancos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#listar-monedas">Monedas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#listar-cp">Condiciones de pago</a>
                                    </li>
                                    @endif
                                    @if($filterSearch == "codeBank" || $filterSearch == "nameBank")
                                    <li class="nav-item">
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-bancos">Bancos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#listar-monedas">Monedas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#listar-cp">Condiciones de pago</a>
                                    </li>
                                    @endif
                                    @if($filterSearch == "codeCurrency" || $filterSearch == "nameCurrency")
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#listar-bancos">Bancos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-monedas">Monedas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#listar-cp">Condiciones de pago</a>
                                    </li>
                                    @endif
                                    @if($filterSearch == "codePayment" || $filterSearch == "namePayment")
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#listar-bancos">Bancos</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#listar-monedas">Monedas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-cp">Condiciones de pago</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="myTabContent" class="tab-content">
                    <!---->
                    @if($filterSearch == "")
                    <div class="tab-pane fade active show" id="listar-bancos">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codeBank" class="form-control col-md-12 my-1" placeholder="Código banco">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="nameBank" class="form-control col-md-12 my-1" placeholder="Nombre banco">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="saveBank">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsBank">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeBank">Código banco</option>
                                                <option value="nameBank">Banco</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código banco</th>
                                                    <th scope="col">Banco</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBank">
                                                @foreach ($banks as $bank)
                                                    @if($bank->id > 1)
                                                    <tr>
                                                        <th hidden="hidden">{{ $bank->id }}</th>
                                                        <th scope="row">{{ $bank->codeBank }}</th>
                                                        <td>{{ $bank->nameBank }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="listar-monedas">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codeCurrency" class="form-control col-md-12 my-1" placeholder="Código moneda">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="nameCurrency" class="form-control col-md-12 my-1" placeholder="Nombre moneda">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="saveCurrency">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsCurrency">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeCurrency">Código moneda</option>
                                                <option value="nameCurrency">Moneda</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código moneda</th>
                                                    <th scope="col">Moneda</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableCurrency">
                                                @foreach ($currencies as $currency)
                                                    @if($currency->id > 1)
                                                    <tr>
                                                        <th hidden="hidden">{{ $currency->id }}</th>
                                                        <th scope="row">{{ $currency->codeCurrency }}</th>
                                                        <td>{{ $currency->nameCurrency }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="listar-cp">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codePayment" class="form-control col-md-12 my-1" placeholder="Código pago">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="namePayment" class="form-control col-md-12 my-1" placeholder="Nombre pago">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="savePayment">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsPayment">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codePayment">Código Pago</option>
                                                <option value="namePayment">Pago</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código Pago</th>
                                                    <th scope="col">Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablePayment">
                                                @foreach ($paymentConditions as $paymentCondition)
                                                    
                                                    <tr>
                                                        <th hidden="hidden">{{ $paymentCondition->id }}</th>
                                                        <th scope="row">{{ $paymentCondition->codePayment }}</th>
                                                        <td>{{ $paymentCondition->namePayment }}</td>
                                                    </tr>
                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($filterSearch == "codeBank" || $filterSearch == "nameBank")
                    <div class="tab-pane fade active show" id="listar-bancos">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codeBank" class="form-control col-md-12 my-1" placeholder="Código banco">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="nameBank" class="form-control col-md-12 my-1" placeholder="Nombre banco">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="saveBank">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsBank">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeBank">Código banco</option>
                                                <option value="nameBank">Banco</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código banco</th>
                                                    <th scope="col">Banco</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBank">
                                                @foreach ($banks as $bank)
                                                    @if($bank->id > 1)
                                                    <tr>
                                                        <th hidden="hidden">{{ $bank->id }}</th>
                                                        <th scope="row">{{ $bank->codeBank }}</th>
                                                        <td>{{ $bank->nameBank }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="listar-monedas">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codeCurrency" class="form-control col-md-12 my-1" placeholder="Código moneda">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="nameCurrency" class="form-control col-md-12 my-1" placeholder="Nombre moneda">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="saveCurrency">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsCurrency">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeCurrency">Código moneda</option>
                                                <option value="nameCurrency">Moneda</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código moneda</th>
                                                    <th scope="col">Moneda</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableCurrency">
                                                @foreach ($currencies as $currency)
                                                    @if($currency->id > 1)
                                                    <tr>
                                                        <th hidden="hidden">{{ $currency->id }}</th>
                                                        <th scope="row">{{ $currency->codeCurrency }}</th>
                                                        <td>{{ $currency->nameCurrency }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="listar-cp">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codePayment" class="form-control col-md-12 my-1" placeholder="Código pago">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="namePayment" class="form-control col-md-12 my-1" placeholder="Nombre pago">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="savePayment">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsPayment">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codePayment">Código Pago</option>
                                                <option value="namePayment">Pago</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código Pago</th>
                                                    <th scope="col">Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablePayment">
                                                @foreach ($paymentConditions as $paymentCondition)
                                                    
                                                    <tr>
                                                        <th hidden="hidden">{{ $paymentCondition->id }}</th>
                                                        <th scope="row">{{ $paymentCondition->codePayment }}</th>
                                                        <td>{{ $paymentCondition->namePayment }}</td>
                                                    </tr>
                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($filterSearch == "codeCurrency" || $filterSearch == "nameCurrency")
                    <div class="tab-pane fade show" id="listar-bancos">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codeBank" class="form-control col-md-12 my-1" placeholder="Código banco">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="nameBank" class="form-control col-md-12 my-1" placeholder="Nombre banco">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="saveBank">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsBank">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeBank">Código banco</option>
                                                <option value="nameBank">Banco</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código banco</th>
                                                    <th scope="col">Banco</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBank">
                                                @foreach ($banks as $bank)
                                                    @if($bank->id > 1)
                                                    <tr>
                                                        <th hidden="hidden">{{ $bank->id }}</th>
                                                        <th scope="row">{{ $bank->codeBank }}</th>
                                                        <td>{{ $bank->nameBank }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade active show" id="listar-monedas">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codeCurrency" class="form-control col-md-12 my-1" placeholder="Código moneda">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="nameCurrency" class="form-control col-md-12 my-1" placeholder="Nombre moneda">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="saveCurrency">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsCurrency">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeCurrency">Código moneda</option>
                                                <option value="nameCurrency">Moneda</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código moneda</th>
                                                    <th scope="col">Moneda</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableCurrency">
                                                @foreach ($currencies as $currency)
                                                    @if($currency->id > 1)
                                                    <tr>
                                                        <th hidden="hidden">{{ $currency->id }}</th>
                                                        <th scope="row">{{ $currency->codeCurrency }}</th>
                                                        <td>{{ $currency->nameCurrency }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade show" id="listar-cp">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codePayment" class="form-control col-md-12 my-1" placeholder="Código pago">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="namePayment" class="form-control col-md-12 my-1" placeholder="Nombre pago">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="savePayment">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsPayment">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codePayment">Código Pago</option>
                                                <option value="namePayment">Pago</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código Pago</th>
                                                    <th scope="col">Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablePayment">
                                                @foreach ($paymentConditions as $paymentCondition)
                                                    
                                                    <tr>
                                                        <th hidden="hidden">{{ $paymentCondition->id }}</th>
                                                        <th scope="row">{{ $paymentCondition->codePayment }}</th>
                                                        <td>{{ $paymentCondition->namePayment }}</td>
                                                    </tr>
                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endif
                    @if($filterSearch == "codePayment" || $filterSearch == "namePayment")
                    <div class="tab-pane fade" id="listar-bancos">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codeBank" class="form-control col-md-12 my-1" placeholder="Código banco">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="nameBank" class="form-control col-md-12 my-1" placeholder="Nombre banco">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="saveBank">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsBank">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeBank">Código banco</option>
                                                <option value="nameBank">Banco</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código banco</th>
                                                    <th scope="col">Banco</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBank">
                                                @foreach ($banks as $bank)
                                                    @if($bank->id > 1)
                                                    <tr>
                                                        <th hidden="hidden">{{ $bank->id }}</th>
                                                        <th scope="row">{{ $bank->codeBank }}</th>
                                                        <td>{{ $bank->nameBank }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="listar-monedas">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codeCurrency" class="form-control col-md-12 my-1" placeholder="Código moneda">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="nameCurrency" class="form-control col-md-12 my-1" placeholder="Nombre moneda">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="saveCurrency">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsCurrency">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeCurrency">Código moneda</option>
                                                <option value="nameCurrency">Moneda</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código moneda</th>
                                                    <th scope="col">Moneda</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableCurrency">
                                                @foreach ($currencies as $currency)
                                                    @if($currency->id > 1)
                                                    <tr>
                                                        <th hidden="hidden">{{ $currency->id }}</th>
                                                        <th scope="row">{{ $currency->codeCurrency }}</th>
                                                        <td>{{ $currency->nameCurrency }}</td>
                                                    </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade active show" id="listar-cp">
                        <div class="form-group mt-3">
                            @if(Auth::user()->name == "Administrador")
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" id="codePayment" class="form-control col-md-12 my-1" placeholder="Código pago">
                                </div>
                                <div class="col"> 
                                    <input type="text" id="namePayment" class="form-control col-md-12 my-1" placeholder="Nombre pago">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-3"> 
                                    <button class="btn btn-primary col" id="savePayment">Guardar</button>
                                </div>
                                <div class="col mt-3"> 
                                    <button class="btn btn-warning col" id="cleanFieldsPayment">Limpiar campos</button>
                                </div>
                            </div>
                            @endif
                            <hr class="my-4">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/financeMaintenance/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codePayment">Código Pago</option>
                                                <option value="namePayment">Pago</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/financeMaintenance/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            @if($search)
                            <div class="">
                                <div class="alert alert-success row mx-auto w-100 justify-content-center" role="alert">Resultados para tu busqueda: '{{$search}}'</div>
                            </div>
                            @endif
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código Pago</th>
                                                    <th scope="col">Pago</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablePayment">
                                                @foreach ($paymentConditions as $paymentCondition)
                                                    
                                                    <tr>
                                                        <th hidden="hidden">{{ $paymentCondition->id }}</th>
                                                        <th scope="row">{{ $paymentCondition->codePayment }}</th>
                                                        <td>{{ $paymentCondition->namePayment }}</td>
                                                    </tr>
                                                    
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    @endif
                </div> 
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        console.log("JQuery is working");

        $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        var nbrTable = document.getElementById("tableBank").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableBank").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="2"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen registros actuales</div></th>'+
            '</tr>';
        }

        var nbrTable = document.getElementById("tableCurrency").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableCurrency").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="2"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen registros actuales</div></th>'+
            '</tr>';
        }

        var nbrTable = document.getElementById("tablePayment").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tablePayment").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="2"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen registros actuales</div></th>'+
            '</tr>';
        }

        $('#codeBank').keypress(function(e){
            $('#codeBank').attr("maxlength", "7"); $('#codeBank').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "áéíóúabcdefghijklmnñopqrstuvwxyz0123456789";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#nameBank').keypress(function(e){
            $('#nameBank').attr("maxlength", "30"); $('#nameBank').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $("#cleanFieldsBank").click(function(e){
            $('#codeBank').val('');
            $('#nameBank').val('');
            $('#codeBank').attr("class", "form-control col-md-12 my-1");
            $('#nameBank').attr("class", "form-control col-md-12 my-1");
        });

        $('#codeCurrency').keypress(function(e){
            $('#codeCurrency').attr("maxlength", "4"); $('#codeCurrency').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#nameCurrency').keypress(function(e){
            $('#nameCurrency').attr("maxlength", "30"); $('#nameCurrency').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $("#cleanFieldsCurrency").click(function(e){
            $('#codeCurrency').val('');
            $('#nameCurrency').val('');
            $('#codeCurrency').attr("class", "form-control col-md-12 my-1");
            $('#nameCurrency').attr("class", "form-control col-md-12 my-1");
        });

        $('#codePayment').keypress(function(e){
            $('#codePayment').attr("maxlength", "4"); $('#codePayment').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "áéíóúabcdefghijklmnñopqrstuvwxyz0123654789";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#namePayment').keypress(function(e){
            $('#namePayment').attr("maxlength", "30"); $('#namePayment').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $("#cleanFieldsPayment").click(function(e){
            $('#codePayment').val('');
            $('#namePayment').val('');
            $('#codePayment').attr("class", "form-control col-md-12 my-1");
            $('#namePayment').attr("class", "form-control col-md-12 my-1");
        });

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })

        $("#saveBank").click(function(e){
            e.preventDefault();
            var codeBank = $('#codeBank').val();
            var nameBank = $('#nameBank').val();
            if ($('#codeBank').val() == "" || $('#nameBank').val() == "" || $('#codeBank').val().length < 5 || $('#nameBank').val().length < 5) {
                alert("Introduzca datos");
                if (codeBank == "" || codeBank.length < 5) { alert("Código de banco requerido"); $('#codeBank').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameBank == "" || nameBank.length < 5) { alert("Nombre de banco requerido"); $('#nameBank').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                $('#codeBank').val('');
                $('#nameBank').val('');
            } else {
                $.ajax({
                    url : "{{ route('financeMaintenance.checkBank') }}",
                    type : 'POST',
                    data : { codeBank, nameBank },
                    success : function(response){
                        console.log(response);
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/financeMaintenance/index"); 
                    }
                })
            }
        });

        $("#saveCurrency").click(function(e){
            e.preventDefault();
            var codeCurrency = $('#codeCurrency').val();
            var nameCurrency = $('#nameCurrency').val();
            if ($('#codeCurrency').val() == "" || $('#nameCurrency').val() == "" || $('#codeCurrency').val().length < 2 || $('#nameCurrency').val().length < 5) {
                alert("Introduzca datos");
                if (codeCurrency == "" || codeCurrency.length < 2) { alert("Código de moneda requerido"); $('#codeCurrency').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameCurrency == "" || nameCurrency.length < 5) { alert("Nombre de moneda requerido"); $('#nameCurrency').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                $('#codeCurrency').val('');
                $('#nameCurrency').val('');
            } else {
                $.ajax({
                    url : "{{ route('financeMaintenance.checkCurrency') }}",
                    type : 'POST',
                    data : { codeCurrency, nameCurrency },
                    success : function(response){
                        console.log(response);
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/financeMaintenance/index"); 
                    }
                })
            }
        });

        $("#savePayment").click(function(e){
            e.preventDefault();
            var codePayment = $('#codePayment').val();
            var namePayment = $('#namePayment').val();
            if ($('#codePayment').val() == "" || $('#namePayment').val() == "" || $('#codePayment').val().length < 3 || $('#namePayment').val().length < 5) {
                alert("Introduzca datos");
                if (codePayment == "" || codePayment.length < 2) { alert("Código de pago requerido"); $('#codePayment').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (namePayment == "" || namePayment.length < 5) { alert("Nombre de pago requerido"); $('#namePayment').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                $('#codePayment').val('');
                $('#namePayment').val('');
            } else {
                $.ajax({
                    url : "{{ route('financeMaintenance.checkPayment') }}",
                    type : 'POST',
                    data : { codePayment, namePayment },
                    success : function(response){
                        console.log(response);
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/financeMaintenance/index"); 
                    }
                })
            }
        });
    });
</script>
@endsection('scripts')
