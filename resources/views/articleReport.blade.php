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
                                <p class="font-weight-bold">Actividad por fecha</p>
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
                                <p class="font-weight-bold">Actividad por artículo</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="article"> 
                                    <option selected="" disabled="" value="0">Seleccione artículo</option> 
                                    @foreach ( $articles as $article )
                                    <option value="{{ $article->id }}">{{ $article->codeArticle }} - {{ $article->nameArticle }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"> 
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Desde" id="sinceByArticle">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Hasta" id="untilByArticle">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byArticle">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByArticle">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Artículos por línea</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="line"> 
                                    <option selected="" disabled="" value="0">Seleccione línea</option> 
                                    @foreach ( $lines as $line )
                                    <option value="{{ $line->id }}">{{ $line->codeLine }} - {{ $line->nameLine }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byLine">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByLine">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Artículos por sublínea</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="subline"> 
                                    <option selected="" disabled="" value="0">Seleccione sublínea</option> 
                                    @foreach ( $sublines as $subline )
                                    <option value="{{ $subline->id }}">{{ $subline->codeSubline }} - {{ $subline->nameSubline }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="bySubline">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsBySubline">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Artículos por grupo</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="group"> 
                                    <option selected="" disabled="" value="0">Seleccione grupo</option> 
                                    @foreach ( $groups as $group )
                                    <option value="{{ $group->id }}">{{ $group->codeGroup }} - {{ $group->nameGroup }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byGroup">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByGroup">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Artículos por origen</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="origin"> 
                                    <option selected="" disabled="" value="0">Seleccione origen</option> 
                                    @foreach ( $origins as $origin )
                                    <option value="{{ $origin->id }}">{{ $origin->codeOrigin }} - {{ $origin->nameOrigin }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byOrigin">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByOrigin">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Artículos por tipo</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="type"> 
                                    <option selected="" disabled="" value="0">Seleccione tipo</option> 
                                    @foreach ( $types as $type )
                                    <option value="{{ $type->id }}">{{ $type->codeType }} - {{ $type->nameType }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byType">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByType">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Artículos por proveedor</p>
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
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byProvider">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByProvider">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">Artículos por status</p>
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
                $('#byDate').attr('href', "/articleReport/byDate?since="+$("#sinceByDate").val()+"&until="+$("#untilByDate").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByArticle").click(function(e){
            $("#article").val(0);
            $("#sinceByArticle").val('');
            $("#untilByArticle").val('');
        });
        $("#byArticle").click(function(e){
            if ($("#article").val() == null || $("#sinceByArticle").val() == "" || $("#untilByArticle").val() == "") {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byArticle').attr('href', "/articleReport/byArticle?article="+$("#article").val()+"&since="+$("#sinceByArticle").val()+"&until="+$("#untilByArticle").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByLine").click(function(e){
            $("#line").val(0);
        });
        $("#byLine").click(function(e){
            if ($("#line").val() == null) {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byLine').attr('href', "/articleReport/byLine?line="+$("#line").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsBySubline").click(function(e){
            $("#subline").val(0);
        });
        $("#bySubline").click(function(e){
            if ($("#subline").val() == null) {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#bySubline').attr('href', "/articleReport/bySubline?subline="+$("#subline").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByGroup").click(function(e){
            $("#group").val(0);
        });
        $("#byGroup").click(function(e){
            if ($("#group").val() == null) {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byGroup').attr('href', "/articleReport/byGroup?group="+$("#group").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByOrigin").click(function(e){
            $("#origin").val(0);
        });
        $("#byOrigin").click(function(e){
            if ($("#origin").val() == null) {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byOrigin').attr('href', "/articleReport/byOrigin?origin="+$("#origin").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByType").click(function(e){
            $("#type").val(0);
        });
        $("#byType").click(function(e){
            if ($("#type").val() == null) {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byType').attr('href', "/articleReport/byType?type="+$("#type").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByProvider").click(function(e){
            $("#provider").val(0);
        });
        $("#byProvider").click(function(e){
            if ($("#provider").val() == null) {
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byProvider').attr('href', "/articleReport/byProvider?provider="+$("#provider").val());
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
                alert("Debe seleccionar un empleado y un rango de fechas");
            } else {
                $('#byStatus').attr('href', "/articleReport/byStatus?status="+$("#status").val());
            }
        });
    });
</script>
@endsection('scripts')
