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
                                    @if($filterSearch == "" || $filterSearch == "codeDepartment" || $filterSearch == "nameDepartment")
                                        <li class="nav-item">
                                            <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-departamentos">Departamentos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-cargos">Cargos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-proyectos">Proyectos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-actividades">Actividades</a>
                                        </li>
                                    @endif
                                    @if($filterSearch == "codeJob" || $filterSearch == "nameJob")
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-departamentos">Departamentos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-cargos">Cargos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-proyectos">Proyectos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-actividades">Actividades</a>
                                        </li>
                                    @endif
                                    @if($filterSearch == "codeProject" || $filterSearch == "nameProject")
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-departamentos">Departamentos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-cargos">Cargos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-proyectos">Proyectos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-actividades">Actividades</a>
                                        </li>
                                    @endif
                                    @if($filterSearch == "codeActivity" || $filterSearch == "nameActivity")
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-departamentos">Departamentos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-cargos">Cargos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#listar-proyectos">Proyectos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-actividades">Actividades</a>
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
                    @if($filterSearch == "" || $filterSearch == "codeDepartment" || $filterSearch == "nameDepartment")
                        <div class="tab-pane fade active show" id="listar-departamentos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeDepartment" class="form-control col-md-12 my-1" placeholder="Código departamento">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameDepartment" class="form-control col-md-12 my-1" placeholder="Nombre departamento">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveDepartment">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsDepartment">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeDepartment">Código departamento</option>
                                                    <option value="nameDepartment">Departamento</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código departamento</th>
                                                        <th scope="col">Departamento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableDepartment">
                                                    @foreach ($departments as $department)
                                                        <tr>
                                                            <th hidden="hidden">{{ $department->id }}</th>
                                                            <th scope="row">{{ $department->codeDepartment }}</th>
                                                            <td>{{ $department->nameDepartment }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-cargos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeJob" class="form-control col-md-12 my-1" placeholder="Código cargo">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameJob" class="form-control col-md-12 my-1" placeholder="Nombre cargo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveJob">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsJob">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeJob">Código cargo</option>
                                                    <option value="nameJob">Cargo</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código cargo</th>
                                                        <th scope="col">Cargo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableJob">
                                                    @foreach ($jobs as $job)
                                                        <tr>
                                                            <th hidden="hidden">{{ $job->id }}</th>
                                                            <th scope="row">{{ $job->codeJob }}</th>
                                                            <td>{{ $job->nameJob }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-proyectos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeProject" class="form-control col-md-12 my-1" placeholder="Código proyecto">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameProject" class="form-control col-md-12 my-1" placeholder="Nombre proyecto">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveProject">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsProject">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeProject">Código proyecto</option>
                                                    <option value="nameProject">Proyecto</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código proyecto</th>
                                                        <th scope="col">Proyecto</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableProject">
                                                    @foreach ($projects as $project)
                                                        <tr>
                                                            <th hidden="hidden">{{ $project->id }}</th>
                                                            <th scope="row">{{ $project->codeProject }}</th>
                                                            <td>{{ $project->nameProject }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-actividades">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeActivity" class="form-control col-md-12 my-1" placeholder="Código actividad">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameActivity" class="form-control col-md-12 my-1" placeholder="Nombre actividad">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveActivity">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsActivity">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeActivity">Código actividad</option>
                                                    <option value="nameActivity">Actividad</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código actividad</th>
                                                        <th scope="col">Actividad</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableActivity">
                                                    @foreach ($activities as $activity)
                                                        <tr>
                                                            <th hidden="hidden">{{ $activity->id }}</th>
                                                            <th scope="row">{{ $activity->codeActivity }}</th>
                                                            <td>{{ $activity->nameActivity }}</td>
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
                    @if($filterSearch == "codeJob" || $filterSearch == "nameJob")
                        <div class="tab-pane fade show" id="listar-departamentos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeDepartment" class="form-control col-md-12 my-1" placeholder="Código departamento">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameDepartment" class="form-control col-md-12 my-1" placeholder="Nombre departamento">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveDepartment">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsDepartment">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeDepartment">Código departamento</option>
                                                    <option value="nameDepartment">Departamento</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código departamento</th>
                                                        <th scope="col">Departamento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableDepartment">
                                                    @foreach ($departments as $department)
                                                        <tr>
                                                            <th hidden="hidden">{{ $department->id }}</th>
                                                            <th scope="row">{{ $department->codeDepartment }}</th>
                                                            <td>{{ $department->nameDepartment }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="listar-cargos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeJob" class="form-control col-md-12 my-1" placeholder="Código cargo">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameJob" class="form-control col-md-12 my-1" placeholder="Nombre cargo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveJob">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsJob">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeJob">Código cargo</option>
                                                    <option value="nameJob">Cargo</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código cargo</th>
                                                        <th scope="col">Cargo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableJob">
                                                    @foreach ($jobs as $job)
                                                        <tr>
                                                            <th hidden="hidden">{{ $job->id }}</th>
                                                            <th scope="row">{{ $job->codeJob }}</th>
                                                            <td>{{ $job->nameJob }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-proyectos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeProject" class="form-control col-md-12 my-1" placeholder="Código proyecto">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameProject" class="form-control col-md-12 my-1" placeholder="Nombre proyecto">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveProject">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsProject">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeProject">Código proyecto</option>
                                                    <option value="nameProject">Proyecto</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código proyecto</th>
                                                        <th scope="col">Proyecto</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableProject">
                                                    @foreach ($projects as $project)
                                                        <tr>
                                                            <th hidden="hidden">{{ $project->id }}</th>
                                                            <th scope="row">{{ $project->codeProject }}</th>
                                                            <td>{{ $project->nameProject }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-actividades">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeActivity" class="form-control col-md-12 my-1" placeholder="Código actividad">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameActivity" class="form-control col-md-12 my-1" placeholder="Nombre actividad">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveActivity">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsActivity">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeActivity">Código actividad</option>
                                                    <option value="nameActivity">Actividad</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código actividad</th>
                                                        <th scope="col">Actividad</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableActivity">
                                                    @foreach ($activities as $activity)
                                                        <tr>
                                                            <th hidden="hidden">{{ $activity->id }}</th>
                                                            <th scope="row">{{ $activity->codeActivity }}</th>
                                                            <td>{{ $activity->nameActivity }}</td>
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
                    @if($filterSearch == "codeProject" || $filterSearch == "nameProject")
                        <div class="tab-pane fade show" id="listar-departamentos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeDepartment" class="form-control col-md-12 my-1" placeholder="Código departamento">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameDepartment" class="form-control col-md-12 my-1" placeholder="Nombre departamento">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveDepartment">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsDepartment">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeDepartment">Código departamento</option>
                                                    <option value="nameDepartment">Departamento</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código departamento</th>
                                                        <th scope="col">Departamento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableDepartment">
                                                    @foreach ($departments as $department)
                                                        <tr>
                                                            <th hidden="hidden">{{ $department->id }}</th>
                                                            <th scope="row">{{ $department->codeDepartment }}</th>
                                                            <td>{{ $department->nameDepartment }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-cargos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeJob" class="form-control col-md-12 my-1" placeholder="Código cargo">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameJob" class="form-control col-md-12 my-1" placeholder="Nombre cargo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveJob">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsJob">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeJob">Código cargo</option>
                                                    <option value="nameJob">Cargo</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código cargo</th>
                                                        <th scope="col">Cargo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableJob">
                                                    @foreach ($jobs as $job)
                                                        <tr>
                                                            <th hidden="hidden">{{ $job->id }}</th>
                                                            <th scope="row">{{ $job->codeJob }}</th>
                                                            <td>{{ $job->nameJob }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="listar-proyectos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeProject" class="form-control col-md-12 my-1" placeholder="Código proyecto">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameProject" class="form-control col-md-12 my-1" placeholder="Nombre proyecto">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveProject">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsProject">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeProject">Código proyecto</option>
                                                    <option value="nameProject">Proyecto</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código proyecto</th>
                                                        <th scope="col">Proyecto</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableProject">
                                                    @foreach ($projects as $project)
                                                        <tr>
                                                            <th hidden="hidden">{{ $project->id }}</th>
                                                            <th scope="row">{{ $project->codeProject }}</th>
                                                            <td>{{ $project->nameProject }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-actividades">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeActivity" class="form-control col-md-12 my-1" placeholder="Código actividad">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameActivity" class="form-control col-md-12 my-1" placeholder="Nombre actividad">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveActivity">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsActivity">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeActivity">Código actividad</option>
                                                    <option value="nameActivity">Actividad</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código actividad</th>
                                                        <th scope="col">Actividad</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableActivity">
                                                    @foreach ($activities as $activity)
                                                        <tr>
                                                            <th hidden="hidden">{{ $activity->id }}</th>
                                                            <th scope="row">{{ $activity->codeActivity }}</th>
                                                            <td>{{ $activity->nameActivity }}</td>
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
                    @if($filterSearch == "codeActivity" || $filterSearch == "nameActivity")
                        <div class="tab-pane fade show" id="listar-departamentos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeDepartment" class="form-control col-md-12 my-1" placeholder="Código departamento">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameDepartment" class="form-control col-md-12 my-1" placeholder="Nombre departamento">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveDepartment">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsDepartment">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeDepartment">Código departamento</option>
                                                    <option value="nameDepartment">Departamento</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código departamento</th>
                                                        <th scope="col">Departamento</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableDepartment">
                                                    @foreach ($departments as $department)
                                                        <tr>
                                                            <th hidden="hidden">{{ $department->id }}</th>
                                                            <th scope="row">{{ $department->codeDepartment }}</th>
                                                            <td>{{ $department->nameDepartment }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-cargos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeJob" class="form-control col-md-12 my-1" placeholder="Código cargo">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameJob" class="form-control col-md-12 my-1" placeholder="Nombre cargo">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveJob">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsJob">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeJob">Código cargo</option>
                                                    <option value="nameJob">Cargo</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código cargo</th>
                                                        <th scope="col">Cargo</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableJob">
                                                    @foreach ($jobs as $job)
                                                        <tr>
                                                            <th hidden="hidden">{{ $job->id }}</th>
                                                            <th scope="row">{{ $job->codeJob }}</th>
                                                            <td>{{ $job->nameJob }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade show" id="listar-proyectos">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeProject" class="form-control col-md-12 my-1" placeholder="Código proyecto">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameProject" class="form-control col-md-12 my-1" placeholder="Nombre proyecto">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveProject">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsProject">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeProject">Código proyecto</option>
                                                    <option value="nameProject">Proyecto</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código proyecto</th>
                                                        <th scope="col">Proyecto</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableProject">
                                                    @foreach ($projects as $project)
                                                        <tr>
                                                            <th hidden="hidden">{{ $project->id }}</th>
                                                            <th scope="row">{{ $project->codeProject }}</th>
                                                            <td>{{ $project->nameProject }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade active show" id="listar-actividades">
                            <div class="form-group mt-3">
                                @if(Auth::user()->name == "Administrador")
                                <div class="row">
                                    <div class="col"> 
                                        <input type="text" id="codeActivity" class="form-control col-md-12 my-1" placeholder="Código actividad">
                                    </div>
                                    <div class="col"> 
                                        <input type="text" id="nameActivity" class="form-control col-md-12 my-1" placeholder="Nombre actividad">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-3"> 
                                        <button class="btn btn-primary col" id="saveActivity">Guardar</button>
                                    </div>
                                    <div class="col mt-3"> 
                                        <button class="btn btn-warning col" id="cleanFieldsActivity">Limpiar campos</button>
                                    </div>
                                </div>
                                @endif
                                <hr class="my-4">
                                <div class="row">
                                    <div class="col"> 
                                        <form action="/managementMaintenance/index" method="GET">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                                
                                                <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                    <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                    <option value="codeActivity">Código actividad</option>
                                                    <option value="nameActivity">Actividad</option>
                                                </select>

                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                    <button class="btn btn-outline-secondary" href="/managementMaintenance/index" id="clean">Limpiar</button>
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
                                                        <th scope="col">Código actividad</th>
                                                        <th scope="col">Actividad</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableActivity">
                                                    @foreach ($activities as $activity)
                                                        <tr>
                                                            <th hidden="hidden">{{ $activity->id }}</th>
                                                            <th scope="row">{{ $activity->codeActivity }}</th>
                                                            <td>{{ $activity->nameActivity }}</td>
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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        /*$(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
            let elmDep = document.getElementById('listar-departamentos');
            let elmCar = document.getElementById('listar-cargos');
            let elmPro = document.getElementById('listar-proyectos');
            let elmAct = document.getElementById('listar-actividades');
            
            if (elmDep.className.indexOf('active') > -1) {
              $('#listar-departamentos').attr("class", "tab-pane fade active show");
            } else {
              alert("false");
            }
            if (elmCar.className.indexOf('active') > -1) {
              $('#listar-cargos').attr("class", "tab-pane fade active show");
            } else {
              alert("false");
            }
            if (elmPro.className.indexOf('active') > -1) {
              $('#listar-proyectos').attr("class", "tab-pane fade active show");
            } else {
              alert("false");
            }
            if (elmAct.className.indexOf('active') > -1) {
              $('#listar-actividades').attr("class", "tab-pane fade active show");
            } else {
              alert("false");
            }
        })*/

                $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#codeDepartment').keypress(function(e){
            $('#codeDepartment').attr("maxlength", "10"); $('#codeDepartment').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "áéíóúabcdefghijklmnñopqrstuvwxyz_-";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#nameDepartment').keypress(function(e){
            $('#nameDepartment').attr("maxlength", "25"); $('#nameDepartment').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#codeJob').keypress(function(e){
            $('#codeJob').attr("maxlength", "12"); $('#codeJob').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "áéíóúabcdefghijklmnñopqrstuvwxyz_-";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#nameJob').keypress(function(e){
            $('#nameJob').attr("maxlength", "30"); $('#nameJob').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#codeProject').keypress(function(e){
            $('#codeProject').attr("maxlength", "12"); $('#codeProject').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "áéíóúabcdefghijklmnñopqrstuvwxyz_1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#nameProject').keypress(function(e){
            $('#nameProject').attr("maxlength", "45"); $('#nameProject').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#codeActivity').keypress(function(e){
            $('#codeActivity').attr("maxlength", "6"); $('#codeActivity').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "1234567890.";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#nameActivity').keypress(function(e){
            $('#nameActivity').attr("maxlength", "50"); $('#nameActivity').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $("#cleanFieldsDepartment").click(function(e){
            $('#codeDepartment').val('');
            $('#nameDepartment').val('');
            $('#codeDepartment').attr("class", "form-control col-md-12 my-1");
            $('#nameDepartment').attr("class", "form-control col-md-12 my-1");
        });

        $("#cleanFieldsJob").click(function(e){
            $('#codeJob').val('');
            $('#nameJob').val('');
            $('#codeJob').attr("class", "form-control col-md-12 my-1");
            $('#nameJob').attr("class", "form-control col-md-12 my-1");
        });

        $("#cleanFieldsProject").click(function(e){
            $('#codeProject').val('');
            $('#nameProject').val('');
            $('#codeProject').attr("class", "form-control col-md-12 my-1");
            $('#nameProject').attr("class", "form-control col-md-12 my-1");
        });

        $("#cleanFieldsActivity").click(function(e){
            $('#codeActivity').val('');
            $('#nameActivity').val('');
            $('#codeActivity').attr("class", "form-control col-md-12 my-1");
            $('#nameActivity').attr("class", "form-control col-md-12 my-1");
        });

        $("#saveDepartment").click(function(e){
            e.preventDefault();
            var codeDepartment = $('#codeDepartment').val();
            var nameDepartment = $('#nameDepartment').val();
            if ($('#codeDepartment').val() == "" || $('#nameDepartment').val() == "" || $('#codeDepartment').val().length < 7 || $('#nameDepartment').val().length < 5) {
                alert("Introduzca datos");
                if (codeDepartment == "" || codeDepartment.length < 7) { alert("Código de departamento requerido"); $('#codeDepartment').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameDepartment == "" || nameDepartment.length < 5) { alert("Nombre de departamento requerido"); $('#nameDepartment').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                $('#codeDepartment').val('');
                $('#nameDepartment').val('');
            } else {
                $.ajax({
                    url : "{{ route('managementMaintenance.checkDepartment') }}",
                    type : 'POST',
                    data : { codeDepartment, nameDepartment },
                    success : function(response){
                        console.log(response);
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/managementMaintenance/index"); 
                    }
                })
            }
        });

        $("#saveJob").click(function(e){
            e.preventDefault();
            var codeJob = $('#codeJob').val();
            var nameJob = $('#nameJob').val();
            if ($('#codeJob').val() == "" || $('#nameJob').val() == "" || $('#codeJob').val().length < 10 || $('#nameJob').val().length < 5) {
                alert("Introduzca datos");
                if (codeJob == "" || codeJob.length < 10) { alert("Código de cargo requerido"); $('#codeJob').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameJob == "" || nameJob.length < 5) { alert("Nombre de cargo requerido"); $('#nameJob').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                $('#codeJob').val('');
                $('#nameJob').val('');
            } else {
                $.ajax({
                    url : "{{ route('managementMaintenance.checkJob') }}",
                    type : 'POST',
                    data : { codeJob, nameJob },
                    success : function(response){
                        console.log(response);
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/managementMaintenance/index"); 
                    }
                })
            }
        });

        $("#saveProject").click(function(e){
            e.preventDefault();
            var codeProject = $('#codeProject').val();
            var nameProject = $('#nameProject').val();
            if ($('#codeProject').val() == "" || $('#nameProject').val() == "" || $('#codeProject').val().length < 10 || $('#nameProject').val().length < 5) {
                alert("Introduzca datos");
                if (codeProject == "" || codeProject.length < 10) { alert("Código de proyecto requerido"); $('#codeProject').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameProject == "" || nameProject.length < 5) { alert("Nombre de proyecto requerido"); $('#nameProject').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                $('#codeProject').val('');
                $('#nameProject').val('');
            } else {
                $.ajax({
                    url : "{{ route('managementMaintenance.checkProject') }}",
                    type : 'POST',
                    data : { codeProject, nameProject },
                    success : function(response){
                        console.log(response);
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/managementMaintenance/index"); 
                    }
                })
            }
        });

        $("#saveActivity").click(function(e){
            e.preventDefault();
            var codeActivity = $('#codeActivity').val();
            var nameActivity = $('#nameActivity').val();
            if ($('#codeActivity').val() == "" && $('#nameActivity').val() == "" || $('#codeActivity').val().length < 5 || $('#nameActivity').val().length < 5) {
                alert("Introduzca datos");
                if (codeActivity == "" || codeActivity.length < 5) { alert("Código de actividad requerido"); $('#codeActivity').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameActivity == "" || nameActivity.length < 5) { alert("Nombre de actividad requerido"); $('#nameActivity').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                $('#codeActivity').val('');
                $('#nameActivity').val('');
            } else {
                $.ajax({
                    url : "{{ route('managementMaintenance.checkActivity') }}",
                    type : 'POST',
                    data : { codeActivity, nameActivity },
                    success : function(response){
                        console.log(response);
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/managementMaintenance/index"); 
                    }
                })
            }
        });
        //SI LE DOY EN CLEAN QUE NO ME REDIRIJA A LA DIRECCION SINO QUE ME CARGUE LOS DATOS EN TABLA
    });
</script>
@endsection('scripts')
