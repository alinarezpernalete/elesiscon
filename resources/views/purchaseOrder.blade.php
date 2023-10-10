@extends('layouts.app')

@section('title', 'Orden de compra')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-oc">Listar O/C</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#generar-oc">Generar O/C</a>
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
                    <div class="tab-pane fade active show" id="listar-oc">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/purchaseOrder/index" method="GET">
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
                                                <button class="btn btn-outline-secondary" href="/purchaseOrder/index" id="clean">Limpiar</button>
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
                                            <tbody id="tablePurchaseOrder">
                                                @foreach ($purchaseOrders as $purchaseOrder)
                                                    @if($purchaseOrder->typePurchase == 1)
                                                        <tr>
                                                            <th hidden="hidden">{{ $purchaseOrder->id }}</th>
                                                            <th scope="row">{{ $purchaseOrder->codePurchase }}</th>
                                                            <td>{{ $purchaseOrder->nameProvider }}</td>
                                                            <td>{{ $purchaseOrder->namePayment }}</td>
                                                            <td>Pendiente para nota de recepción</td>
                                                            <td>{{ $purchaseOrder->descriptionPurchase }}</td>
                                                            <td>{{ $purchaseOrder->name }}</td>
                                                            <td>{{ $purchaseOrder->created_at }}</td>
                                                            <td>
                                                                <div class="col">
                                                                    <div class="row mx-auto w-100 justify-content-center">
                                                                        <button type="button" class="btn btn-success col-md-12 mx-auto btn-block find-detail" data-toggle="modal">Ver</button>
                                                                        <a href="/purchaseOrder/print?idPurchase={{ $purchaseOrder->id }}" class="btn btn-outline-success col-md-12 mx-auto btn-block">Imprimir</a>
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
                                    {{ $purchaseOrders->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('modals.purchaseOrder.modal-find-detail')
                    <div class="tab-pane fade" id="generar-oc">
                        <div class="form-group mt-3">
                            <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" data-toggle="modal" data-target="#modal-add-provider">Registrar proveedor</button>
                        </div>
                        <div class="form-group mt-3">
                            <div class="row">
                                <input type="text" id="userPurchase" class="form-control col-md-12 my-1" hidden="hidden" value="{{ auth()->user()->id }}">
                                <div class="col"> 
                                    @if (isset($purchaseOrders->first()->codePurchase))
                                        <input type="text" id="codePurchase" class="form-control col-md-12 my-1" value="CP{{substr($purchaseOrders->first()->codePurchase, 2, 300)+1}}" disabled="">
                                    @else
                                        <input type="text" id="codePurchase" class="form-control col-md-12 my-1" value="CP1" disabled="" placeholder="No existen códigos aún">
                                    @endif
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="providerPurchase">
                                        <option selected="" disabled="" value="0">Proveedor</option>
                                        @foreach ( $providers as $provider )
                                            @if ($provider->statusProvider == 1)
                                            <option value="{{ $provider->id }}">{{ $provider->codeProvider }} - {{ $provider->nameProvider }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="paymentPurchase">
                                        <option selected="" disabled="" value="0">Cond. Pago</option>
                                        @foreach ( $paymentConditions as $paymentCondition )
                                        <option value="{{ $paymentCondition->id }}">{{ $paymentCondition->codePayment }} - {{ $paymentCondition->namePayment }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <input type="text" id="descriptionPurchase" class="form-control col-md-12 my-1" placeholder="Descripción">
                                </div>
                            </div>
                                                
                            <hr class="my-4">
                        </div>
                            
                        <div class="form-group mt-4">
                                <div class="row">
                                    <div class="col"> 
                                        <div class="input-group mb-1">
                                            <input type="text" class="form-control" placeholder="Ingrese código de artículo" aria-describedby="basic-addon2" name="search" id="codeArticle" type="search" value="">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" id="submitArticle">Aceptar</button>
                                                <button class="btn btn-outline-success" type="button" data-toggle="modal" data-target="#modal-find-article">Consultar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <div class="input-group mt-1 mb-4">
                                            <input type="text" class="form-control" placeholder="Artículo" id="nameArticle" disabled="disabled">
                                            <input type="text" class="form-control" placeholder="Cantidad" id="amountArticle">
                                            <input type="text" class="form-control" placeholder="Cant. disponible" id="currentStock" disabled="">
                                            <input type="text" class="form-control" placeholder="Precio unit." id="unitPriceArticle">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" id="addToListArticle">Agregar</button>
                                                <button class="btn btn-outline-danger" id="cancelArticle">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                @include('modals.find.modal-find-article')
                                
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
                                                        <th scope="col">Cantidad</th>
                                                        <th scope="col">Precio unit.</th>
                                                        <th scope="col">Acciones</th>
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
                                    <button class="btn btn-primary col" id="savePurchaseOrder">Guardar</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-outline-danger col" id="cancelPurchaseOrder">Cancelar</button>
                                </div>
                            </div>
                        </div>
                        @include('modals.purchaseOrder.modal-add-provider')
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

        $.ajax({
            url : "{{ route('purchaseOrder.deleteOnUnload') }}",
            type : 'GET',
            success : function(response){
                console.log(response);
            }
        })

                $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        if ($("#searchFast").val() == ""){
            $('#tableFast').html(''); 
        }

        $("#searchFast").keyup(function(e){ 
            var nameArticle = $("#searchFast").val();
            $.ajax({ 
              url : "{{ route('quotation.findArticle') }}",
              type : 'GET',
              data : { nameArticle },
              success : function(response){
                let layout = '';

                response.data.forEach(result => {
                        layout +=   `
                                <tr>
                                    <th scope="row">${result.codeArticle}</th>
                                    <td>${result.nameType}</td>
                                    <td>${result.nameArticle}</td>
                                    <td>${result.modelArticle}</td>
                                    <td>${result.referenceArticle}</td>
                                    <td>${result.weightArticle}</td>
                                    <td>${result.locationArticle}</td>
                                    <td>${result.nameLine}</td>
                                    <td>${result.nameSubline}</td>
                                    <td>${result.nameGroup}</td>
                                    <td>${result.nameOrigin}</td>
                                    <td>${result.nameProvider}</td>
                                    <td>${result.created_at}</td>
                                </tr>   `
                })
                $('#tableFast').html(layout);
              }
            });
          })

        var nbrTable = document.getElementById("tablePurchaseOrder").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tablePurchaseOrder").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="8"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen órdenes de compra actuales</div></th>'+
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

        $("#saveProvider").click(function(e){
            e.preventDefault();
            var codeProvider = $('#codeProvider').val();
            var nameProvider = $('#nameProvider').val();
            var addressProvider = $('#addressProvider').val();
            var phoneProvider = $('#phoneProvider').val();
            var emailProvider = $('#emailProvider').val();
            if ($('#codeProvider').val() == "" || $('#nameProvider').val() == "" || $('#addressProvider').val() == ""
                || $('#phoneProvider').val() == "" || $('#emailProvider').val() == "") {
                alert("Introduzca datos");
                if (codeProvider == "" || codeProvider.length < 7) { $('#codeProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameProvider == "" || nameProvider.length < 5) { $('#nameProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (addressProvider == "" || addressProvider.length < 5) { $('#addressProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (phoneProvider == "" || phoneProvider.length < 7) { $('#phoneProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (emailProvider == "" || emailProvider.length < 3) { $('#emailProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
            } else { 
                $.ajax({
                    url : "{{ route('purchaseOrder.checkProvider') }}",
                    type : 'POST',
                    data : { codeProvider, nameProvider, addressProvider, phoneProvider, emailProvider },
                    success : function(response){
                        console.log(response);
                        $("#modal-add-provider").modal("hide");
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/purchaseOrder/index"); 
                    }
                })
            }
        });

        $("#cleanProvider").click(function(e){
            e.preventDefault();
            $('#codeProvider').val('');
            $('#nameProvider').val('');
            $('#addressProvider').val('');
            $('#phoneProvider').val('');
            $('#emailProvider').val('');
            $('#codeProvider').attr("class", "form-control col-md-12 my-1");
            $('#nameProvider').attr("class", "form-control col-md-12 my-1");
            $('#addressProvider').attr("class", "form-control col-md-12 my-1");
            $('#phoneProvider').attr("class", "form-control col-md-12 my-1");
            $('#emailProvider').attr("class", "form-control col-md-12 my-1");
        });

        var idArticle = "";
        $("#submitArticle").click(function(e){
            e.preventDefault();
            var codeArticle = $('#codeArticle').val();
            $.ajax({
                url : "{{ route('purchaseOrder.selectArticle') }}",
                type : 'POST',
                data : { codeArticle },
                success : function(response){
                    if (response.success != null) {
                        idArticle = response.success.id;
                        $('#nameArticle').val(response.success.nameArticle);
                        $('#currentStock').val(response.success3[0].currentStock);
                        $('#unitPriceArticle').val(response.success2[0].currentPrice);
                        $('#amountArticle').focus();
                    } else {
                        alert("Producto no existente/activo");
                        $('#codeArticle').focus();
                        $('#nameArticle').val('');
                        $('#amountArticle').val('');
                        $('#unitPriceArticle').val('');
                        $('#currentStock').val('');
                    }
                }
            })
        });

        $("#cancelArticle").click(function(e){
            e.preventDefault();
            $('#codeArticle').val('');
            $('#nameArticle').val('');
            $('#amountArticle').val('');
            $('#currentStock').val('');
            $('#unitPriceArticle').val('');
            $('#codeArticle').focus();
        })

        $("#addToListArticle").click(function(e){
            e.preventDefault();
            if ($('#codeArticle').val() == "" || $('#nameArticle').val() == "" || 
                $('#amountArticle').val() == "" || $('#unitPriceArticle').val() == "" ||
                parseInt($('#amountArticle').val()) < 1 || parseFloat($('#unitPriceArticle').val()) < 1.00) {
                    
                alert("Rellene los campos necesarios");
            
            } else {
                if ($('#codeArticle').val() != "" && $('#nameArticle').val() != "" &&
                    $('#amountArticle').val() != "" && $('#unitPriceArticle').val() != "" &&
                    parseInt($('#amountArticle').val()) >= 1 && parseFloat($('#unitPriceArticle').val()) > 1.00) {
                    
                    var codeArticle = $('#codeArticle').val();
                    var nameArticle = $('#nameArticle').val();
                    var amountArticle = $('#amountArticle').val();
                    var unitPriceArticle = $('#unitPriceArticle').val();
                    /*$('#codeArticle').val('');
                    $('#nameArticle').val('');
                    $('#amountArticle').val('');
                    $('#unitPriceArticle').val('');
                    $('#currentStock').val('');*/
                    
                    $.ajax({
                        url : "{{ route('purchaseOrder.addArticle') }}",
                        type : 'POST',
                        data : { idArticle, amountArticle, unitPriceArticle },
                        success : function(response){
                            console.log(response);
                            if (response == '0') {
                                alert("La cantidad tiene que ser mayor a cero");
                            } else {
                                document.getElementById("tableArticle").insertRow(-1).innerHTML = 
                                '<tr>'+
                                    '<th hidden>'+response.success.id+'</th>'+
                                    '<th hidden>'+idArticle+'</th>'+
                                    '<td>'+codeArticle+'</td>'+
                                    '<td>'+nameArticle+'</td>'+
                                    '<td>'+amountArticle+'</td>'+
                                    '<td>'+unitPriceArticle+'</td>'+
                                    '<td>'+
                                        '<div class="col">'+
                                            '<div class="row mx-auto my-2 w-100 justify-content-center">'+
                                                '<button type="button" class="btn btn-danger col-md-12 mx-auto btn-block deleteArticle">Eliminar</button>'+
                                            '</div>'+
                                        '</div>'+
                                    '</td>'+
                                '</tr>'
                            }

                            var price = parseFloat($('#unitPriceArticle').val()).toFixed(2);
                            var amount = $('#amountArticle').val();
                            var fstAmount = parseFloat(price) * parseInt(amount);

                            var nbrTable = document.getElementById("tableArticle").rows.length;
                            if (nbrTable == 1) { 
                                document.getElementById("tfootArticle").insertRow(-1).innerHTML = 
                                '<tr>'+
                                    '<td></td>'+
                                    '<td></td>'+
                                    '<td></td>'+
                                    '<td id="totalQuo">'+parseFloat(fstAmount).toFixed(2)+'</td>'+
                                    '<td></td>'+
                                '</tr>'   
                            } else {
                                if (nbrTable > 1) {
                                    var totalQuo = parseFloat($('#totalQuo').text()).toFixed(2);
                                    var newTotalQuo = parseFloat(totalQuo) + parseFloat(fstAmount);
                                    $('#totalQuo').text(parseFloat(newTotalQuo).toFixed(2));
                                }
                            }

                            $('#codeArticle').val('');
                            $('#nameArticle').val('');
                            $('#amountArticle').val('');
                            $('#unitPriceArticle').val('');
                            $('#currentStock').val('');
                            $('#codeArticle').focus();
                        }
                    })
                }
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
            });
        })

        $(document).on('click', '.cancel-detail', function (e) {
            e.preventDefault();
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idPurchase = $(info).find("th:eq(0)").text();

            var print = confirm("¿Desea cancelar la orden de compra?");
            if (print == true) { 
                $.ajax({ url : "{{ route('purchaseOrder.cancelDetail') }}", type : 'POST', data : {idPurchase}, success : function(response){
                        console.log(response); 
                        if (response >= 1 || response == '') { alert("Para consultar ordenes de compra canceladas, dirígase a reportes"); window.location.replace("http://127.0.0.1:8000/purchaseOrder/index"); }
                    }
                })

            }
        })

        $(document).on('click', '.deleteArticle', function () {
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idDetail = $(info).find("th:eq(0)").text();
            var idArticle = $(info).find("th:eq(1)").text();
            var amountArticle = $(info).find("td:eq(2)").text();
            var unitPriceArticle = $(info).find("td:eq(3)").text();
            $.ajax({
                url : "{{ route('purchaseOrder.deleteArticle') }}",
                type : 'POST',
                data : { idDetail, idArticle, amountArticle, unitPriceArticle },
                success : function(response){
                    console.log(response);
                    info.closest('tr').remove();
                }
            })  
            var lessForTotal = parseFloat(unitPriceArticle) * parseInt(amountArticle);
            /***/
            var totalQuo = parseFloat($('#totalQuo').text()).toFixed(2);
            var newTotalQuo = parseFloat(totalQuo) - parseFloat(lessForTotal);
            /***/
            $('#totalQuo').text(parseFloat(newTotalQuo).toFixed(2));
            var nbrTable = document.getElementById("tableArticle").rows.length;
            if (nbrTable == 1){
                var tfoot = $('#totalQuo')[0].parentElement;
                console.log(tfoot);
                tfoot.closest('tr').remove();
            }
        });

        $("#savePurchaseOrder").click(function(e){
            e.preventDefault()
            var nbrTable = document.getElementById("tableArticle").rows.length;
        
            if ($('#userPurchase').val() == "" || $('#codePurchase').val() == "" || $('#providerPurchase').val() == "" || $('#paymentPurchase').val() == "" || $('#descriptionPurchase').val() == "" || nbrTable == "" || nbrTable == 0) {
                alert("Faltan datos");
            } else {
                var userPurchase = $('#userPurchase').val();
                var codePurchase = $('#codePurchase').val();
                var providerPurchase = $('#providerPurchase').val();
                var paymentPurchase = $('#paymentPurchase').val();
                var descriptionPurchase = $('#descriptionPurchase').val();
                $.ajax({
                    url : "{{ route('purchaseOrder.store') }}",
                    type : 'POST',
                    data : { userPurchase, codePurchase, providerPurchase, paymentPurchase, descriptionPurchase },
                    success : function(response){
                        console.log(response);
                        
                        alert("Procesando...");
                        
                        if (response >= 1 || response == '') { alert("Orden de compra guardada, presione Ctrl+Shift+R para actualizar. Podrá imprimir la O/C en el menú principal");  

                            $('#providerPurchase').val(0);
                            $('#paymentPurchase').val(0);
                            $('#descriptionPurchase').val('');
                            $("#tableArticle tr").remove();
                        }
                    

                    }
                })
            }
        });

        $("#cancelPurchaseOrder").click(function(e){
            e.preventDefault();
            var print = confirm("¿Desea cancelar la orden de compra?");
            if (print == true) { window.location.replace("http://127.0.0.1:8000/purchaseOrder/index"); }
        });


        $('#descriptionPurchase').keypress(function(e){
            $('#descriptionPurchase').attr("maxlength", "120"); $('#descriptionPurchase').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#codeArticle').keypress(function(e){
            $('#codeArticle').attr("maxlength", "20"); $('#codeArticle').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $('#amountArticle').keypress(function(e){ $('#amountArticle').attr("maxlength", "3");
            $('#amountArticle').attr("class", "form-control"); var key = e.keyCode || e.which;
            var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789"; if(numeros.indexOf(tecla) == -1){ return false; }
        });

        $('#unitPriceArticle').keypress(function(e){
            $('#unitPriceArticle').attr("maxlength", "15"); $('#unitPriceArticle').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "1234567890.,";
            if(letras.indexOf(tecla) == -1){ return false; }
        });


        $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });






























        $('#codeProvider').keypress(function(e){ $('#codeProvider').attr("maxlength", "12");
            $('#codeProvider').attr("maxlength", "12"); $('#codeProvider').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "1234567890verj-";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#nameProvider').keypress(function(e){
            $('#nameProvider').attr("maxlength", "40"); $('#nameProvider').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#addressProvider').keypress(function(e){
            $('#addressProvider').attr("maxlength", "120"); $('#addressProvider').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#phoneProvider').keypress(function(e){ $('#phoneProvider').attr("maxlength", "11");
            $('#phoneProvider').attr("class", "form-control col-md-12 my-1"); var key = e.keyCode || e.which;
            var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789"; if(numeros.indexOf(tecla) == -1){ return false; }
        });
        document.getElementById('emailProvider').addEventListener('input', function() {
          campo = event.target;
          emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
          if (emailRegex.test(campo.value)) {
            $('#emailProvider').attr("class", "form-control col-md-12 my-1");
          } else {
            $('#emailProvider').attr("class", "form-control col-md-12 my-1 is-invalid");
          }
        });

    });
</script>
@endsection('scripts')
