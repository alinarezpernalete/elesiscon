@extends('layouts.app')

@section('title', 'Reporte')

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
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Horas por usuario</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="employee"> 
                                    <option selected="" disabled="" value="0">Seleccione usuario</option> 
                                    @foreach ( $employees as $employee )
                                    <option value="{{ $employee->id }}">{{ $employee->firstNameEmployee }} {{ $employee->lastNameEmployee }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"> 
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Desde" id="sinceByUser">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Hasta" id="untilByUser">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byUser">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByUser">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Horas por proyecto</p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="project"> 
                                    <option selected="" disabled="" value="0">Seleccione proyecto</option> 
                                    @foreach ( $projects as $project )
                                    <option value="{{ $project->id }}">{{ $project->codeProject }} {{ $project->nameProject }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"> 
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Desde" id="sinceByProject">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Hasta" id="untilByProject">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byProject">Imprimir</a>
                            </div>
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byGraphic">Productividad en grafico</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByProject">Limpiar campos</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div id="myTabContent" class="tab-content">
                    
                </div> 
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        console.log("JQuery is working");
        $("#cleanFieldsByUser").click(function(e){
            $("#employee").val(0);
            $("#sinceByUser").val('');
            $("#untilByUser").val('');
        });
        $("#byUser").click(function(e){
            if ($("#employee").val() == null || $("#sinceByUser").val() == "" || $("#untilByUser").val() == "") {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byUser').attr('href', "/hmReport/byUser?employee="+$("#employee").val()+"&since="+$("#sinceByUser").val()+"&until="+$("#untilByUser").val());
            }
        });
        $("#cleanFieldsByProject").click(function(e){
            $("#project").val(0);
            $("#sinceByProject").val('');
            $("#untilByProject").val('');
        });
        $("#byProject").click(function(e){
            if ($("#project").val() == null || $("#sinceByProject").val() == "" || $("#untilByProject").val() == "") {
                alert("Debe seleccionar un proyecto y un rango de fechas");
            } else {
                $('#byProject').attr('href', "/hmReport/byProject?project="+$("#project").val()+"&since="+$("#sinceByProject").val()+"&until="+$("#untilByProject").val());
            }
        });
        $("#byGraphic").click(function(e){
            if ($("#project").val() == null || $("#sinceByProject").val() == "" || $("#untilByProject").val() == "") {
                alert("Debe seleccionar un proyecto y un rango de fechas");
            } else {
                $('#byGraphic').attr('href', "/hmReport/byGraphic?project="+$("#project").val()+"&since="+$("#sinceByProject").val()+"&until="+$("#untilByProject").val());
            }
        });
    });
</script>
@endsection('scripts')
