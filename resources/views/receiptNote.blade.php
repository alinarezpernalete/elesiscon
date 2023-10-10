@extends('layouts.app')

@section('title', 'Nota de Recepción')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-recepciones">Listar recepciones</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#generar-recepcion">Generar recepción</a>
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
                    <div class="tab-pane fade active show" id="listar-recepciones">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/receiptNote/index" method="GET">
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
                                                <button class="btn btn-outline-secondary" href="/receiptNote/index" id="clean">Limpiar</button>
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
                                            <tbody id="tableReceiptNote">
                                                @foreach ($receiptNotes as $receiptNote)
                                                    @if($receiptNote->typePurchase == 2)
                                                        <tr>
                                                            <th hidden="hidden">{{ $receiptNote->id }}</th>
                                                            <th scope="row">{{ $receiptNote->codePurchase }}</th>
                                                            <td>{{ $receiptNote->nameProvider }}</td>
                                                            <td>{{ $receiptNote->namePayment }}</td>
                                                            <td>Pendiente para factura de compra</td>
                                                            <td>{{ $receiptNote->descriptionPurchase }}</td>
                                                            <td>{{ $receiptNote->name }}</td>
                                                            <td>{{ $receiptNote->created_at }}</td>
                                                            <td>
                                                                <div class="col">
                                                                    <div class="row mx-auto my-2 w-100 justify-content-center">
                                                                        <button type="button" class="btn btn-success col-md-12 mx-auto btn-block find-detail" data-toggle="modal">Ver</button>
                                                                        <a href="/receiptNote/print?idPurchase={{ $receiptNote->id }}" class="btn btn-outline-success col-md-12 mx-auto btn-block">Imprimir</a>
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
                                    {{ $receiptNotes->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('modals.purchaseOrder.modal-find-detail')
                    <div class="tab-pane fade" id="generar-recepcion">
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
                                                        <th scope="col">Cantidad pend.</th>
                                                        <th scope="col">Cantidad rec.</th>
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
                                    <button type="submit" class="btn btn-primary col" id="saveReceiptNote">Guardar</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-danger col" id="cancelReceiptNote">Cancelar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('modals.receiptNote.modal-show-po')
                </div> 
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function () {
        console.log("JQuery is working");

        function onLoad(){
            var nbrTable = document.getElementById("tablePO").rows.length;
            var codesArray = new Array();
            if (nbrTable != 0) { 
                for (var i = 0; i < nbrTable; i++) {
                    codesArray.push($(".codeForOnLoad")[i].innerHTML);
                }
                /*var idSale = $("#tableSO tr").children(":first").text();*/
                $.ajax({
                    url : "{{ route('receiptNote.deleteOnUnload') }}",
                    type : 'GET',
                    data : { codesArray },
                    success : function(response){
                        console.log(response);
                    }
                });
            }
        }

        window.onbeforeunload = onLoad();

                $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        var nbrTable = document.getElementById("tableReceiptNote").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableReceiptNote").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="8"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen recepciones actuales</div></th>'+
            '</tr>';
        }

        var nbrTable = document.getElementById("tablePO").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tablePO").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="8"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen ordenes de compra actuales</div></th>'+
            '</tr>';
        }

        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#codePurchase").keydown(function(event) {
            if(event.which == 113) {
                $("#modal-show-po").modal("show");
            }
        });
        
        $(document).on('click', '.selectPO', function (e) {
            e.preventDefault();
            var info = $(this)[0].parentElement.parentElement;
            var codePurchase = $(info).find("th:eq(0)").text();
            $.ajax({
                url : "{{ route('receiptNote.selectPurchaseOrder') }}",
                type : 'GET',
                data : { codePurchase },
                success : function(response){
                    $('#idPurchase').val(response[0].id);
                    $('#codePurchase').val(codePurchase);
                    $('#providerPurchase').val(response[0].providerPurchase);
                    $('#paymentPurchase').val(response[0].paymentPurchase);
                    $('#descriptionPurchase').val(response[0].descriptionPurchase);
                    $("#modal-show-po").modal("hide");
                }
            });
        })

        $("#loadArticles").click(function(e){
            console.log($('#idPurchase').val());
            if ($('#idPurchase').val() == '' || $('#providerPurchase').val() == '' || 
                    $('#paymentPurchase').val() == '' || $('#descriptionPurchase').val() == '') {
                alert("Seleccione una orden de compra");
            } else {
                var idPurchase = $('#idPurchase').val();
                $.ajax({
                    url : "{{ route('receiptNote.loadArticles') }}",
                    type : 'GET',
                    data : { idPurchase },
                    success : function(response){
                        console.log(response);
                        let layout = '';

                        response.success.forEach(result => {
                            if (result.pendingAmountArticle > 0) {
                                layout +=   `<tr>
                                            <th hidden>${result.id}</th>
                                            <th hidden>${result.created_at}</th>
                                            <td>${result.codeArticle}</td>
                                            <td>${result.nameArticle}</td>
                                            <td>${result.unitPriceArticle}</td>
                                            <td>${result.amountArticle}</td>
                                            <td>${result.pendingAmountArticle}</td>
                                            <td>

                                            <div class="input-group input-group-sm">
                                                <input type="text" class="form-control" placeholder="Cantidad" aria-describedby="basic-addon2" value="">
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary confirmStock">Aceptar</button>
                                                </div>
                                                <div class="input-group-append">
                                                    <button class="btn btn-outline-secondary cancelStock">Cancelar</button>
                                                </div>
                                            </div>
                                            
                                            </td>
                                        </tr>`
                            }
                        })

                        $('#tableArticle').html(layout);

                        let layout2 = '';

                        layout2 +=   `<tr>
                                        <td></td>
                                        <td></td>
                                        <td id="totalQuo">${response.success2[0].sum}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>`

                        $('#tfootArticle').html(layout2);

                    }
                })
            }
        })

        $(document).on('click', '.confirmStock', function () {
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            ///
            var button1 = $(this)[0];
            var button2 = $(this)[0].parentElement.nextSibling.nextSibling.firstChild.nextSibling;
            ///
            var inputStock = $(info).find("td:eq(5)").children(":first").children(":first").val();
            var amountArticle = $(info).find("td:eq(3)").text();
            var idArticle = $(info).find("th:eq(0)").text();
            var created_at = $(info).find("th:eq(1)").text();

            if (parseInt(amountArticle) == 0) {
                alert("Cantidad no puede ser 0");
            }

            if (parseInt(inputStock) > parseInt(amountArticle)) {
                
                alert("Cantidad introducida es mayor");
                $(info).find("td:eq(5)").children(":first").children(":first").val('');
                $(info).find("td:eq(5)").children(":first").children(":first").focus();

            } else {
                
                if (parseInt(inputStock) < parseInt(amountArticle)){
                    
                    alert("Tenga en cuenta que la cantidad introducida es menor a la cantidad en pantalla");
                    
                    $.ajax({
                            url : "{{ route('receiptNote.confirmStock') }}",
                            type : 'POST',
                            data : { inputStock, idArticle, created_at },
                            success : function(response){
                                console.log(response);
                                $(info).find("td:eq(5)").children(":first").children(":first").prop('disabled', true);
                                button1.disabled = true;
                                button2.disabled = true;
                            }
                        })

                } else {
                    
                    if (parseInt(inputStock) == parseInt(amountArticle)){ 
                        
                        $.ajax({
                            url : "{{ route('receiptNote.confirmStock') }}",
                            type : 'POST',
                            data : { inputStock, idArticle, created_at },
                            success : function(response){
                                console.log(response);
                                $(info).find("td:eq(5)").children(":first").children(":first").prop('disabled', true);
                                button1.disabled = true;
                                button2.disabled = true;
                            }
                        })

                    }

                }
            }
        });

        $(document).on('click', '.cancelStock', function () {
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var inputStock = $(info).find("td:eq(5)").children(":first").children(":first").val();
            var idArticle = $(info).find("th:eq(0)").text();
            var created_at = $(info).find("th:eq(1)").text();

            if (inputStock == '') {
                alert("No hay nada que cancelar");
            } else {
                $.ajax({
                    url : "{{ route('receiptNote.cancelStock') }}",
                    type : 'POST',
                    data : { inputStock, idArticle, created_at },
                    success : function(response){
                        console.log(response);
                        $(info).find("td:eq(5)").children(":first").children(":first").prop('disabled', false);
                        $(info).find("td:eq(5)").children(":first").children(":first").val('');
                    }
                })
            }
        });

        $("#saveReceiptNote").click(function(e){
            var nbrTable = document.getElementById("tableArticle").rows.length;
            if ($('#idPurchase').val() == '' || $('#providerPurchase').val() == '' || 
                    $('#paymentPurchase').val() == '' || $('#descriptionPurchase').val() == '') {
                
                alert("Seleccione una orden de compra");

            } else {
                
                if (nbrTable == 0) { 
                    alert("Aún no ha cargado artículos");
                } else {
                    var idPurchase = $('#idPurchase').val();
                    $.ajax({
                        url : "{{ route('receiptNote.saveReceiptNote') }}",
                        type : 'POST',
                        data : { idPurchase },
                        success : function(response){
                            console.log(response);
                        
                            alert("Procesando...");

                            if (response == '1') { alert('Se mantendrá como orden de compra debido a que faltan artículos por recepción, presione Ctrl+Shift+R para actualizar. Podrá imprimir la nota de recepción en el menú principal'); }
                            if (response == '2' || response > 2) { alert("Nota de recepción guardada, presione Ctrl+Shift+R para actualizar. Podrá imprimir la nota de recepción en el menú principal");}
                            
                            $('#providerPurchase').val(0);
                            $('#paymentPurchase').val(0);
                            $('#descriptionPurchase').val('');
                            $("#tableArticle tr").remove();

                        }
                    })
                }

            }
        })

        $("#cancelReceiptNote").click(function(e){
            e.preventDefault();
            var print = confirm("¿Desea cancelar la nota de entrega?");
            if (print == true) { window.location.replace("http://127.0.0.1:8000/receiptNote/index"); }
        });

        $(document).on('click', '.cancel-detail', function (e) {
            e.preventDefault();
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idPurchase = $(info).find("th:eq(0)").text();

            var print = confirm("¿Desea cancelar la nota de recepción?");
            if (print == true) { 
                $.ajax({ url : "{{ route('purchaseOrder.cancelDetail') }}", type : 'POST', data : {idPurchase}, success : function(response){
                        console.log(response); 
                        if (response >= 1 || response == '') { alert("Para consultar notas de recepción canceladas, dirígase a reportes"); window.location.replace("http://127.0.0.1:8000/receiptNote/index"); }
                    }
                })

            }
        })

    });
</script>
@endsection('scripts')
