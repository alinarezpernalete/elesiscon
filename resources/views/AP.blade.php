@extends('layouts.app')

@section('title', 'Facturas pagadas')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-ap">Listar facturas pagadas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#generar-ap">Generar facturas pagadas</a>
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
                    <!---->
                    <div class="tab-pane fade active show" id="listar-ap">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/AP/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" value="">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codePurchase">Código</option>
                                                <option value="codeProvider">Proveedor</option>
                                                <option value="codeCurrency">Moneda</option>
                                                <option value="codeBank">Banco</option>
                                                <option value="codePayment">Pago</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/AP/index" id="clean">Limpiar</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Código</th>
                                                    <th scope="col">Doc.</th>
                                                    <th scope="col">Proveedor</th>
                                                    <th scope="col">Pago</th>
                                                    <th scope="col">Moneda</th>
                                                    <th scope="col">Banco</th>
                                                    <th scope="col">Monto</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableAP">
                                                @foreach ($APs as $AP)
                                                    @if($AP->amountAP == 0.00)
                                                        <tr>
                                                            <th hidden="hidden">{{ $AP->id }}</th>
                                                            <th scope="row">{{ $AP->codePurchase }}</th>
                                                            <td>{{ $AP->nameAPType }}</td>
                                                            <td>{{ $AP->nameProvider }}</td>
                                                            <td>{{ $AP->namePayment }}</td>
                                                            @if(is_numeric($AP->nameCurrency) && $AP->nameCurrency == 0)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $AP->nameCurrency }}</td>
                                                            @endif
                                                            @if(is_numeric($AP->nameBank) && $AP->nameBank == 0)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $AP->nameBank }}</td>
                                                            @endif
                                                            <td>{{ $AP->amountDocument }}</td>
                                                        </tr>
                                                    @else
                                                        @if(
                                                            ($AP->amountDocument == $AP->amountAP) || 
                                                        (
                                                            ($AP->amountAP > 0) && ($AP->amountAP < $AP->amountDocument)
                                                        )
                                                        
                                                        )
                                                        <tr>
                                                            <td colspan="9">
                                                                <div class="alert alert-success mb-0 row mx-auto w-100 justify-content-center" role="alert">Existe una o más facturas pagadas para registrar</div>
                                                            </td>
                                                        </tr>
                                                        @endif
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="generar-ap">
                        <div class="form-group mt-3">
                            <div class="row">
                                <input type="text" name="userAP" class="form-control col-md-12 my-1" hidden="hidden" value="{{ auth()->user()->id }}">
                                <input type="text" name="idAP" class="form-control col-md-12 my-1" hidden="hidden" id="idAP">
                                <div class="col"> 
                                    <input type="text" id="codeAP" class="form-control col-md-12 my-1" placeholder="Código">
                                </div>
                                <div class="col">
                                    <input type="text" id="typeAP" class="form-control col-md-12 my-1" placeholder="Tipo de documento" disabled="disabled">
                                </div>
                                <div class="col">
                                    <input type="text" id="providerAP" class="form-control col-md-12 my-1" placeholder="Proveedor" disabled="disabled">
                                </div>
                                <div class="col">
                                    <input type="text" id="paymentAP" class="form-control col-md-12 my-1" placeholder="Pago" disabled="disabled">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="currencyAP" disabled="">
                                        <option selected="" disabled="disabled" value="0">Moneda</option>
                                        @foreach ( $currencies as $currency )
                                            @if($currency->id > 1)
                                                <option value="{{ $currency->id }}">{{ $currency->codeCurrency }} - {{ $currency->nameCurrency }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="bankAP" disabled="">
                                        <option selected="" disabled="disabled" value="0">Banco</option>
                                        @foreach ( $banks as $bank )
                                            @if($bank->id > 1)
                                                <option value="{{ $bank->id }}">{{ $bank->codeBank }} - {{ $bank->nameBank }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" id="amountDocumentAP" class="form-control col-md-12 my-1" placeholder="Monto doc." disabled="disabled">
                                </div>
                                <div class="col">
                                    <input type="text" id="amountAP" class="form-control col-md-12 my-1" placeholder="Monto aplicado" disabled="disabled">
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-primary col-md-12 my-1" id="saveAP">Aceptar</button>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-danger col-md-12 my-1" id="cancelAP">Cancelar</button>
                                </div>
                            </div>
                            @include('modals.accountPayable.modal-show-ap')
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
        console.log("JQuery is working");

                $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        var nbrTable = document.getElementById("tableAPList").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableAPList").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="9"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen facturas actuales</div></th>'+
            '</tr>';
        }

        var nbrTable = document.getElementById("tableAP").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableAP").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="7"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen facturas actuales</div></th>'+
            '</tr>';
        }


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })

        $('#amountAP').keypress(function(e){ $('#amountAP').attr("maxlength", "18");
            $('#amountAP').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789.,";
            if(numeros.indexOf(tecla) == -1){ return false; }
        });

        $('#codeAP').keypress(function(e){ $('#codeAP').attr("maxlength", "7");
            $('#codeAP').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "cp1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#currencyAP').click(function(e){ 
            $('#currencyAP').attr("class", "browser-default custom-select col-md-12 my-1");
        });

        $('#bankAP').click(function(e){ 
            $('#bankAP').attr("class", "browser-default custom-select col-md-12 my-1");
        });

        $("#codeAP").keydown(function(event) {
            if(event.which == 113) {
                $("#modal-show-ap").modal("show");
            }
        });

        $(document).on('click', '#selectAccountPayable', function(){
            $("#modal-show-ap").modal("hide");
            var info = $(this)[0].parentElement.parentElement;
            /////////////////////////////////////////////////
            $("#idAP").val($(info).find("th:eq(0)").text());
            
            if ($(info).find("th:eq(1)").text() == 0) { $("#currencyAP").prop("disabled", false); } 
            else {
                $currencyAP = $(info).find("th:eq(1)").text();
                $('#currencyAP option:contains('+$currencyAP+')').attr('selected', true);
            }
            if ($(info).find("th:eq(2)").text() == 0) { $("#bankAP").prop("disabled", false); } 
            else {
                $bankAP = $(info).find("th:eq(2)").text();
                $('#bankAP option:contains('+$bankAP+')').attr('selected', true);
            }

            $("#codeAP").val($(info).find("th:eq(3)").text());
            $("#typeAP").val($(info).find("td:eq(0)").text());
            $("#providerAP").val($(info).find("td:eq(1)").text());
            $("#paymentAP").val($(info).find("td:eq(2)").text());
            $("#amountDocumentAP").val($(info).find("td:eq(5)").text());
            $("#amountAP").prop('disabled', '');
        })

        $("#cancelAP").click(function(e){
            var print = confirm("¿Desea cancelar la cuenta por pagar?");
            if (print == true) { 
            $('#idAP').val('')
            $("#codeAP").val('');
            $("#typeAP").val('');
            $("#providerAP").val('');
            $("#paymentAP").val('');
            $("#amountDocumentAP").val('');
            $('#currencyAP').val(0);
            $('#bankAP').val(0);
            $("#currencyAP").prop("disabled", true);
            $("#bankAP").prop("disabled", true);
            $("#amountAP").val('');
            $("#amountAP").prop("disabled", true);
            $('#amountAP').attr("class", "form-control col-md-12 my-1");
            $('#codeAP').attr("class", "form-control col-md-12 my-1");
            $('#currencyAP').attr("class", "browser-default custom-select col-md-12 my-1");
            $('#bankAP').attr("class", "browser-default custom-select col-md-12 my-1");
            window.location.replace("http://127.0.0.1:8000/AP/index");
            }
        })

        $("#saveAP").click(function(e){
            var idAP = $('#idAP').val();
            var amountAP = $('#amountAP').val();
            var amountDocumentAP = $("#amountDocumentAP").val();
            var currencyAP = $('#currencyAP').val();
            var bankAP = $('#bankAP').val();

            if ($("#idAP").val() == "" || $("#codeAP").val() == "" || $("#typeAP").val() == "" ||
                $("#providerAP").val() == "" || $("#paymentAP").val() == "" || $("#currencyAP").val() == null ||
                $("#bankAP").val() == null || $("#amountDocumentAP").val() == "" || $("#amountAP").val() == "" || 
                parseFloat(amountAP) == 0 || parseFloat(amountDocumentAP) == 0) {
                
                alert("Faltan datos");
                if ($("#codeAP").val() == "" || $("#codeAP").val().length < 3) { alert("Código requerido"); $('#codeAP').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (currencyAP == 0 || currencyAP == null) { alert("Moneda requerida"); $('#currencyAP').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (bankAP == 0 || bankAP == null) { alert("Banco requerido"); $('#bankAP').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if ($("#amountAP").val() == "" || $("#amountAP").val().length < 1 || $("#amountAP").val() == 0) { alert("Monto aplicado requerido"); $('#amountAP').attr("class", "form-control col-md-12 my-1 is-invalid"); }
            
            } else {
                
                if ((parseFloat(amountAP) < parseFloat(amountDocumentAP)) || (parseFloat(amountAP) == parseFloat(amountDocumentAP))) { 
                    
                    $.ajax({
                        url : "{{ route('AP.saveAP') }}",
                        type : 'POST',
                        data : { idAP, amountAP, currencyAP, bankAP },
                        success : function(response){
                            if (response == 1 || response == '') { alert("Cuenta por pagar guardada"); window.location.replace("http://127.0.0.1:8000/AP/index"); }
                        }
                    })   

                } else {
                    if ((parseFloat(amountAP) > parseFloat(amountDocumentAP))) {
                        
                        alert("El monto aplicable es mayor al monto del documento");    

                    }
                }

            }
        })

    });
</script>
@endsection('scripts')
