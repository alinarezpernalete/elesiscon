@extends('layouts.app')

@section('title', 'Empleados')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#listar-empleados">Listar empleados</a>
                                    </li>
                                    @if(Auth::user()->name == "Administrador")
                                    <li class="nav-item">
                                        <a class="nav-link mx-auto" data-toggle="tab" href="#registrar-empleado">Registrar empleado</a>
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
                    <div class="tab-pane fade active show" id="listar-empleados"> 
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <form action="/employees/index" method="GET">
                                        <div class="input-group mb-3">
                                            <input type="text" class="form-control" placeholder="Ingrese búsqueda" aria-describedby="basic-addon2" name="search" type="search" id="search">
                                            
                                            <select class="browser-default custom-select col-md-12" name="filterSearch" id="filterSearch">
                                                <option selected="" disabled="" value="0">Filtro de búsqueda</option>
                                                <option value="codeEmployee">CI</option>
                                                <option value="firstNameEmployee">Nombres</option>
                                                <option value="lastNameEmployee">Apellidos</option>
                                            </select>

                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                                                <button class="btn btn-outline-secondary" href="/employees/index" id="clean">Limpiar</button>
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
                                                    <th scope="col">CI</th>
                                                    <th scope="col">Nombres</th>
                                                    <th scope="col">Apellidos</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableEmployee">
                                               @foreach ($employees as $employee)
                                                    <tr>
                                                        <th scope="row" hidden="hidden">{{ $employee->id }}</th>
                                                        <th scope="row">{{ $employee->codeEmployee }}</th>
                                                        <td>{{ $employee->firstNameEmployee }}</td>
                                                        <td>{{ $employee->lastNameEmployee }}</td>
                                                        <td>
                                                            <div class="col">
                                                                <div class="row mx-auto my-2 w-100 justify-content-center">
                                                                    <button type="button" class="btn btn-success col-md-12 mx-auto btn-block btnAdditionalEmployee" data-toggle="modal" data-target="#modal-additional-employee">Ver más</button>
                                                                     <button type="button" class="btn btn-outline-danger col-md-12 mx-auto btn-block desactiveEmployee" data-toggle="modal">Inactivar</button>
                                                                </div>
                                                            </div>
                                                            @include('modals.employees.modal-additional-employee')
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-8 mt-3">
                                    {{ $employees->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------------------------------>
                    <div class="tab-pane fade" id="registrar-empleado">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="CI" id="codeEmployee">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Nombres" id="firstNameEmployee">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Apellidos" id="lastNameEmployee">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Fecha de nacimiento" id="birthDateEmployee">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="genderEmployee">
                                        <option selected="" disabled="" value="0">Genero</option>
                                            <option value="M">M</option>
                                            <option value="F">F</option>
                                    </select>
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Teléfono" id="phoneEmployee">
                                </div>
                                <div class="col"> 
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Información adicional" id="additionalEmployee">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Fecha de ingreso" id="joinDateEmployee">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="departmentEmployee">
                                        <option selected="" disabled="" value="0">Departamento</option>
                                        @foreach ( $departments as $department )
                                            <option value="{{ $department->id }}">{{ $department->codeDepartment }} - {{ $department->nameDepartment }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="jobEmployee">
                                        <option selected="" disabled="" value="0">Cargo</option>
                                        @foreach ( $jobs as $job )
                                            <option value="{{ $job->id }}">{{ $job->codeJob }} - {{ $job->nameJob }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control col-md-12 my-1" rows="3" placeholder="Dirección" id="addressEmployee" maxlength="180"></textarea>
                                </div>
                            </div>
                            <hr class="my-3">
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary col my-2" id="saveEmployee">Guardar</button>
                                </div>
                                <div class="col">
                                    <button class="btn btn-warning col my-2" id="cleanEmployee">Limpiar campos</button>
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
        $("#cleanEmployee").click(function(e){
            $('#codeEmployee').val(''); $('#firstNameEmployee').val(''); $('#lastNameEmployee').val(''); 
            $('#birthDateEmployee').val(''); $('#departmentEmployee').val(0); $('#jobEmployee').val(0); 
            $('#phoneEmployee').val(''); $('#joinDateEmployee').val('');
            $('#genderEmployee').val(0);
            $('#additionalEmployee').val('');
            ///////////////////////////////////////////////////////////////////
            $('#codeEmployee').attr("class", "form-control col-md-12 my-1"); 
            $('#firstNameEmployee').attr("class", "form-control col-md-12 my-1");
            $('#lastNameEmployee').attr("class", "form-control col-md-12 my-1");
            $('#phoneEmployee').attr("class", "form-control col-md-12 my-1");
            $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1");
            $('#departmentEmployee').attr("class", "browser-default custom-select col-md-12 my-1");
            $('#jobEmployee').attr("class", "browser-default custom-select col-md-12 my-1");
            $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1");
            $('#genderEmployee').attr("class", "browser-default custom-select col-md-12 my-1");
            $('#additionalEmployee').attr("class", "form-control col-md-12 my-1");
        });
        $('#codeEmployee').keypress(function(e){ $('#codeEmployee').attr("maxlength", "8");
            $('#codeEmployee').attr("class", "form-control col-md-12 my-1"); var key = e.keyCode || e.which;
            var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789"; if(numeros.indexOf(tecla) == -1){ return false; }
        });
        $('#firstNameEmployee').keypress(function(e){
            $('#firstNameEmployee').attr("maxlength", "25"); $('#firstNameEmployee').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#lastNameEmployee').keypress(function(e){
            $('#lastNameEmployee').attr("maxlength", "25"); $('#lastNameEmployee').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#phoneEmployee').keypress(function(e){ $('#phoneEmployee').attr("maxlength", "11");
            $('#phoneEmployee').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789";
            if(numeros.indexOf(tecla) == -1){ return false; }
        });
        $('#birthDateEmployee').click(function(e){ 
            $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1");
        });
        $('#departmentEmployee').click(function(e){ 
            $('#departmentEmployee').attr("class", "browser-default custom-select col-md-12 my-1"); });
        $('#jobEmployee').click(function(e){ 
            $('#jobEmployee').attr("class", "browser-default custom-select col-md-12 my-1"); });
        $('#joinDateEmployee').click(function(e){ 
            $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1");
        });
        $('#genderEmployee').click(function(e){ 
            $('#genderEmployee').attr("class", "browser-default custom-select col-md-12 my-1");
        });
        $('#additionalEmployee').keypress(function(e){ $('#additionalEmployee').attr("maxlength", "180");
            $('#additionalEmployee').attr("maxlength", "180"); $('#additionalEmployee').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $(document).on('click', '#clean', function(){
            $("#search").val('');
            $("#filterSearch").val('0');
        })
        function birthDate(){
            var fecha = new Date();
            var diaActual =  parseInt(fecha.getDate());
            var mesActual = parseInt(fecha.getMonth()+1);
            var añoActual = parseInt(fecha.getFullYear());
            ////////////////////////////////////////////////////////////
            console.log(diaActual+"-"+mesActual+"-"+añoActual);
            var birthDate = $('#birthDateEmployee').val();
            var dia = parseInt(birthDate.substring(8,10));
            var mes = parseInt(birthDate.substring(5,7));
            var año = parseInt(birthDate.substring(0,4));
            console.log(dia+"-"+mes+"-"+año);
            ////////////////////////////////////////////////////////////
            if(año > añoActual){
                console.log("Año inválido");
                $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
            } else {
                if(año == añoActual && mes < mesActual && dia < diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes == mesActual && dia < diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes == mesActual && dia == diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes < mesActual && dia > diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes < mesActual && dia == diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes == mesActual && dia > diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                }
                if(año == añoActual && mes > mesActual && dia > diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                }
                if(año == añoActual && mes > mesActual && dia == diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                }
                if(año == añoActual && mes > mesActual && dia < diaActual){
                    console.log("Mismo año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                }
                /////////////////////////////////////////////////
                if(año < añoActual && mes == mesActual && dia == diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes < mesActual && dia == diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes < mesActual && dia < diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes > mesActual && dia > diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes > mesActual && dia == diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes == mesActual && dia > diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes == mesActual && dia < diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes < mesActual && dia > diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes > mesActual && dia < diaActual){
                    console.log("Pasado año");
                    $('#birthDateEmployee').attr("class", "form-control form-control col-md-12 my-1"); 
                }
            }
        }
        function joinDate(){
            var fecha = new Date();
            var diaActual =  parseInt(fecha.getDate());
            var mesActual = parseInt(fecha.getMonth()+1);
            var añoActual = parseInt(fecha.getFullYear());
            ////////////////////////////////////////////////////////////
            console.log(diaActual+"-"+mesActual+"-"+añoActual);
            var joinDate = $('#joinDateEmployee').val();
            var dia = parseInt(joinDate.substring(8,10));
            var mes = parseInt(joinDate.substring(5,7));
            var año = parseInt(joinDate.substring(0,4));
            console.log(dia+"-"+mes+"-"+año);
            ////////////////////////////////////////////////////////////
            if(año > añoActual){
                console.log("Año inválido");
                $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
            } else {
                if(año == añoActual && mes < mesActual && dia < diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes == mesActual && dia < diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes == mesActual && dia == diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes < mesActual && dia > diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes < mesActual && dia == diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año == añoActual && mes == mesActual && dia > diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                }
                if(año == añoActual && mes > mesActual && dia > diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                }
                if(año == añoActual && mes > mesActual && dia == diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                }
                if(año == añoActual && mes > mesActual && dia < diaActual){
                    console.log("Mismo año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                }
                /////////////////////////////////////////////////
                if(año < añoActual && mes == mesActual && dia == diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes < mesActual && dia == diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes < mesActual && dia < diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes > mesActual && dia > diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes > mesActual && dia == diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes == mesActual && dia > diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes == mesActual && dia < diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes < mesActual && dia > diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control form-control col-md-12 my-1"); 
                }
                if(año < añoActual && mes > mesActual && dia < diaActual){
                    console.log("Pasado año");
                    $('#joinDateEmployee').attr("class", "form-control form-control col-md-12 my-1"); 
                }
            }
        }
        $("#birthDateEmployee").change(function(e){ birthDate($(this),e) })
        $("#joinDateEmployee").change(function(e){ joinDate($(this),e) })
        $("#saveEmployee").click(function(e){
            e.preventDefault();
            var codeEmployee = $('#codeEmployee').val();
            var firstNameEmployee = $('#firstNameEmployee').val();
            var lastNameEmployee = $('#lastNameEmployee').val();
            var birthDateEmployee = $('#birthDateEmployee').val();
            var departmentEmployee = $('#departmentEmployee').val();
            var jobEmployee = $('#jobEmployee').val();
            var phoneEmployee = $('#phoneEmployee').val();
            var joinDateEmployee = $('#joinDateEmployee').val();
            var genderEmployee = $('#genderEmployee').val();
            var additionalEmployee = $('#additionalEmployee').val();
            var addressEmployee = $('#addressEmployee').val();
            if ($('#codeEmployee').val() == "" || $('#firstNameEmployee').val() == "" || $('#lastNameEmployee').val() == "" || $('#birthDateEmployee').val() == "" || $('#departmentEmployee').val() == 0 || $('#jobEmployee').val() == 0 || $('#phoneEmployee').val() == "" || $('#joinDateEmployee').val() == "" || $('#genderEmployee').val() == 0 || $('#additionalEmployee').val() == "") {
                alert("Introduzca datos correctos");
                if (codeEmployee == "" || codeEmployee.length < 7) { alert("CI requerida"); $('#codeEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (firstNameEmployee == "" || firstNameEmployee.length < 7) { alert("Nombres requerido"); $('#firstNameEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (lastNameEmployee == "" || lastNameEmployee.length < 7) { alert("Apellidos requerido"); $('#lastNameEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (birthDateEmployee == "" || birthDateEmployee == null) { alert("Fecha de nacimiento requerida"); $('#birthDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (departmentEmployee == "" || departmentEmployee == null || departmentEmployee == 0) { alert("Departamento requerido"); $('#departmentEmployee').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (jobEmployee == "" || jobEmployee == null || jobEmployee == 0) { alert("Cargo requerido"); $('#jobEmployee').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (phoneEmployee == "" || phoneEmployee.length < 11) { alert("Número de tlf. requerido"); $('#phoneEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (joinDateEmployee == "" || joinDateEmployee == null) { alert("Fecha de ingreso requerida"); $('#joinDateEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (genderEmployee == 0 || genderEmployee == null) { alert("Género requerido"); $('#genderEmployee').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (additionalEmployee == "") { alert("Info. adicional requerida"); $('#additionalEmployee').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                $('#codeEmployee').val('');
                $('#firstNameEmployee').val('');
                $('#lastNameEmployee').val('');
                $('#birthDateEmployee').val('');
                $('#departmentEmployee').val(0);
                $('#jobEmployee').val(0);
                $('#phoneEmployee').val('');
                $('#joinDateEmployee').val('');
                $('#genderEmployee').val(0);
                $('#additionalEmployee').val('');
            } else {
                $.ajax({
                    url : "{{ route('employees.store') }}",
                    type : 'POST',
                    data : { codeEmployee,firstNameEmployee,lastNameEmployee,birthDateEmployee,departmentEmployee,jobEmployee,phoneEmployee,joinDateEmployee,genderEmployee,additionalEmployee,addressEmployee },
                    success : function(response){
                        console.log(response);
                        if (response != '0') { 
                            alert("Empleado registrado. Cierre su sessión actual y registre el nuevo usuario para su acceso en el sistema. Posterior a esto, deberá cerrar sesión y comunicarse con la administración para relacionar el empleado con el usuario");
                            window.location.replace("http://127.0.0.1:8000/employees/index");
                        }
                    }
                })
            }
        });
        $(".btnAdditionalEmployee").click(function(e){
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var id = $(info).find("th:eq(0)").text();
            $("#idEmployee").val(id);
            $.ajax({ url : "{{ route('employees.additionalInfo') }}", type : 'GET', data : { id }, success : function(response){
                    $('#birthDateAdditional').val(response[0].birthDateEmployee);
                    $('#departmentAdditional').val(response[0].departmentEmployee);
                    $('#jobAdditional').val(response[0].jobEmployee);
                    $('#phoneAdditional').val(response[0].phoneEmployee);
                    $('#joinDateAdditional').val(response[0].joinDateEmployee);
                    $('#genderAdditional').val(response[0].genderEmployee);
                    $('#infoAdditional').val(response[0].additionalEmployee);
                    $('#addressAdditional').val(response[0].addressEmployee);
                    $('#selectUser').val(response[0].codeUser);
                }
            })
            $('#departmentAdditional').attr("class", "browser-default custom-select col-md-12 my-1");
            $('#jobAdditional').attr("class", "browser-default custom-select col-md-12 my-1"); 
            $('#selectUser').attr("class", "browser-default custom-select col-md-12 my-1");
            $('#phoneAdditional').attr("class", "form-control col-md-12 my-1");    
        });
        $('#departmentAdditional').click(function(e){ 
            $('#departmentAdditional').attr("class", "browser-default custom-select col-md-12 my-1"); });
        $('#jobAdditional').click(function(e){ $('#jobAdditional').attr("class", "browser-default custom-select col-md-12 my-1"); });
        $('#selectUser').click(function(e){ $('#selectUser').attr("class", "browser-default custom-select col-md-12 my-1"); });
        $('#phoneAdditional').keypress(function(e){ $('#phoneAdditional').attr("maxlength", "11");
            $('#phoneAdditional').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789";
            if(numeros.indexOf(tecla) == -1){ return false; }
        });
        $('#infoAdditional').keypress(function(e){
            $('#infoAdditional').attr("maxlength", "250"); $('#infoAdditional').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#addressAdditional').keypress(function(e){
            $('#addressAdditional').attr("maxlength", "250"); $('#addressAdditional').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase();
            var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz123456789";
            if(letras.indexOf(tecla) == -1){ return false; }
        });
        $('#genderAdditional').click(function(e){ $('#genderAdditional').attr("class", "browser-default custom-select col-md-12 my-1"); });
        $("#saveUser").click(function(e){
            var codeUser = $("#selectUser").val();
            var id = $("#idEmployee").val();
            var department = $('#departmentAdditional').val();
            var job = $('#jobAdditional').val();
            var phone = $('#phoneAdditional').val();
            var gender = $('#genderAdditional').val();
            var additional = $('#infoAdditional').val();
            var address = $('#addressAdditional').val();

            if ($("#selectUser").val() == "" || $("#idEmployee").val() == "" || $('#departmentAdditional').val() == 0 || $('#jobAdditional').val() == 0 || $('#phoneAdditional').val() == "" || $('#phoneAdditional').val().length < 11 || 
                $('#genderAdditional').val() == 0 || $('#infoAdditional').val() == "" || $('#addressAdditional').val() == "") {
                
                alert("Introduzca datos correctos");

                if (department == 0 || department == null) { alert("Departamento requerido"); $('#departmentAdditional').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (job == 0 || job == null) { alert("Cargo requerido"); $('#jobAdditional').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (codeUser == 0 || codeUser == null) { alert("Usuario requerido"); $('#selectUser').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (phone == "" || phone.length < 11) { alert("Número de tlf. requerido"); $('#phoneAdditional').attr("class", "form-control col-md-12 my-1 is-invalid"); }
                if (gender == 0 || gender == null) { alert("Género requerido"); $('#genderAdditional').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                if (address == "") { alert("Info. adicional requerida"); $('#addressAdditional').attr("class", "form-control col-md-12 my-1 is-invalid"); }

            } else {
                $.ajax({ url : "{{ route('employees.updateUser') }}", type : 'POST', data : { codeUser, id, department, job, phone, gender, additional, address },
                    success : function(response){
                        if (response == 1 || response == 0) {
                            alert("Información actualizada");
                            window.location.replace("http://127.0.0.1:8000/employees/index");
                        }

                    }
                })
            }
        });

        $(".desactiveEmployee").click(function(e){
            var info = $(this)[0].parentElement.parentElement.parentElement.parentElement;
            var id = $(info).find("th:eq(0)").text();
            var print = confirm("¿Desea inactivar el empleado?");
            if (print == true) { 
                $.ajax({ url : "{{ route('employees.desactiveEmployee') }}", type : 'POST', data : { id },
                    success : function(response){
                        if (response == 1) {
                            alert("Información actualizada");
                            window.location.replace("http://127.0.0.1:8000/employees/index");
                        }
                    }
                })
            }
        });
    });
</script>
@endsection('scripts')
