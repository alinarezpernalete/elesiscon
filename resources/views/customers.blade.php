@extends('layouts.app')

@section('title', 'Clientes')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-clientes">Listar clientes</a>
                                    </li>
                                    @if(Auth::user()->name == "Administrador")
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#registrar-cliente">Registrar cliente</a>
                                    </li>
                                    @endif 
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
                    <div class="tab-pane fade active show" id="listar-clientes"> 
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/customers/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeCustomer">Código de cliente</option>
                                                <option value="nameCustomer">Nombre de cliente</option>
                                                <option value="addressCustomer">Dirección</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/customers/index" id="clean">Limpiar</button>
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
                                                    <th scope="col">Nombre</th>
                                                    <th scope="col">Dirección</th>
                                                    <th scope="col">Teléfono</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableCustomer">
                                               @foreach ($customers as $customer)
                                                    <tr>
                                                        <th scope="row" hidden="hidden">{{ $customer->id }}</th>
                                                        <th scope="row">{{ $customer->codeCustomer }}</th>
                                                        <td>{{ $customer->nameCustomer }}</td>
                                                        <td>{{ $customer->addressCustomer }}</td>
                                                        <td>{{ $customer->phoneCustomer }}</td>
                                                        <td>{{ $customer->emailCustomer }}</td>
                                                        <td>
                                                            <div class="col">
                                                                <div class="row mx-auto my-2 w-100 justify-content-center">
                                                                    <button type="button" class="btn btn-outline-danger col-md-12 mx-auto btn-block desactiveCustomer" data-toggle="modal">Inactivar</button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-3">
                                    {{ $customers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------------------------------>
                    <div class="tab-pane fade" id="registrar-cliente">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Código de cliente" id="codeCustomer">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Nombre" id="nameCustomer">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Dirección" id="addressCustomer">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Teléfono" id="phoneCustomer">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control col-md-12 my-1" rows="3" placeholder="Email" id="emailCustomer" maxlength="180"></textarea>
                                </div>
                            </div>
                            <hr class="my-3">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary col my-2" id="saveCustomer">Guardar</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-warning col my-2" id="cleanCustomer">Limpiar campos</button>
                                </div>
                            </div>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
                $('#search').keypress(function(e){
            $('#search').attr("maxlength", "50"); $('#search').attr("class", "form-control");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz,-_/1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $("#cleanCustomer").click(function(e){
            $('#codeCustomer').val('');
            $('#nameCustomer').val('');
            $('#addressCustomer').val('');
            $('#phoneCustomer').val('');
            $('#emailCustomer').val('');
            ///////////////////////////////////////////////////////////////////
            $('#codeCustomer').attr("class", "form-control col-md-12 my-1");
            $('#nameCustomer').attr("class", "form-control col-md-12 my-1");
            $('#addressCustomer').attr("class", "form-control col-md-12 my-1");
            $('#phoneCustomer').attr("class", "form-control col-md-12 my-1");
            $('#emailCustomer').attr("class", "form-control col-md-12 my-1");
        });
        $('#codeCustomer').keypress(function(e){
            $('#codeCustomer').attr("maxlength", "12"); $('#codeCustomer').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "jev-1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#nameCustomer').keypress(function(e){
            $('#nameCustomer').attr("maxlength", "50"); $('#nameCustomer').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#addressCustomer').keypress(function(e){
            $('#addressCustomer').attr("maxlength", "180"); $('#addressCustomer').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#phoneCustomer').keypress(function(e){ $('#phoneCustomer').attr("maxlength", "11");
            $('#phoneCustomer').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789";
            if(numeros.indexOf(tecla) == -1){ return false; }
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
        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })
        $("#saveCustomer").click(function(e){
            e.preventDefault();
            var codeCustomer = $('#codeCustomer').val();
            var nameCustomer = $('#nameCustomer').val();
            var addressCustomer = $('#addressCustomer').val();
            var phoneCustomer = $('#phoneCustomer').val();
            var emailCustomer = $('#emailCustomer').val();
            
            if ($('#codeCustomer').val() == "" || $('#nameCustomer').val() == "" || $('#addressCustomer').val() == "" || $('#phoneCustomer').val() == "" || $('#emailCustomer').val() == "") {
                alert("Introduzca datos correctos");
                if (codeCustomer == "" || codeCustomer.length < 7) { alert("Código requerido"); $('#codeCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameCustomer == "" || nameCustomer.length < 7) { alert("Nombre requerido"); $('#nameCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (addressCustomer == "" || addressCustomer.length < 7) { alert("Dirección requerido"); $('#addressCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (phoneCustomer == "" || phoneCustomer.length < 11) { alert("Número de tlf. requerido"); $('#phoneCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (emailCustomer == "" || emailCustomer.length < 3) { $('#emailCustomer').attr("class", "form-control col-md-12 my-1 is-invalid"); }
            } else {
                $.ajax({
                    url : "{{ route('customers.store') }}",
                    type : 'POST',
                    data : { codeCustomer,nameCustomer,addressCustomer,phoneCustomer,emailCustomer },
                    success : function(response){
                        console.log(response);
                        if (response != '0') { 
                            alert("Cliente registrado");
                            window.location.replace("http://127.0.0.1:8000/customers/index");
                        }
                    }
                })
            }
        });
        $(".desactiveCustomer").click(function(e){
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var id = $(info).find("th:eq(0)").text();
            var print = confirm("¿Desea inactivar el cliente?");
            if (print == true) { 
                $.ajax({ url : "{{ route('customers.desactiveCustomer') }}", type : 'POST', data : { id },
                    success : function(response){
                        if (response == 1) {
                            alert("Información actualizada");
                            window.location.replace("http://127.0.0.1:8000/customers/index");
                        }
                    }
                })
            }
        });
    });
</script>
@endsection('scripts')
