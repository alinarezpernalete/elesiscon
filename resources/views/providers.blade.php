@extends('layouts.app')

@section('title', 'Proveedores')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-proveedores">Listar proveedores</a>
                                    </li>
                                    @if(Auth::user()->name == "Administrador")
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#registrar-proveedor">Registrar proveedor</a>
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
                    <div class="tab-pane fade active show" id="listar-proveedores"> 
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/providers/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeProvider">Código de proveedor</option>
                                                <option value="nameProvider">Nombre de proveedor</option>
                                                <option value="addressProvider">Dirección</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/providers/index" id="clean">Limpiar</button>
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
                                            <tbody id="tableProvider">
                                               @foreach ($providers as $provider)
                                                    <tr>
                                                        <th scope="row" hidden="hidden">{{ $provider->id }}</th>
                                                        <th scope="row">{{ $provider->codeProvider }}</th>
                                                        <td>{{ $provider->nameProvider }}</td>
                                                        <td>{{ $provider->addressProvider }}</td>
                                                        <td>{{ $provider->phoneProvider }}</td>
                                                        <td>{{ $provider->emailProvider }}</td>
                                                        <td>
                                                            <div class="col">
                                                                <div class="row mx-auto my-2 w-100 justify-content-center">
                                                                    <button type="button" class="btn btn-outline-danger col-md-12 mx-auto btn-block desactiveProvider" data-toggle="modal">Inactivar</button>
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
                                    {{ $providers->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------------------------------>
                    <div class="tab-pane fade" id="registrar-proveedor">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Código de proveedor" id="codeProvider">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Nombre" id="nameProvider">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Dirección" id="addressProvider">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Teléfono" id="phoneProvider">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control col-md-12 my-1" rows="3" placeholder="Email" id="emailProvider" maxlength="180"></textarea>
                                </div>
                            </div>
                            <hr class="my-3">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary col my-2" id="saveProvider">Guardar</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-warning col my-2" id="cleanProvider">Limpiar campos</button>
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
        $("#cleanProvider").click(function(e){
            $('#codeProvider').val('');
            $('#nameProvider').val('');
            $('#addressProvider').val('');
            $('#phoneProvider').val('');
            $('#emailProvider').val('');
            ///////////////////////////////////////////////////////////////////
            $('#codeProvider').attr("class", "form-control col-md-12 my-1");
            $('#nameProvider').attr("class", "form-control col-md-12 my-1");
            $('#addressProvider').attr("class", "form-control col-md-12 my-1");
            $('#phoneProvider').attr("class", "form-control col-md-12 my-1");
            $('#emailProvider').attr("class", "form-control col-md-12 my-1");
        });
        $('#codeProvider').keypress(function(e){
            $('#codeProvider').attr("maxlength", "12"); $('#codeProvider').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = "jev-1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#nameProvider').keypress(function(e){
            $('#nameProvider').attr("maxlength", "50"); $('#nameProvider').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#addressProvider').keypress(function(e){
            $('#addressProvider').attr("maxlength", "180"); $('#addressProvider').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#phoneProvider').keypress(function(e){ $('#phoneProvider').attr("maxlength", "11");
            $('#phoneProvider').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789";
            if(numeros.indexOf(tecla) == -1){ return false; }
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
            
            if ($('#codeProvider').val() == "" || $('#nameProvider').val() == "" || $('#addressProvider').val() == "" || $('#phoneProvider').val() == "" || $('#emailProvider').val() == "") {
                alert("Introduzca datos correctos");
                if (codeProvider == "" || codeProvider.length < 7) { alert("Código requerido"); $('#codeProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (nameProvider == "" || nameProvider.length < 7) { alert("Nombre requerido"); $('#nameProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (addressProvider == "" || addressProvider.length < 7) { alert("Dirección requerido"); $('#addressProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (phoneProvider == "" || phoneProvider.length < 11) { alert("Número de tlf. requerido"); $('#phoneProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (emailProvider == "" || emailProvider.length < 3) { $('#emailProvider').attr("class", "form-control col-md-12 my-1 is-invalid"); }
            } else {
                $.ajax({
                    url : "{{ route('providers.store') }}",
                    type : 'POST',
                    data : { codeProvider,nameProvider,addressProvider,phoneProvider,emailProvider },
                    success : function(response){
                        console.log(response);
                        if (response != '0') { 
                            alert("Proveedor registrado");
                            window.location.replace("http://127.0.0.1:8000/providers/index");
                        }
                    }
                })
            }
        });
        $(".desactiveProvider").click(function(e){
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var id = $(info).find("th:eq(0)").text();
            var print = confirm("¿Desea inactivar el proveedor?");
            if (print == true) { 
                $.ajax({ url : "{{ route('providers.desactiveProvider') }}", type : 'POST', data : { id },
                    success : function(response){
                        if (response == 1) {
                            alert("Información actualizada");
                            window.location.replace("http://127.0.0.1:8000/providers/index");
                        }
                    }
                })
            }
        });
    });
</script>
@endsection('scripts')
