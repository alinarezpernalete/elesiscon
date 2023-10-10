@extends('layouts.app')

@section('title', 'Manejo de horas')

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
                                        <a class="nav-link active mx-auto" data-toggle="tab" href="#llenar-ctrl-hrs">Llenar control de horas</a>
                                    </li>
                                    @if(Auth::user()->name == "Administrador")
                                        <li class="nav-item">
                                            <a class="nav-link mx-auto" data-toggle="tab" href="#validar-ctrl-hrs">Validación</a>
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
                    <div class="tab-pane fade active show" id="llenar-ctrl-hrs">
                        <div class="form-group mt-2">
                            <div class="row">
                                
                                <input type="text" id="employeeHourMgmt" class="form-control col-md-12 my-1" hidden="hidden" value="{{ auth()->user()->id }}">

                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="projectHourMgmt" required="required">
                                        <option selected="" disabled="" value="0">Seleccione proyecto</option>
                                        @foreach ( $projects as $project )
                                            <option value="{{ $project->id }}">{{ $project->codeProject }} - {{ $project->nameProject }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <select class="browser-default custom-select col-md-12 my-1" id="activityHourMgmt">
                                        <option selected="" disabled="" value="0">Seleccione actividad</option>
                                        @foreach ( $activities as $activity )
                                            <option value="{{ $activity->id }}">{{ $activity->codeActivity}} - {{ $activity->nameActivity }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col">
                                    <input type="text" class="form-control col-md-12 my-1" placeholder="Horas" id="hrsHourMgmt">
                                </div>
                                <div class="col">
                                    <input type="date" class="form-control col-md-12 my-1" id="dateHourMgmt">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <textarea class="form-control col-md-12 my-1" rows="3" placeholder="Descripción" id="descriptionHourMgmt" maxlength="180"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" id="saveHours">Listar horas</button>
                                </div>
                                <div class="col mt-2">
                                    <button type="button" class="btn btn-warning col-md-12 mx-auto btn-block" id="cleanHours">Limpiar campos</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th hidden="hidden">ID</th>
                                                    <th scope="col">Proyecto</th>
                                                    <th scope="col">Actividad</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Horas</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableHours">

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-secondary mb-2 row mx-auto w-100 justify-content-center" role="alert" id="hours">Horas de la semana: </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" disabled="" id="updateValidated">Listar para validación</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!------------------------------------------------------------------------------------>
                    @include('modals.hourMgmt.modal-search-toValidated')
                    <div class="tab-pane fade" id="validar-ctrl-hrs">
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col">
                                    <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" data-toggle="modal" data-target="#modal-search-toValidated" id="searchToValidated">Horas por validar</button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <div class="row">
                                <div class="col">
                                    <input class="form-control mb-3" type="text" placeholder="Código de horas" id="codeHourMgmt" readonly>
                                </div>
                                <div class="col">
                                    <input class="form-control mb-3" type="text" placeholder="Empleado" readonly id="employeeHourMgmtToValidated">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="table-responsive table-hover">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Proyecto</th>
                                                    <th scope="col">Actividad</th>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Horas</th>
                                                    <th scope="col">Descripción</th>
                                                    <th scope="col">Acciones</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableToValidated">
                                                    
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="alert alert-secondary mb-2 row mx-auto w-100 justify-content-center" role="alert" id="hoursToValidated">Horas de la semana: </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2">
                                    <button type="button" class="btn btn-primary col-md-12 mx-auto btn-block" id="saveToValidated">Guardar validación</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!------------------------------------------------------------------------------------>
                </div>
            </div>
        </div>
        <!-- -->
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

        $(document).on('click', '#cleanHours', function(){
            $('#projectHourMgmt').val(0); $('#activityHourMgmt').val(0); $('#hrsHourMgmt').val(''); $('#dateHourMgmt').val(''); $('#descriptionHourMgmt').val('');
        });
        $('#projectHourMgmt').click(function(e){ $('#projectHourMgmt').attr("class", "browser-default custom-select col-md-12 my-1"); });
        $('#activityHourMgmt').click(function(e){ $('#activityHourMgmt').attr("class", "browser-default custom-select col-md-12 my-1"); });
        $('#hrsHourMgmt').keypress(function(e){ $('#hrsHourMgmt').attr("maxlength", "2"); $('#hrsHourMgmt').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which;
            var tecla = String.fromCharCode(key).toLowerCase(); var numeros = "0123456789"; if(numeros.indexOf(tecla) == -1){ return false; }
        });
        $('#dateHourMgmt').click(function(e){ $('#dateHourMgmt').attr("class", "form-control col-md-12 my-1"); });
        $('#descriptionHourMgmt').keypress(function(e){ $('#descriptionHourMgmt').attr("maxlength", "180"); 
            $('#descriptionHourMgmt').attr("class", "form-control col-md-12 my-1");
            var key = e.keyCode || e.which; var tecla = String.fromCharCode(key).toLowerCase(); var letras = " áéíóúabcdefghijklmnñopqrstuvwxyz.,1234567890";
            if(letras.indexOf(tecla) == -1){ return false; }
        });

        $(document).on('click', '#saveHours', function(){
            var employeeHourMgmt = $('#employeeHourMgmt').val();
            var projectHourMgmt = $('#projectHourMgmt').val();
            var activityHourMgmt = $('#activityHourMgmt').val();
            var hrsHourMgmt = $('#hrsHourMgmt').val();
            var dateHourMgmt = $('#dateHourMgmt').val();
            var descriptionHourMgmt = $('#descriptionHourMgmt').val();
            if ($('#projectHourMgmt').val() == "" || 
                $('#activityHourMgmt').val() == "" || 
                $('#hrsHourMgmt').val() == "" || (hrsHourMgmt > 12) ||
                $('#dateHourMgmt').val() == "" || 
                $('#descriptionHourMgmt').val() == "") {
                    if (projectHourMgmt == "" || projectHourMgmt == null) { alert("Proyecto requerido"); $('#projectHourMgmt').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                    if (activityHourMgmt == "" || activityHourMgmt == null) { alert("Actividad requerida"); $('#activityHourMgmt').attr("class", "browser-default custom-select col-md-12 my-1 is-invalid"); }
                    if (hrsHourMgmt == "") { alert("Horas requeridas"); $('#hrsHourMgmt').attr("class", "form-control col-md-12 my-1 is-invalid");  }
                    if (hrsHourMgmt > 12) { alert("Horas excedidas"); $('#hrsHourMgmt').attr("class", "form-control col-md-12 my-1 is-invalid");  }
                    var day,month,year; day = parseInt(dateHourMgmt.substring(8,10));month = parseInt(dateHourMgmt.substring(5,7));year = parseInt(dateHourMgmt.substring(0,4)); var date = new Date(); var currentYear = parseInt(date.getFullYear());var currentMonth = parseInt(date.getMonth()+1);
                    if ((year != currentYear) && (month != currentMonth)) { alert("Seleccione el año y mes actual"); 
                        $('#dateHourMgmt').attr("class", "form-control col-md-12 my-1 is-invalid"); 
                    } else { 
                        if ((year == currentYear) && (month != currentMonth)) {  alert("Seleccione el mes actual"); 
                        } else {
                            if ((year != currentYear) && (month == currentMonth)) {  alert("Seleccione el año actual"); }
                        }
                    }
                    if (descriptionHourMgmt == "") { alert("Descripción requerida"); $('#descriptionHourMgmt').attr("class", "form-control col-md-12 my-1 is-invalid");  }
                    $('#projectHourMgmt').val(0);
                    $('#activityHourMgmt').val(0);
                    $('#hrsHourMgmt').val('');
                    $('#dateHourMgmt').val('');
            } else {

                $.ajax({
                    url : "{{ route('hoursManagement.addHours') }}",
                    type : 'POST',
                    data : { employeeHourMgmt,projectHourMgmt,activityHourMgmt,hrsHourMgmt,dateHourMgmt,descriptionHourMgmt },
                    success : function(response){

                        var dia = parseInt(dateHourMgmt.substring(8,10));
                        var mes = parseInt(dateHourMgmt.substring(5,7));
                        var año = parseInt(dateHourMgmt.substring(0,4));
                        console.log(dia+"-"+mes+"-"+año);

                        document.getElementById("tableHours").insertRow(-1).innerHTML = 
                        '<tr>'+
                            '<td hidden>'+response.id+'</td>'+
                            '<td>'+$('#projectHourMgmt option:selected').text()+'</td>'+
                            '<td>'+$('#activityHourMgmt option:selected').text()+'</td>'+
                            '<td>'+dia+'-'+mes+'-'+año+'</td>'+
                            '<td>'+hrsHourMgmt+'</td>'+
                            '<td>'+descriptionHourMgmt+'</td>'+
                            '<td>'+
                                '<button type="button" class="btn btn-danger btn-sm deleteHours">Eliminar</button>'+
                            '</td>'+
                        '</tr>'
                        $('#projectHourMgmt').val('0');
                        $('#activityHourMgmt').val('0');
                        $('#hrsHourMgmt').val('');
                        $('#dateHourMgmt').val('');
                        $('#descriptionHourMgmt').val('');
                        var regex = /(\d+)/g;
                        var hoursShow = $('#hours').text();
                        var hoursSum = parseInt(hrsHourMgmt)+parseInt(hoursShow.match(regex).toString());
                        if (parseInt(hoursSum) >= 40) {
                            $('#updateValidated').prop("disabled", false);
                        }
                        $('#hours').text("Horas de la semana: "+hoursSum);

                    }
                });

            }
        })

        loadhours();
        function loadhours(){
            var employeeHourMgmt = $('#employeeHourMgmt').val();
            var hours = 0;
            $.ajax({
                url : "{{ route('hoursManagement.loadHours') }}",
                type : 'GET',
                data : { employeeHourMgmt },
                success : function(response){
                    let layout = '';
                    response.forEach(result => {
                        layout +=   `<tr>
                                        <td hidden>${result.id}</td>
                                        <td>${result.codeProject} - ${result.nameProject}</td>
                                        <td>${result.codeActivity} - ${result.nameActivity}</td>
                                        <td>${result.dateHourMgmt}</td>
                                        <td>${result.hrsHourMgmt}</td>
                                        <td>${result.descriptionHourMgmt}</td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-sm deleteHours">Eliminar</button>
                                        </td>
                                    </tr>`
                        hours += result.hrsHourMgmt;
                    });
                    if (parseInt(hours) >= 40) {
                        $('#updateValidated').prop("disabled", false);
                    }
                    $('#hours').text("Horas de la semana: "+hours);
                    $('#tableHours').html(layout);
               }
            })
        }

        $(document).on('click', '.deleteHours', function () {
            var areYouSure = confirm("¿Desea eliminar estas horas de su manejo?");
            if (areYouSure == true) {
                var info = $(this)[0].parentElement.parentElement;
                var id = $(info).find("td:eq(0)").text();
                var hrsHourMgmt = $(info).find("td:eq(4)").text();
                $.ajax({
                    url : "{{ route('hoursManagement.deleteHours') }}",
                    type : 'POST',
                    data : { id },
                    success : function(response){
                        console.log(response);
                        var regex = /(\d+)/g;
                        var hoursShow = $('#hours').text();
                        var hoursSubtrac = parseInt(hoursShow.match(regex).toString())-parseInt(hrsHourMgmt);
                        if (parseInt(hoursSubtrac) < 40) {
                            $('#updateValidated').prop("disabled", true);
                        }
                        $('#hours').text("Horas de la semana: "+hoursSubtrac);
                        info.closest('tr').remove();
                    }
                })
            }
        });

        $(document).on('click', '#updateValidated', function(){
            var employeeHourMgmt = $('#employeeHourMgmt').val();
            $.ajax({
                url : "{{ route('hoursManagement.getDateToCode') }}",
                type : 'GET',
                data : { employeeHourMgmt },
                success : function(response){
                    if (response.length > 0) {
                        
                        var date = response[0].created_at;
                        var regex = /(\d+)/g;
                        var codeHourMgmt = date.match(regex)[0]+date.match(regex)[1]+date.match(regex)[2]+response[0].codeEmployee;

                        $.ajax({
                            url : "{{ route('hoursManagement.createCodeHourMgmt') }}",
                            type : 'POST',
                            data : { codeHourMgmt,employeeHourMgmt },
                            success : function(response){
                                console.log(response);

                                var codeHourMgmt = response.id;

                                var nbrTable = document.getElementById("tableHours").rows.length;
                                for (var i = 0; i < nbrTable; i++) {
                                    var info = $('.deleteHours')[i].parentElement.parentElement;
                                    var idHour = $(info).find("td:eq(0)").text();
                                    $.ajax({
                                        url : "{{ route('hoursManagement.updateValidated') }}",
                                        type : 'POST',
                                        data : { idHour,codeHourMgmt },
                                        success : function(response){
                                            console.log(response);
                                        }
                                    })
                                }
                                alert("Procesando...");
                                window.location.replace("http://127.0.0.1:8000/hoursManagement/index");


                            }
                        })


                    }
                }
            })
        });

        $(document).on('click', '#searchToValidated', function(){
            $.ajax({
                url : "{{ route('hoursManagement.searchToValidated') }}",
                type : 'GET',
                success : function(response){
                    console.log(response);
                    let layout = '';
                    if (response.length == 0) {
                        layout +=   `<tr>
                                        <th colspan="4"><div class="alert alert-secondary mb-0 row mx-auto w-100 justify-content-center" role="alert">No existen horas para validar actualmente</div></th>
                                    </tr>`
                    } else {
                        response.forEach(result => {
                            layout +=   `<tr>
                                            <td hidden>${result.id}</td>
                                            <td>${result.codeHourMgmt}</td>
                                            <td>${result.firstNameEmployee} ${result.lastNameEmployee}</td>
                                            <td>${result.created_at}</td>
                                            <td>
                                                <button type="button" class="btn btn-success btn-sm getHours">Seleccionar</button>
                                            </td>
                                        </tr>`
                        });
                    }
                    $('#tableSearchToValidated').html(layout);
                }
            })
        });
        var id = 0;
        $(document).on('click', '.getHours', function(){
            var info = $(this)[0].parentElement.parentElement;
            id = $(info).find("td:eq(0)").text();
            var hours = 0;
            $.ajax({
                url : "{{ route('hoursManagement.getHours') }}",
                type : 'GET',
                data : { id },
                success : function(response){
                    if (response.length == 0){
                        alert("No existen horas registradas");
                    } else {
                        let layout = '';
                        response.forEach(result => {
                            layout +=   `<tr>
                                            <td hidden>${result.id}</td>
                                            <td>${result.codeProject} - ${result.nameProject}</td>
                                            <td>${result.codeActivity} - ${result.nameActivity}</td>
                                            <td>${result.dateHourMgmt}</td>
                                            <td>${result.hrsHourMgmt}</td>
                                            <td>${result.descriptionHourMgmt}</td>
                                            <td>
                                                <div class="form-check">
                                                  <input class="form-check-input validated" type="checkbox" value="" id="flexCheckDefault">
                                                  <label class="form-check-label" for="flexCheckDefault">
                                                    Validar
                                                  </label>
                                                </div>
                                            </td>
                                        </tr>`
                            hours += result.hrsHourMgmt;
                        });
                        $("#modal-search-toValidated").modal("hide");
                        /*if (parseInt(hours) >= 40) {
                            $('#saveToValidated').prop("disabled", false);
                        }*/
                        $('#hoursToValidated').text("Horas de la semana: "+hours);
                        
                        $('#codeHourMgmt').val(response[0].codeHourMgmt);
                        $('#employeeHourMgmtToValidated').val(response[0].firstNameEmployee + " " + response[0].lastNameEmployee);
                        
                        $('#tableToValidated').html(layout);
                    }
                }
            })
        });

        $(document).on('click', '#saveToValidated', function(){
            var nbrTable = document.getElementById("tableToValidated").rows.length;
            var valTrue = 0;
            var valFalse = 0;

            if (nbrTable > 0) {
                for (var i = 0; i < nbrTable; i++) {
                    var dataForValidated = $('.validated')[i];
                    var validated = dataForValidated.checked;
                    var idForValidated = $('.validated')[i].parentElement.parentElement.parentElement;
                    let id = $(idForValidated).find("td:eq(0)").text();
                    /***********************************************/
                    if (validated == false) {
                        valFalse = valFalse+1;
                    } else {
                        valTrue = valTrue+1;
                    }
                    /***********************************************/
                    var indicator = "details"
                    var forDisplay = valTrue;
                    $.ajax({
                        url : "{{ route('hoursManagement.saveToValidated') }}",
                        type : 'POST',
                        data : { id,validated,indicator },
                        success : function(response){
                            console.log(response);

                            if (response == 1) { 
                                if (forDisplay == 0) {
                                    alert("Cargando horas no validadas");     
                                } else {
                                    alert("Procesando, faltan: " + forDisplay); 
                                }
                                window.location.replace("http://127.0.0.1:8000/hoursManagement/index"); 
                                if (forDisplay > 0){
                                    forDisplay = forDisplay - 1;
                                } else {
                                    forDisplay = 0;
                                }
                            }
                        }
                    })
                }
            } else { alert("Seleccione horas"); }
            console.log(id);
            console.log(valTrue + " " + valFalse);
            if (valFalse > valTrue) { 
                let indicator = "Mgmt va false"
                $.ajax({ url : "{{ route('hoursManagement.saveToValidated') }}", type : 'POST', data : { id,validated,indicator },
                success : function(response){ console.log(response); if (response == 1) { alert("Finalizando..."); window.location.replace("http://127.0.0.1:8000/hoursManagement/index"); } } }) 
            }
            if (valFalse == valTrue) { 
                let indicator = "Mgmt va false"
                $.ajax({ url : "{{ route('hoursManagement.saveToValidated') }}", type : 'POST', data : { id,validated,indicator },
                success : function(response){ console.log(response); if (response == 1) { alert("Finalizando..."); window.location.replace("http://127.0.0.1:8000/hoursManagement/index"); } } }) 
            }
            if (valTrue > valFalse) { 
                let indicator = "Mgmt va true"
                $.ajax({ url : "{{ route('hoursManagement.saveToValidated') }}", type : 'POST', data : { id,validated,indicator },
                success : function(response){ console.log(response); if (response == 1) { alert("Finalizando..."); window.location.replace("http://127.0.0.1:8000/hoursManagement/index"); } } }) 
            }
        });

    });

                    /**/
</script>
@endsection('scripts')

