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
                                <p class="font-weight-bold">Notas de recepción por fecha</p>
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
                                <p class="font-weight-bold">Notas de recepción por usuario</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="user"> 
                                    <option selected="" disabled="" value="0">Seleccione usuario</option> 
                                    @foreach ( $users as $user )
                                    <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
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
                                <p class="font-weight-bold">Notas de recepción por proveedor</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="provider"> 
                                    <option selected="" disabled="" value="0">Seleccione proveedor</option> 
                                    @foreach ( $providers as $provider )
                                    <option value="{{ $provider->id }}">{{ $provider->codeProvider }} - {{ $provider->nameProvider }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"> 
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Desde" id="sinceByProvider">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Hasta" id="untilByProvider">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byProvider">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByProvider">Limpiar campos</button>
                            </div>
                        </div>
                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Notas de recepción cancelados</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"> 
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Desde" id="sinceByCancel">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Hasta" id="untilByCancel">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byCancel">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByCancel">Limpiar campos</button>
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
                $('#byDate').attr('href', "/recNoteReport/byDate?since="+$("#sinceByDate").val()+"&until="+$("#untilByDate").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByUser").click(function(e){
            $("#user").val(0);
            $("#sinceByUser").val('');
            $("#untilByUser").val('');
        });
        $("#byUser").click(function(e){
            if ($("#user").val() == null || $("#sinceByUser").val() == "" || $("#untilByUser").val() == "") {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byUser').attr('href', "/recNoteReport/byUser?user="+$("#user").val()+"&since="+$("#sinceByUser").val()+"&until="+$("#untilByUser").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByProvider").click(function(e){
            $("#provider").val(0);
            $("#sinceByProvider").val('');
            $("#untilByProvider").val('');
        });
        $("#byProvider").click(function(e){
            if ($("#provider").val() == null || $("#sinceByProvider").val() == "" || $("#untilByProvider").val() == "") {
                alert("Debe seleccionar un cliente y un rango de fechas");
            } else {
                $('#byProvider').attr('href', "/recNoteReport/byProvider?provider="+$("#provider").val()+"&since="+$("#sinceByProvider").val()+"&until="+$("#untilByProvider").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByCancel").click(function(e){
            $("#sinceByCancel").val('');
            $("#untilByCancel").val('');
        });
        $("#byCancel").click(function(e){
            if ($("#sinceByCancel").val() == "" || $("#untilByCancel").val() == "") {
                alert("Debe seleccionar un rango de fechas");
            } else {
                $('#byCancel').attr('href', "/recNoteReport/byCancel?typePurchase=4&since="+$("#sinceByCancel").val()+"&until="+$("#untilByCancel").val());
            }
        });
    });
</script>
@endsection('scripts')
