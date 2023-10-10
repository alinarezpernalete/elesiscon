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
                                <p class="font-weight-bold">Clientes por fecha</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"> 
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Desde" id="sinceByDate">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Hasta" id="untilByDate">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byDate">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByDate">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Clientes por status</p>
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
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByDate").click(function(e){
            $("#sinceByDate").val('');
            $("#untilByDate").val('');
        });
        $("#byDate").click(function(e){
            if ($("#sinceByDate").val() == "" || $("#untilByDate").val() == "") {
                alert("Debe seleccionar un rango de fechas");
            } else {
                $('#byDate').attr('href', "/custReport/byDate?since="+$("#sinceByDate").val()+"&until="+$("#untilByDate").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsbyStatus").click(function(e){
            $("#status").val(-1);
        });
        $("#byStatus").click(function(e){
            if ($("#status").val() == null) {
                alert("Debe seleccionar un status");
            } else {
                $('#byStatus').attr('href', "/custReport/byStatus?status="+$("#status").val());
            }
        });
    });
</script>
@endsection('scripts')
