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
                                <p class="font-weight-bold">CP por fecha</p>
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
                                <p class="font-weight-bold">CP por banco</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="bank"> 
                                    <option selected="" disabled="" value="0">Seleccione banco</option> 
                                    @foreach ( $banks as $bank )
                                    <option value="{{ $bank->id }}">{{ $bank->codeBank }} - {{ $bank->nameBank }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"> 
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Desde" id="sinceByBank">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Hasta" id="untilByBank">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byBank">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByBank">Limpiar campos</button>
                            </div>
                        </div>

                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">CP por moneda</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <select class="browser-default custom-select col-md-12 my-1" id="currency"> 
                                    <option selected="" disabled="" value="0">Seleccione moneda</option> 
                                    @foreach ( $currencies as $currency )
                                    <option value="{{ $currency->id }}">{{ $currency->codeCurrency }} - {{ $currency->nameCurrency }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"> 
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Desde" id="sinceByCurrency">
                            </div>
                            <div class="col">
                                <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Hasta" id="untilByCurrency">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <a href="#" class="btn btn-outline-success col-md-12 mx-auto mt-2 btn-block" id="byCurrency">Imprimir</a>
                            </div>
                            <div class="col"> 
                                <button class="btn btn-warning mx-auto mt-2 btn-block" id="cleanFieldsByCurrency">Limpiar campos</button>
                            </div>
                        </div>
                        
                        <hr class="my-4">
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold">CP por proveedor</p>
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
                $('#byDate').attr('href', "/APReport/byDate?since="+$("#sinceByDate").val()+"&until="+$("#untilByDate").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByBank").click(function(e){
            $("#bank").val(0);
            $("#sinceByBank").val('');
            $("#untilByBank").val('');
        });
        $("#byBank").click(function(e){
            if ($("#bank").val() == null || $("#sinceByBank").val() == "" || $("#untilByBank").val() == "") {
                alert("Debe seleccionar un banco y un rango de fechas");
            } else {
                $('#byBank').attr('href', "/APReport/byBank?bank="+$("#bank").val()+"&since="+$("#sinceByBank").val()+"&until="+$("#untilByBank").val());
            }
        });
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $("#cleanFieldsByCurrency").click(function(e){
            $("#currency").val(0);
            $("#sinceByCurrency").val('');
            $("#untilByCurrency").val('');
        });
        $("#byCurrency").click(function(e){
            if ($("#currency").val() == null || $("#sinceByCurrency").val() == "" || $("#untilByCurrency").val() == "") {
                alert("Debe seleccionar una moneda y un rango de fechas");
            } else {
                $('#byCurrency').attr('href', "/APReport/byCurrency?currency="+$("#currency").val()+"&since="+$("#sinceByCurrency").val()+"&until="+$("#untilByCurrency").val());
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
            if ($("#sinceByProvider").val() == "" || $("#untilByProvider").val() == "") {
                alert("Debe seleccionar un proveedor y un rango de fechas");
            } else {
                $('#byProvider').attr('href', "/APReport/byProvider?provider="+$("#provider").val()+"&since="+$("#sinceByProvider").val()+"&until="+$("#untilByProvider").val());
            }
        });
    });
</script>
@endsection('scripts')
