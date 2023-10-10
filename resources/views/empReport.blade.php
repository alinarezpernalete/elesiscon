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
                                <p class="font-weight-bold">Empleados por departamento</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="department"> 
                                    <option selected="" disabled="" value="0">Seleccione departamento</option> 
                                    @foreach ( $departments as $department )
                                    <option value="{{ $department->id }}">{{ $department->codeDepartment }} - {{ $department->nameDepartment }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byDepartment">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsbyDepartment">Limpiar campos</button>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Empleados por cargo</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="job"> 
                                    <option selected="" disabled="" value="0">Seleccione cargo</option> 
                                    @foreach ( $jobs as $job )
                                    <option value="{{ $job->id }}">{{ $job->codeJob }} - {{ $job->nameJob }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byJob">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsbyJob">Limpiar campos</button>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Empleados por status</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="status"> 
                                    <option selected="" disabled="" value="-1">Seleccione status</option> 
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byStatus">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsbyStatus">Limpiar campos</button>
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
        $("#cleanFieldsbyDepartment").click(function(e){
            $("#department").val(0);
        });
        $("#cleanFieldsbyJob").click(function(e){
            $("#job").val(0);
        });
        $("#cleanFieldsbyStatus").click(function(e){
            $("#status").val(-1);
        });
        $("#byDepartment").click(function(e){
            if ($("#department").val() == null) {
                alert("Debe seleccionar un departamento");
            } else {
                $('#byDepartment').attr('href', "/empReport/byDepartment?department="+$("#department").val());
            }
        });
        $("#byJob").click(function(e){
            if ($("#job").val() == null) {
                alert("Debe seleccionar un cargo");
            } else {
                $('#byJob').attr('href', "/empReport/byJob?job="+$("#job").val());
            }
        });
        $("#byStatus").click(function(e){
            if ($("#status").val() == null) {
                alert("Debe seleccionar un status");
            } else {
                $('#byStatus').attr('href', "/empReport/byStatus?status="+$("#status").val());
            }
        });
    });
</script>
@endsection('scripts')
