@extends('layouts.app')

@section('title', 'Control de horas')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#llenar-ctrl-hrs">Llenar control de horas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#validar-ctrl-hrs">Validación</a>
                                    </li> 
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
                    <div class="tab-pane fade active show" id="llenar-ctrl-hrs">
                        <div class="form-group mt-2">
                            <div class="row">
                                
                                <input type="text" id="employeeTimeControl" class="form-control col-md-12 my-1" hidden="hidden" value="{{ auth()->user()->id }}">

                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="projectTimeControlDetail">
                                        <option selected="" disabled="" value="0">Seleccione proyecto</option>
                                        @foreach ( $projects as $project )
                                            <option value="{{ $project->id }}">{{ $project->codeProject }} - {{ $project->nameProject }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="activityTimeControlDetail">
                                        <option selected="" disabled="" value="0">Seleccione actividad</option>
                                        @foreach ( $activities as $activity )
                                            <option value="{{ $activity->id }}">{{ $activity->codeActivity}} - {{ $activity->nameActivity }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Horas" id="hoursTimeControlDetail">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control col-md-12 my-1" id="dateTimeControlDetail">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control col-md-12 my-1" rows="3" placeholder="Descripción" id="descriptionTimeControlDetail" maxlength="180"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" id="saveHours">Listar horas</button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="alert alert-secondary mb-2 row mx-auto w-100 justify-content-center" role="alert" id="codeTimeControl"></div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th hidden="hidden">ID</th>
                                                    <th scope="col">Proyecto</th>
                                                    <th scope="col">Actividad</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Horas</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableHours">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-secondary mb-2 row mx-auto w-100 justify-content-center" role="alert" id="hours">Horas de la semana: </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" disabled="" id="updateValidated">Listar para validación</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!------------------------------------------------------------------------------------>
                    @include('modals.timeControl.modal-select-employee')
                    <div class="tab-pane fade" id="validar-ctrl-hrs">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" data-toggle="modal" data-target="#modal-select-employee">Empleados</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col">
                                    <input class="form-control mb-3" type="text" placeholder="CI" readonly>
                                </div>
                                <div class="col">
                                    <input class="form-control mb-3" type="text" placeholder="Empleado" readonly>
                                </div>
                                <div class="col">
                                    <input class="form-control mb-3" type="text" placeholder="Departamento" readonly>
                                </div>
                                <div class="col">
                                    <input class="form-control mb-3" type="text" placeholder="Días y horas trabajadas" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Proyecto</th>
                                                    <th scope="col">Actividad</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Horas</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableEmployee">
                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------------------------------>
                </div>
            </div>
        </div>
        <!-- -->
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
       
    });
</script>
@endsection('scripts')
