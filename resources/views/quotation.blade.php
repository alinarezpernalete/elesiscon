@extends('layouts.app')

@section('title', 'Cotización')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-cotizaciones">Listar cotizaciones</a>
                                    </li> 
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#generar-cotizacion">Generar cotización</a>
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
                    <div class="tab-pane fade active show" id="listar-cotizaciones">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/quotation/index" method="GET">
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
                                                <button class="btn btn-outline-secondary" href="/quotation/index" id="clean">Limpiar</button>
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
                                            <tbody id="tableQuotation">
                                                @foreach ($quotations as $quotation)
                                                    @if($quotation->typeSale == 1)
                                                        <tr>
                                                            <th hidden="hidden">{{ $quotation->id }}</th>
                                                            <th scope="row">{{ $quotation->codeSale }}</th>
                                                            <td>{{ $quotation->nameCustomer }}</td>
                                                            <td>{{ $quotation->namePayment }}</td>
                                                            <td>Pendiente para pedido</td>
                                                            <td>{{ $quotation->descriptionSale }}</td>
                                                            <td>{{ $quotation->name }}</td>
                                                            <td>{{ $quotation->created_at }}</td>
                                                            <td>
                                                                <div class="col">
                                                                    <div class="row mx-auto w-100 justify-content-center">
                                                                        <button type="button" class="btn btn-success col-md-12 mx-auto btn-block find-detail" data-toggle="modal">Ver</button>
                                                                        <a href="/quotation/print?idSale={{ $quotation->id }}" class="btn btn-outline-success col-md-12 mx-auto btn-block">Imprimir</a>
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
                                    {{ $quotations->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('modals.quotation.modal-find-detail')
                    <div class="tab-pane fade" id="generar-cotizacion">
                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" data-toggle="modal" data-target="#modal-add-customer">Registrar cliente</button>
                            </div>
                            <div class="form-group mt-3">
                                <div class="row">
                                    <input type="text" id="userSale" class="form-control col-md-12 my-1" hidden="hidden" value="{{ auth()->user()->id }}">
                                    <div class="col">
                                        @if (isset($quotations->first()->codeSale))
                                            <input type="text" id="codeSale" class="form-control col-md-12 my-1" value="CS{{substr($quotations->first()->codeSale, 2, 300)+1}}" disabled="">
                                        @else
                                            <input type="text" id="codeSale" class="form-control col-md-12 my-1" value="CS1" disabled="">
                                        @endif
                                    </div>
                                    <div class="col">
                                        <select class="browser-default custom-select col-md-12 my-1" id="customerSale">
                                            <option selected="" disabled="" value="0">Cliente</option>
                                            @foreach ( $customers as $customer )
                                                @if ($customer->statusCustomer == 1)
                                                    <option value="{{ $customer->id }}">{{ $customer->codeCustomer }} - {{ $customer->nameCustomer }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <select class="browser-default custom-select col-md-12 my-1" id="paymentSale">
                                            <option selected="" disabled="" value="0">Cond. Pago</option>
                                            @foreach ( $paymentConditions as $paymentCondition )
                                                <option value="{{ $paymentCondition->id }}">{{ $paymentCondition->codePayment }} - {{ $paymentCondition->namePayment }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col">
                                        <input type="text" id="descriptionSale" class="form-control col-md-12 my-1" placeholder="Descripción">
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
                                            <input type="text" class="form-control" placeholder="Artículo" id="nameArticle" disabled="">
                                            <input type="text" class="form-control" placeholder="Cantidad" id="amountArticle" disabled="">
                                            <input type="text" class="form-control" placeholder="Cant. disponible" id="currentStock" disabled="">
                                            <input type="text" class="form-control" placeholder="Precio unit." id="unitPriceArticle" disabled="">
                                            <div class="input-group-append">
                                                <button class="btn btn-success" id="addToListArticle">Aceptar</button>
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
                                        <button type="submit" class="btn btn-primary col" id="saveQuotation">Guardar</button>
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-outline-danger col" id="cancelQuotation">Cancelar</button>
                                    </div>
                                </div>
                            </div>
                            @include('modals.quotation.modal-add-customer')
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
            url : "{{ route('quotation.deleteOnUnload') }}",
            type : 'GET',
            success : function(response){
                console.log(response);
            }
        })

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
        
        $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        var nbrTable = document.getElementById("tableQuotation").rows.length;
        if (nbrTable == 0) { 
            document.getElementById("tableQuotation").insertRow(-1).innerHTML = 
            '<tr>'+
                '<td colspan="8"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen cotizaciones actuales</div></td>'+
            '</tr>';
        }

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $("#saveCustomer").click(function(e){
            e.preventDefault();
            var codeCustomer = $('#codeCustomer').val();
            var nameCustomer = $('#nameCustomer').val();
            var addressCustomer = $('#addressCustomer').val();
            var phoneCustomer = $('#phoneCustomer').val();
            var emailCustomer = $('#emailCustomer').val();
            if ($('#codeCustomer').val() == "" || $('#nameCustomer').val() == "" || $('#addressCustomer').val() == ""
                || $('#phoneCustomer').val() == "" || $('#emailCustomer').val() == "") {
                alert("Introduzca datos");
                if (codeCustomer == "" || codeCustomer.length < 7) { $('#codeCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameCustomer == "" || nameCustomer.length < 5) { $('#nameCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (addressCustomer == "" || addressCustomer.length < 5) { $('#addressCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (phoneCustomer == "" || phoneCustomer.length < 7) { $('#phoneCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (emailCustomer == "" || emailCustomer.length < 3) { $('#emailCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
            } else {
                $.ajax({
                    url : "{{ route('quotation.checkCustomer') }}",
                    type : 'POST',
                    data : { codeCustomer, nameCustomer, addressCustomer, phoneCustomer, emailCustomer },
                    success : function(response){
                        console.log(response);
                        $("#modal-add-customer").modal("hide");
                        alert("Esta ventana se actualizará");
                        window.location.replace("http://127.0.0.1:8000/quotation/index"); 
                    }
                })
            }
        });

        $("#cleanCustomer").click(function(e){
            e.preventDefault();
            $('#codeCustomer').val('');
            $('#nameCustomer').val('');
            $('#addressCustomer').val('');
            $('#phoneCustomer').val('');
            $('#emailCustomer').val('');
            $('#codeCustomer').attr("class", "form-control col-md-12 my-1");
            $('#nameCustomer').attr("class", "form-control col-md-12 my-1");
            $('#addressCustomer').attr("class", "form-control col-md-12 my-1");
            $('#phoneCustomer').attr("class", "form-control col-md-12 my-1");
            $('#emailCustomer').attr("class", "form-control col-md-12 my-1");
        });

        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })

        var idArticle = "";
        $("#submitArticle").click(function(e){
            e.preventDefault();
            var codeArticle = $('#codeArticle').val();
            $.ajax({
                url : "{{ route('quotation.selectArticle') }}",
                type : 'POST',
                data : { codeArticle },
                success : function(response){
                    if (response.success != null) {
                        idArticle = response.success.id;
                        $('#nameArticle').val(response.success.nameArticle);
                        $('#unitPriceArticle').val(response.success2[0].currentPrice);
                        $('#currentStock').val(response.success3[0].currentStock);
                        $('#amountArticle').focus();
                        $("#amountArticle").prop('disabled', false);
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
            $('#unitPriceArticle').val('');
            $('#currentStock').val('');
            $('#codeArticle').focus();
            $("#amountArticle").prop('disabled', true);
        })

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

        $(document).on('click', '.cancel-detail', function (e) {
            e.preventDefault();
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idSale = $(info).find("th:eq(0)").text();

            var print = confirm("¿Desea cancelar la cotización?");
            if (print == true) { 
                $.ajax({ url : "{{ route('quotation.cancelDetail') }}", type : 'POST', data : { idSale }, success : function(response){
                        console.log(response); 
                        if (response >= 1 || response == '') { alert("Para consultar cotizaciones canceladas, dirígase a reportes"); window.location.replace("http://127.0.0.1:8000/quotation/index"); }
                    }
                })

            }
        })

        $("#addToListArticle").click(function(e){
            e.preventDefault();
            if ($('#codeArticle').val() == "" || $('#nameArticle').val() == "" || 
                $('#amountArticle').val() == "" || $('#unitPriceArticle').val() == "" ||
                parseInt($('#amountArticle').val()) < 1) {
                    
                alert("Rellene los campos necesarios");
            
            } else {
                if ($('#codeArticle').val() != "" && $('#nameArticle').val() != "" &&
                    $('#amountArticle').val() != "" && $('#unitPriceArticle').val() != "" &&
                    parseInt($('#amountArticle').val()) >= 1) {
                    
                    var codeArticle = $('#codeArticle').val();
                    var nameArticle = $('#nameArticle').val();
                    var amountArticle = $('#amountArticle').val();
                    var unitPriceArticle = $('#unitPriceArticle').val();
                    /*$('#codeArticle').val('');
                    $('#nameArticle').val('');
                    $('#amountArticle').val('');
                    $('#unitPriceArticle').val('');*/
                    
                    $.ajax({
                        url : "{{ route('quotation.addArticle') }}",
                        type : 'POST',
                        data : { idArticle, amountArticle, unitPriceArticle },
                        success : function(response){
                            console.log(response);
                            if (response == '0') {
                                alert("La cantidad sobrepasa la cantidad de artículos para cotizar");
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

                            //////////////
                            //////////////
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
                            $('#currentStock').val('');
                            $('#amountArticle').prop('disabled', true);
                            $('#unitPriceArticle').val('');
                            $('#codeArticle').focus();
                        }
                    })
                }
            }
        });

        $(document).on('click', '.deleteArticle', function () {
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var idDetail = $(info).find("th:eq(0)").text();
            var idArticle = $(info).find("th:eq(1)").text();
            var amountArticle = $(info).find("td:eq(2)").text();
            var unitPriceArticle = $(info).find("td:eq(3)").text();
            $.ajax({
                url : "{{ route('quotation.deleteArticle') }}",
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

        $("#saveQuotation").click(function(e){
            e.preventDefault()
            var nbrTable = document.getElementById("tableArticle").rows.length;
        
            if ($('#userSale').val() == "" || $('#codeSale').val() == "" || $('#customerSale').val() == "" || $('#paymentSale').val() == "" || $('#descriptionSale').val() == "" || nbrTable == "" || nbrTable == 0) {
                alert("Faltan datos");
            } else {
                var userSale = $('#userSale').val();
                var codeSale = $('#codeSale').val();
                var customerSale = $('#customerSale').val();
                var paymentSale = $('#paymentSale').val();
                var descriptionSale = $('#descriptionSale').val();
                $.ajax({
                    url : "{{ route('quotation.store') }}",
                    type : 'POST',
                    data : { userSale, codeSale, customerSale, paymentSale, descriptionSale },
                    success : function(response){
                        console.log(response);
                        
                        alert("Procesando...");

                        if (response >= 1 || response == '') {
                            alert("Cotización guardada, presione Ctrl+Shift+R para actualizar. Podrá imprimir la cotización en el menú principal"); 
                            $('#customerSale').val(0);
                            $('#paymentSale').val(0);
                            $('#descriptionSale').val('');
                            $("#tableArticle tr").remove();
                        }
                    }
                })
            }
        });

        $("#cancelQuotation").click(function(e){
            e.preventDefault();
            var print = confirm("¿Desea cancelar la cotización?");
            if (print == true) { window.location.replace("http://127.0.0.1:8000/quotation/index"); }
        });


        $('#descriptionSale').keypress(function(e){
            $('#descriptionSale').attr("maxlength", "120"); $('#descriptionSale').attr("class", "form-control col-md-12 my-1");
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

        



























        $('#codeCustomer').keypress(function(e){ $('#codeCustomer').attr("maxlength", "12");
            $('#codeCustomer').attr("maxlength", "12"); $('#codeCustomer').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "1234567890verj-";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#nameCustomer').keypress(function(e){
            $('#nameCustomer').attr("maxlength", "40"); $('#nameCustomer').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#addressCustomer').keypress(function(e){
            $('#addressCustomer').attr("maxlength", "120"); $('#addressCustomer').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#phoneCustomer').keypress(function(e){ $('#phoneCustomer').attr("maxlength", "11");
            $('#phoneCustomer').attr("class", "form-control col-md-12 my-1"); var key = e.keyCode || e.which;
            var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789"; if(numeros.indexOf(tecla) == -1){ return false; }
        });
        document.getElementById('emailCustomer').addEventListener('input', function() {
          campo = event.target;
          emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
          if (emailRegex.test(campo.value)) {
            $('#emailCustomer').attr("class", "form-control col-md-12 my-1");
          } else {
            $('#emailCustomer').attr("class", "form-control col-md-12 my-1 is-invalid");
          }
        });
    














    });
</script>
@endsection('scripts')
