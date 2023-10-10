@extends('layouts.app')

@section('title', 'Factura de Compra')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-facturas">Listar facturas</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#generar-facturas">Generar facturas</a>
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
                    <div class="tab-pane fade active show" id="listar-facturas">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/invoice/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codePurchase">Código</option>
                                                <option value="nameProvider">Proveedor</option>
                                                <option value="namePayment">Pago</option>
                                                <option value="descriptionPurchase">Descripción</option>
                                                <option value="name">Generada</option>
                                                <option value="purchases.created_at">Fecha</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/invoice/index" id="clean">Limpiar</button>
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
                                <div class="col">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th hidden="hidden">ID</th>
                                                    <th scope="col">Código</th>
                                                    <th scope="col">Proveedor</th>
                                                    <th scope="col">Pago</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Generada</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableInvoice">
                                                @foreach ($invoices as $invoice)
                                                    @if($invoice->typePurchase == 3)
                                                        <tr>
                                                            <th hidden="hidden">{{ $invoice->id }}</th>
                                                            <th scope="row">{{ $invoice->codePurchase }}</th>
                                                            <td>{{ $invoice->nameProvider }}</td>
                                                            <td>{{ $invoice->namePayment }}</td>
                                                            <td>Completado</td>
                                                            <td>{{ $invoice->descriptionPurchase }}</td>
                                                            <td>{{ $invoice->name }}</td>
                                                            <td>{{ $invoice->created_at }}</td>
                                                            <td>
                                                                <div class="col">
                                                                    <div class="row mx-auto my-2 w-100 justify-content-center">
                                                                        <button type="button" class="btn btn-success col-md-12 mx-auto btn-block find-detail" data-toggle="modal">Ver</button>
                                                                        <a href="/invoice/print?idPurchase={{ $invoice->id }}" class="btn btn-outline-success col-md-12 mx-auto btn-block">Imprimir</a>
                                                                        <button type="button" class="btn btn-outline-danger col-md-12 mx-auto btn-block cancel-detail" data-toggle="modal">Cancelar</button>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-3">
                                    {{ $invoices->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('modals.purchaseOrder.modal-find-detail')
                    <div class="tab-pane fade" id="generar-facturas">
                        <div class="form-group mt-3">
                            <div class="row">
                                <input type="text" id="userPurchase" class="form-control col-md-12 my-1" hidden="hidden" value="{{ auth()->user()->id }}">
                                <input type="text" id="idPurchase" class="form-control col-md-12 my-1" hidden="hidden">
                                <div class="col"> 
                                    <input type="text" id="codePurchase" class="form-control col-md-12 my-1" placeholder="Código">
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" disabled="disabled" id="paymentPurchase">
                                        <option selected="" disabled="" value="0">Cond. Pago</option>
                                        @foreach ( $paymentConditions as $paymentCondition )
                                            <option value="{{ $paymentCondition->id }}">{{ $paymentCondition->codePayment }} - {{ $paymentCondition->namePayment }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" disabled="disabled" id="providerPurchase">
                                        <option selected="" disabled="" value="0">Proveedor</option>
                                        @foreach ( $providers as $provider )
                                            <option value="{{ $provider->id }}">{{ $provider->codeProvider }} - {{ $provider->nameProvider }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <input type="text" id="descriptionPurchase" class="form-control col-md-12 my-1" placeholder="Descripción" disabled="disabled">
                                </div>
                            </div>
                                                
                            <hr class="my-4">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary col mt-1" id="loadArticles">Cargar artículos</button>
                        </div>
                            
                        <div class="form-group mt-4">
                                <div class="row">
                                    <div class="col">
                                        <div class="table-responsive table-hover">
                                            <table class="table mt-2">
                                                <thead>
                                                    <tr>
                                                        <th hidden="hidden">ID Article</th>
                                                        <th scope="col">Código</th>
                                                        <th scope="col">Descrip.</th>
                                                        <th scope="col">Precio unit.</th>
                                                        <th scope="col">Cantidad</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="tableArticle">
                                                    
                                                </tbody>
                                                <tfoot id="tfootArticle">
                                                    
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                        </div>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary col" id="saveInvoice">Guardar</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-danger col" id="cancelInvoice">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('modals.invoice.modal-show-rn')
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

        var nbrTable = document.getElementById("tableInvoice").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableInvoice").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="8"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen facturas actuales</div></th>'+
            '</tr>';
        }

        var nbrTable = document.getElementById("tableRN").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableRN").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="8"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen recepciones actuales</div></th>'+
            '</tr>';
        }

        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('click', '.find-detail', function (e) {
            e.preventDefault();

            $("#modal-find-detail").modal("show");
            
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idPurchase = $(info).find("th:eq(0)").text();
            
            $.ajax({
                url : "{{ route('purchaseOrder.findDetail') }}",
                type : 'GET',
                data : { idPurchase },
                success : function(response){
                    console.log(response);
                    let layout = '';

                        response.success.forEach(result => {
                                layout +=   `<tr>
                                            <th hidden>${result.id}</th>
                                            <td>${result.codeArticle}</td>
                                            <td>${result.nameArticle}</td>
                                            <td>${result.amountArticle}</td>
                                            <td>${result.unitPriceArticle}</td>
                                        </tr>`
                        })

                        $('#tableDetail').html(layout);

                        let layout2 = '';
                        layout2 +=   `<tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td>${response.success2[0].sum}</td>
                                    </tr>`

                        $('#tfootDetail').html(layout2);
                }
            })
        })

        $("#codePurchase").keydown(function(event) {
            if(event.which == 113) {
                $("#modal-show-rn").modal("show");
            }
        });

        $(document).on('click', '.selectRN', function (e) {
            e.preventDefault();
            var info = $(this)[0].parentElement.parentElement;
            var codePurchase = $(info).find("th:eq(0)").text();
            $.ajax({
                url : "{{ route('invoice.selectReceiptNote') }}",
                type : 'GET',
                data : { codePurchase },
                success : function(response){
                    $('#idPurchase').val(response[0].id);
                    $('#codePurchase').val(codePurchase);
                    $('#providerPurchase').val(response[0].providerPurchase);
                    $('#paymentPurchase').val(response[0].paymentPurchase);
                    $('#descriptionPurchase').val(response[0].descriptionPurchase);
                    $("#modal-show-rn").modal("hide");
                }
            });
        })

        $("#loadArticles").click(function(e){
            if ($('#idPurchase').val() == '' || $('#providerPurchase').val() == '' || 
                    $('#paymentPurchase').val() == '' || $('#descriptionPurchase').val() == '') {
                alert("Seleccione una recepción");
            } else {
                var idPurchase = $('#idPurchase').val();
                $.ajax({
                    url : "{{ route('invoice.loadArticles') }}",
                    type : 'GET',
                    data : { idPurchase },
                    success : function(response){
                        console.log(response);
                        let layout = '';

                        response.success.forEach(result => {
                            if (result.pendingAmountArticle == 0) {
                                layout +=   `<tr>
                                                <th hidden>${result.id}</th>
                                                <td>${result.codeArticle}</td>
                                                <td>${result.nameArticle}</td>
                                                <td>${result.unitPriceArticle}</td>
                                                <td>${result.amountArticle}</td>
                                            </tr>`
                            }
                        });

                        $('#tableArticle').html(layout);

                        let layout2 = '';
                        layout2 +=   `<tr>
                                        <td></td>
                                        <td></td>
                                        <td id="totalQuo">${response.success2[0].sum}</td>
                                        <td></td>
                                    </tr>`

                        $('#tfootArticle').html(layout2);

                    }
                })
            }
        })

        $("#saveInvoice").click(function(e){

            var nbrTable = document.getElementById("tableArticle").rows.length;
            if ($('#idPurchase').val() == '' || $('#providerPurchase').val() == '' || 
                    $('#paymentPurchase').val() == '' || $('#descriptionPurchase').val() == '') {
                
                alert("Seleccione una recepción");

            } else {
                
                if (nbrTable == 0) { 
                    alert("Aún no ha cargado artículos");
                } else {
                    var idPurchase = $('#idPurchase').val();
                    $.ajax({
                        url : "{{ route('invoice.saveInvoice') }}",
                        type : 'POST',
                        data : { idPurchase },
                        success : function(response){
                            console.log(response);
                        
                            alert("Procesando...");

                            
                            if (response >= 1 || response == '') { window.location.replace("http://127.0.0.1:8000/invoice/index"); alert("Factura guardada. Puede imprimir la factura en el menú principal"); }
                        
                        }
                    })
                }

            }
        })

        $("#cancelInvoice").click(function(e){
            e.preventDefault();
            var print = confirm("¿Desea cancelar la factura?");
            if (print == true) { window.location.replace("http://127.0.0.1:8000/invoice/index"); }
        });

        $(document).on('click', '.cancel-detail', function (e) {
            e.preventDefault();
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idPurchase = $(info).find("th:eq(0)").text();

            var print = confirm("¿Desea cancelar la factura?");
            if (print == true) { 
                $.ajax({ url : "{{ route('purchaseOrder.cancelDetail') }}", type : 'POST', data : {idPurchase}, success : function(response){
                        console.log(response); 
                        if (response >= 1 || response == '') { alert("Para consultar facturas canceladas, dirígase a reportes"); window.location.replace("http://127.0.0.1:8000/invoice/index"); }
                    }
                })

            }
        })

    });
</script>
@endsection('scripts')
