@extends('layouts.app')

@section('title', 'Pedido')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-pedidos">Listar pedidos</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#generar-pedido">Generar pedido</a>
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
                    <div class="tab-pane fade active show" id="listar-pedidos">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/saleOrder/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeSale">Código</option>
                                                <option value="nameCustomer">Cliente</option>
                                                <option value="namePayment">Pago</option>
                                                <option value="descriptionSale">Descripción</option>
                                                <option value="name">Generada</option>
                                                <option value="sales.created_at">Fecha</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/saleOrder/index" id="clean">Limpiar</button>
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
                                                    <th scope="col">Cliente</th>
                                                    <th scope="col">Pago</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Generada</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableSaleOrder">
                                                @foreach ($saleOrders as $saleOrder)
                                                    @if($saleOrder->typeSale == 2)
                                                        <tr>
                                                            <th hidden="hidden">{{ $saleOrder->id }}</th>
                                                            <th scope="row">{{ $saleOrder->codeSale }}</th>
                                                            <td>{{ $saleOrder->nameCustomer }}</td>
                                                            <td>{{ $saleOrder->namePayment }}</td>
                                                            <td>Pendiente para nota de entrega</td>
                                                            <td>{{ $saleOrder->descriptionSale }}</td>
                                                            <td>{{ $saleOrder->name }}</td>
                                                            <td>{{ $saleOrder->created_at }}</td>
                                                            <td>
                                                                <div class="col">
                                                                    <div class="row mx-auto my-2 w-100 justify-content-center">
                                                                        <button type="button" class="btn btn-success col-md-12 mx-auto btn-block find-detail" data-toggle="modal">Ver</button>
                                                                        <a href="/saleOrder/print?idSale={{ $saleOrder->id }}" class="btn btn-outline-success col-md-12 mx-auto btn-block">Imprimir</a>
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
                                    {{ $saleOrders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('modals.quotation.modal-find-detail')
                    <div class="tab-pane fade" id="generar-pedido">
                        
                        <div class="form-group mt-3">
                            <div class="row">
                                <input type="text" id="userSale" class="form-control col-md-12 my-1" hidden="hidden" value="{{ auth()->user()->id }}">
                                <input type="text" id="idSale" class="form-control col-md-12 my-1" hidden="hidden">
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" id="codeSale" placeholder="Código">
                                 </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="customerSale" disabled="disabled">
                                        <option selected="" disabled="" value="0">Cliente</option>
                                        @foreach ( $customers as $customer )
                                            <option value="{{ $customer->id }}">{{ $customer->codeCustomer }} - {{ $customer->nameCustomer }}</option>
                                         @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="paymentSale" disabled="disabled">
                                        <option selected="" disabled="" value="0">Cond. Pago</option>
                                        @foreach ( $paymentConditions as $paymentCondition )
                                            <option value="{{ $paymentCondition->id }}">{{ $paymentCondition->codePayment }} - {{ $paymentCondition->namePayment }}</option>
                                        @endforeach
                                     </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <input type="text" id="descriptionSale" class="form-control col-md-12 my-1" placeholder="Descripción" disabled="disabled">
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
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th hidden="hidden">ID Detail</th>
                                                        <th hidden="hidden">ID Article</th>
                                                        <th scope="col">Código</th>
                                                        <th scope="col">Descrip.</th>
                                                        <th scope="col">Precio unit.</th>
                                                        <th scope="col">Cantidad</th>
                                                        <th scope="col">Cantidad a env.</th>
                                                        <!--<th scope="col">Acciones</th>-->
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
                                <button class="btn btn-primary col" id="saveSaleOrder">Guardar</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-danger col" id="cancelSaleOrder">Cancelar</button>
                                </div>
                            </div>
                        </div>
                        @include('modals.saleOrder.modal-show-quotation')
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

        function onLoad(){
            var nbrTable = document.getElementById("tableQuotation").rows.length;
            if (nbrTable != 0) { 
                var idSale = $("#tableQuotation tr").children(":first").text();
                $.ajax({
                    url : "{{ route('saleOrder.deleteOnUnload') }}",
                    type : 'GET',
                    data : { idSale },
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

        var nbrTable = document.getElementById("tableSaleOrder").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableSaleOrder").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="8"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen pedidos actuales</div></th>'+
            '</tr>';
        }

        var nbrTable = document.getElementById("tableQuotation").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableQuotation").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="8"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen cotizaciones actuales</div></th>'+
            '</tr>';
        }

        $(document).on('click', '.find-detail', function (e) {
            e.preventDefault();

            $("#modal-find-detail").modal("show");
            
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idSale = $(info).find("th:eq(0)").text();
            
            $.ajax({
                url : "{{ route('quotation.findDetail') }}",
                type : 'GET',
                data : { idSale },
                success : function(response){
                    console.log(response);
                    let layout = '';
                    let layout2 = '';

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

        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })

        $("#codeSale").keydown(function(event) {
            if(event.which == 113) {
                $("#modal-show-quotation").modal("show");
            }
        });

        $(document).on('click', '.selectQuotation', function (e) {
            e.preventDefault();
            var info = $(this)[0].parentElement.parentElement;
            var codeSale = $(info).find("th:eq(0)").text();
            $.ajax({
                url : "{{ route('saleOrder.selectQuotation') }}",
                type : 'GET',
                data : { codeSale },
                success : function(response){
                    console.log(response);
                    $('#idSale').val(response[0].id);
                    $('#codeSale').val(response[0].codeSale);
                    $('#customerSale').val(response[0].customerSale);
                    $('#paymentSale').val(response[0].paymentSale);
                    $('#descriptionSale').val(response[0].descriptionSale);
                    $("#modal-show-quotation").modal("hide");
                }
            });
        })

        $("#loadArticles").click(function(e){
            var idSale = $('#idSale').val();
            if (idSale != "") {
                $.ajax({
                    url : "{{ route('saleOrder.loadArticles') }}",
                    type : 'GET',
                    data : { idSale },
                    success : function(response){
                        console.log(response);
                        let layout = '';
                        let layout2 = '';

                        response.success.forEach(result => {
                            layout +=   `<tr>
                                            <th hidden>${result.id}</th>
                                            <th hidden>${result.created_at}</th>
                                            <td>${result.codeArticle}</td>
                                            <td>${result.nameArticle}</td>
                                            <td>${result.unitPriceArticle}</td>
                                            <td>${result.amountArticle}</td>
                                            <td>
                                                <div class="input-group input-group-sm">
                                                    <input type="text" class="form-control" placeholder="Cantidad" aria-describedby="basic-addon2" value="" maxlength=4 onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary confirmStock">Aceptar</button>
                                                    </div>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary eraserStock">Borrar</button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>`
                        });
                        //<td><button type="button" class="btn btn-danger btn-sm deleteDetail">Eliminar</button></td>

                        $('#tableArticle').html(layout);

                        layout2 +=   `<tr>
                                        <td></td>
                                        <td></td>
                                        <td id="totalQuo">${response.success2[0].sum}</td>
                                        <td></td>
                                        <td></td>
                                    </tr>`

                        $('#tfootArticle').html(layout2);

                    }
                })
            } else { alert("Seleccione una cotización"); }
        })

        $(document).on('click', '.eraserStock', function () {
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            $(info).find("td:eq(4)").children(":first").children(":first").val('');
        });

        $(document).on('click', '.confirmStock', function () {
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            //////
            var button1 = $(this)[0];
            var button2 = $(this)[0].parentElement.nextSibling.nextSibling.firstChild.nextSibling;
            /////
            var inputStock = $(info).find("td:eq(4)").children(":first").children(":first").val();
            var amountArticle = $(info).find("td:eq(3)").text();
            var idArticle = $(info).find("th:eq(0)").text();
            var created_at = $(info).find("th:eq(1)").text();
            /////////////////
            var idSale = $("#idSale").val();

            if (inputStock == 0 || inputStock < 0) {
                alert("Debe introducir una cantidad mayor a 0");
                $(info).find("td:eq(4)").children(":first").children(":first").val('');
            } else {
                        
                $.ajax({
                    url : "{{ route('saleOrder.confirmStock') }}",
                    type : 'POST',
                    data : { inputStock, idArticle, created_at, idSale },
                    success : function(response){
                        console.log(response);
                        if (response == "Input mayor")  {
                            alert("La cantidad ingresada sobrepasa el número de artículos disponibles");
                            $(info).find("td:eq(4)").children(":first").children(":first").val('');
                            $(info).find("td:eq(4)").children(":first").children(":first").focus();
                        } else {
                            $(info).find("td:eq(4)").children(":first").children(":first").prop('disabled', true);
                            button1.disabled = true;
                            button2.disabled = true;
                        }

                        if (response == "normal")  {
                            $(info).find("td:eq(4)").children(":first").children(":first").prop('disabled', true);   
                            button1.disabled = true;
                            button2.disabled = true;
                        }
                    }
                })
            }
        });

        /*$(document).on('click', '.deleteDetail', function () {
            var info = $(this)[0].parentElement.parentElement;
            var created_at = $(info).find("th:eq(1)").text();
            var unitPriceArticle = $(info).find("td:eq(2)").text();
            var amountArticle = $(info).find("td:eq(3)").text();
            var idArticle = $(info).find("th:eq(0)").text();
            $.ajax({
                url : "{{ route('saleOrder.deleteDetail') }}",
                type : 'POST',
                data : { created_at, amountArticle, idArticle },
                success : function(response){
                    console.log(response);
                    
                    var nbrTable = document.getElementById("tableArticle").rows.length;
                    if (nbrTable > 1) {
                        info.closest('tr').remove();
                    } else {
                        if (nbrTable == 1) {
                            info.closest('tr').remove();
                            alert("Eliminó todos los detalles. Esta cotización se eliminará");
                            var codeSale = $("#codeSale").val();
                            $.ajax({
                                url : "{{ route('saleOrder.deleteQuotation') }}",
                                type : 'POST',
                                data : { codeSale },
                                success : function(response){
                                    console.log(response);
                                    window.location.replace("http://127.0.0.1:8000/saleOrder/index");
                                }
                            })
                        }
                    }
                }
            })
        });*/

        $("#saveSaleOrder").click(function(e){
            var nbrTable = document.getElementById("tableArticle").rows.length;
            if ($('#idSale').val() == '' || $('#customerSale').val() == '' || 
                    $('#paymentSale').val() == '' || $('#descriptionSale').val() == '') {
                
                alert("Seleccione una cotización");

            } else {

                if (nbrTable == 0 || nbrTable == "") { 
                    alert("Aún no ha cargado artículos");
                } else {
                    var idSale = $('#idSale').val();
                    $.ajax({
                        url : "{{ route('saleOrder.saveSaleOrder') }}",
                        type : 'POST',
                        data : { idSale },
                        success : function(response){
                            console.log(response);
                            alert("Procesando...");

                            if (response >= 1 || response == '') { alert("Pedido guardado, presione Ctrl+Shift+R para actualizar. Podrá imprimir el pedido en el menú principal"); 
                                $('#customerSale').val(0);
                                $('#paymentSale').val(0);
                                $('#descriptionSale').val('');
                                $("#tableArticle tr").remove();
                            }
                        }
                    })       
                }

            }
        })

        $("#cancelSaleOrder").click(function(e){
            e.preventDefault();
            var print = confirm("¿Desea cerrar el pedido?");
            if (print == true) { window.location.replace("http://127.0.0.1:8000/saleOrder/index"); }
        });

        $(document).on('click', '.cancel-detail', function (e) {
            e.preventDefault();
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idSale = $(info).find("th:eq(0)").text();

            var print = confirm("¿Desea cancelar el pedido?");
            if (print == true) { 
                $.ajax({ url : "{{ route('quotation.cancelDetail') }}", type : 'POST', data : { idSale }, success : function(response){
                        console.log(response); 
                        if (response >= 1 || response == '') { alert("Para consultar cotizaciones canceladas, dirígase a reportes"); window.location.replace("http://127.0.0.1:8000/saleOrder/index");  }
                    }
                })

            }
        })

    });
</script>
@endsection('scripts')
