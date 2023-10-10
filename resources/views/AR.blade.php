@extends('layouts.app')

@section('title', 'Facturas cobradas')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-ar">Listar facturas cobradas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#generar-ar">Generar facturas cobradas</a>
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
                    <div class="tab-pane fade active show" id="listar-ar">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/AR/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" value="">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeSale">Código</option>
                                                <option value="codeCustomer">Cliente</option>
                                                <option value="codeCurrency">Moneda</option>
                                                <option value="codeBank">Banco</option>
                                                <option value="codePayment">Pago</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/AR/index" id="clean">Limpiar</button>
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
                                            <tbody id="tableAR">
                                                @foreach ($ARs as $AR)
                                                    @if($AR->amountAR == 0.00)
                                                        <tr>
                                                            <th hidden="hidden">{{ $AR->id }}</th>
                                                            <th scope="row">{{ $AR->codeSale }}</th>
                                                            <td>{{ $AR->nameARType }}</td>
                                                            <td>{{ $AR->nameCustomer }}</td>
                                                            <td>{{ $AR->namePayment }}</td>
                                                            @if(is_numeric($AR->nameCurrency) && $AR->nameCurrency == 0)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $AR->nameCurrency }}</td>
                                                            @endif
                                                            @if(is_numeric($AR->nameBank) && $AR->nameBank == 0)
                                                                <td>-</td>
                                                            @else
                                                                <td>{{ $AR->nameBank }}</td>
                                                            @endif
                                                            <td>{{ $AR->amountDocument }}</td>
                                                        </tr>
                                                    @else
                                                        @if(
                                                            ($AR->amountDocument == $AR->amountAR) || 
                                                        (
                                                            ($AR->amountAR > 0) && ($AR->amountAR < $AR->amountDocument)
                                                        )
                                                        
                                                        )
                                                        <tr>
                                                            <td colspan="9">
                                                                <div class="alert alert-success mb-0 row mx-auto w-100 justify-content-center" role="alert">Existe una o más facturas cobradas para registrar</div>
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
                    <div class="tab-pane fade" id="generar-ar">
                        <div class="form-group mt-3">
                            <div class="row">
                                <input type="text" name="userAR" class="form-control col-md-12 my-1" hidden="hidden" value="{{ auth()->user()->id }}">
                                <input type="text" name="idAR" class="form-control col-md-12 my-1" hidden="hidden" id="idAR">
                                <div class="col"> 
                                    <input type="text" id="codeAR" class="form-control col-md-12 my-1" placeholder="Código">
                                </div>
                                <div class="col">
                                    <input type="text" id="typeAR" class="form-control col-md-12 my-1" placeholder="Tipo de documento" disabled="disabled">
                                </div>
                                <div class="col">
                                    <input type="text" id="customerAR" class="form-control col-md-12 my-1" placeholder="Cliente" disabled="disabled">
                                </div>
                                <div class="col">
                                    <input type="text" id="paymentAR" class="form-control col-md-12 my-1" placeholder="Pago" disabled="disabled">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="currencyAR" disabled="">
                                        <option selected="" disabled="disabled" value="0">Moneda</option>
                                        @foreach ( $currencies as $currency )
                                            @if($currency->id > 1)
                                                <option value="{{ $currency->id }}">{{ $currency->codeCurrency }} - {{ $currency->nameCurrency }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="bankAR" disabled="">
                                        <option selected="" disabled="disabled" value="0">Banco</option>
                                        @foreach ( $banks as $bank )
                                            @if($bank->id > 1)
                                                <option value="{{ $bank->id }}">{{ $bank->codeBank }} - {{ $bank->nameBank }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" id="amountDocumentAR" class="form-control col-md-12 my-1" placeholder="Monto doc." disabled="disabled">
                                </div>
                                <div class="col">
                                    <input type="text" id="amountAR" class="form-control col-md-12 my-1" placeholder="Monto aplicado" disabled="disabled">
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-primary col-md-12 my-1" id="saveAR">Aceptar</button>
                                </div>
                                <div class="col">
                                    <button type="button" class="btn btn-danger col-md-12 my-1" id="cancelAR">Cancelar</button>
                                </div>
                            </div>
                            @include('modals.accountReceivable.modal-show-ar')
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

        var nbrTable = document.getElementById("tableARList").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableARList").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="9"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen facturas actuales</div></th>'+
            '</tr>';
        }

        var nbrTable = document.getElementById("tableAR").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableAR").insertRow(-1).innerHTML = 
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

        $('#amountAR').keypress(function(e){ $('#amountAR').attr("maxlength", "18");
            $('#amountAR').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789.,";
            if(numeros.indexOf(tecla) == -1){ return false; }
        });

        $('#codeAR').keypress(function(e){ $('#codeAR').attr("maxlength", "7");
            $('#codeAR').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "cs1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#currencyAR').click(function(e){ 
            $('#currencyAR').attr("class", "browser-default custom-select col-md-12 my-1");
        });

        $('#bankAR').click(function(e){ 
            $('#bankAR').attr("class", "browser-default custom-select col-md-12 my-1");
        });

        $("#codeAR").keydown(function(event) {
            if(event.which == 113) {
                $("#modal-show-ar").modal("show");
            }
        });

        $(document).on('click', '#selectAccountReceivable', function(){
            $("#modal-show-ar").modal("hide");
            var info = $(this)[0].parentElement.parentElement;
            /////////////////////////////////////////////////
            $("#idAR").val($(info).find("th:eq(0)").text());
            
            if ($(info).find("th:eq(1)").text() == 0) { $("#currencyAR").prop("disabled", false); } 
            else {
                $currencyAR = $(info).find("th:eq(1)").text();
                $('#currencyAR option:contains('+$currencyAR+')').attr('selected', true);
            }
            if ($(info).find("th:eq(2)").text() == 0) { $("#bankAR").prop("disabled", false); } 
            else {
                $bankAR = $(info).find("th:eq(2)").text();
                $('#bankAR option:contains('+$bankAR+')').attr('selected', true);
            }

            $("#codeAR").val($(info).find("th:eq(3)").text());
            $("#typeAR").val($(info).find("td:eq(0)").text());
            $("#customerAR").val($(info).find("td:eq(1)").text());
            $("#paymentAR").val($(info).find("td:eq(2)").text());
            $("#amountDocumentAR").val($(info).find("td:eq(5)").text());
            $("#amountAR").prop('disabled', '');
        })

        $("#cancelAR").click(function(e){
            var print = confirm("¿Desea cancelar la cuenta por pagar?");
            if (print == true) { 
            $("#codeAR").val('');
            $("#typeAR").val('');
            $("#customerAR").val('');
            $("#paymentAR").val('');
            $("#amountDocumentAR").val('');
            $('#currencyAR').val(0);
            $('#bankAR').val(0);
            $("#currencyAR").prop("disabled", true);
            $("#bankAR").prop("disabled", true);
            $("#amountAR").val('');
            $("#amountAR").prop("disabled", true);
            $('#amountAR').attr("class", "form-control col-md-12 my-1");
            $('#codeAR').attr("class", "form-control col-md-12 my-1");
            $('#currencyAR').attr("class", "browser-default custom-select col-md-12 my-1");
            $('#bankAR').attr("class", "browser-default custom-select col-md-12 my-1");
            window.location.replace("http://127.0.0.1:8000/AR/index");
            }
        })

        $("#saveAR").click(function(e){
            var idAR = $('#idAR').val();
            var amountAR = $('#amountAR').val();
            var amountDocumentAR = $("#amountDocumentAR").val();
            var currencyAR = $('#currencyAR').val();
            var bankAR = $('#bankAR').val();
            if ($("#idAR").val() == "" || $("#codeAR").val() == "" || $("#typeAR").val() == "" ||
                $("#providerAR").val() == "" || $("#paymentAR").val() == "" || $("#currencyAR").val() == null ||
                $("#bankAR").val() == null || $("#amountDocumentAR").val() == "" || $("#amountAR").val() == "" || 
                parseFloat(amountAR) == 0 || parseFloat(amountDocumentAR) == 0) {
                
                alert("Faltan datos");
                if ($("#codeAR").val() == "" || $("#codeAR").val().length < 3) { alert("Código requerido"); $('#codeAR').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (currencyAR == 0 || currencyAR == null) { alert("Moneda requerida"); $('#currencyAR').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (bankAR == 0 || bankAR == null) { alert("Banco requerido"); $('#bankAR').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if ($("#amountAR").val() == "" || $("#amountAR").val().length < 1 || $("#amountAR").val() == 0) { alert("Monto aplicado requerido"); $('#amountAR').attr("class", "form-control col-md-12 my-1 is-invalid"); }

            } else {
                
                if ((parseFloat(amountAR) < parseFloat(amountDocumentAR)) || (parseFloat(amountAR) == parseFloat(amountDocumentAR))) { 
                    
                    $.ajax({
                        url : "{{ route('AR.saveAR') }}",
                        type : 'POST',
                        data : { idAR, amountAR, currencyAR, bankAR },
                        success : function(response){
                            if (response == 1 || response == '') { alert("Cuenta por cobrar guardada"); window.location.replace("http://127.0.0.1:8000/AR/index"); }
                        }
                    })   

                } else {
                    if ((parseFloat(amountAR) > parseFloat(amountDocumentAR))) {
                        
                        alert("El monto aplicable es mayor al monto del documento");    

                    }
                }

            }
        })

    });
</script>
@endsection('scripts')
