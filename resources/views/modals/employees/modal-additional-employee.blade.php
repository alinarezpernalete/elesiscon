<div class="modal fade bd-example-modal-lg" id="modal-additional-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Información Empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mx-2">
                    <input type="text" class="form-control col-md-12 my-1" id="idEmployee" hidden="hidden">
                    <div class="row">
                        <div class="col">
                            <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Fecha de nacimiento" disabled="disabled" id="birthDateAdditional">
                        </div>
                        <div class="col"> 
                            <select class="browser-default custom-select col-md-12 my-1" disabled="disabled" id="genderAdditional">     
                                <option selected="" disabled="" value="0">Género</option>
                                <option value="M">M</option> <option value="F">F</option>
                            </select>
                        </div>
                    </div>
                    <hr class="my-4">
                    <div class="row">
                        @if(Auth::user()->name == "Administrador")
                            <div class="col"> <select class="browser-default custom-select col-md-12 my-1" id="departmentAdditional"> <option selected="" disabled="" value="0">Departamento</option> @foreach ( $departments as $department ) <option value="{{ $department->id }}">{{ $department->codeDepartment }} - {{ $department->nameDepartment }}</option> @endforeach </select>
                            </div>
                        @else
                            <div class="col"> <select class="browser-default custom-select col-md-12 my-1" disabled="disabled" id="departmentAdditional"> <option selected="" disabled="" value="0">Departamento</option> @foreach ( $departments as $department ) <option value="{{ $department->id }}">{{ $department->codeDepartment }} - {{ $department->nameDepartment }}</option> @endforeach </select>
                            </div>
                        @endif 
                        @if(Auth::user()->name == "Administrador")
                            <div class="col"> <select class="browser-default custom-select col-md-12 my-1" id="jobAdditional"> <option selected="" disabled="" value="0">Cargo</option> @foreach ( $jobs as $job ) <option value="{{ $job->id }}">{{ $job->codeJob }} - {{ $job->nameJob }}</option> @endforeach </select> </div>
                        @else
                            <div class="col"> <select class="browser-default custom-select col-md-12 my-1" disabled="disabled" id="jobAdditional"> <option selected="" disabled="" value="0">Cargo</option> @foreach ( $jobs as $job ) <option value="{{ $job->id }}">{{ $job->codeJob }} - {{ $job->nameJob }}</option> @endforeach </select> </div>
                        @endif 
                        @if(Auth::user()->name == "Administrador")
                            <div class="col"> <input type="text" class="form-control col-md-12 my-1" id="phoneAdditional" placeholder="Teléfono" maxlength="11"> </div>
                        @else
                            <div class="col"> <input type="text" class="form-control col-md-12 my-1" id="phoneAdditional" placeholder="Teléfono" disabled="disabled" maxlength="11"> </div>
                        @endif 
                    </div>
                    <div class="row">
                        <div class="col">
                            <input type="date" class="form-control col-md-12 my-1" data-toggle="tooltip" data-placement="top" title="Fecha de ingreso" disabled="disabled" id="joinDateAdditional">
                        </div>
                        @if(Auth::user()->name == "Administrador")
                            <div class="col"> <select class="browser-default custom-select col-md-12 my-1" id="selectUser"> <option selected="" disabled="" value="0">Usuario</option> @foreach ( $users as $user ) <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option> @endforeach </select> </div>
                        @else
                            <div class="col"> <select class="browser-default custom-select col-md-12 my-1" disabled="disabled" id="selectUser"> <option selected="" disabled="">Usuario</option> @foreach ( $users as $user ) <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option> @endforeach </select> </div>
                        @endif
                        @if(Auth::user()->name == "Administrador")
                            <div class="col"> <input type="text" class="form-control col-md-12 my-1" id="infoAdditional" placeholder="Información adicional" maxlength="250"> </div>
                        @else
                            <div class="col"> <input type="text" class="form-control col-md-12 my-1" id="infoAdditional" placeholder="Información adicional" maxlength="250" disabled="disabled"> </div>
                        @endif
                    </div>
                    <div class="row">
                        @if(Auth::user()->name == "Administrador")
                        <div class="col">
                            <textarea class="form-control col-md-12 my-1" rows="3" placeholder="Dirección" id="addressAdditional" maxlength="180"></textarea>
                        </div>
                        @else
                        <div class="col">
                            <textarea class="form-control col-md-12 my-1" rows="3" placeholder="Dirección" id="addressAdditional" maxlength="180" disabled="disabled"></textarea>
                        </div>
                        @endif
                    </div>
                    <div class="row">
                        @if(Auth::user()->name == "Administrador")
                            <div class="col mt-3"> <button class="btn btn-primary" id="saveUser">Guardar</button> </div>
                        @else
                            <div class="col mt-3"> <button class="btn btn-primary" disabled="disabled" id="saveUser">Guardar</button> </div>
                        @endif
                    </div>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>-->
        </div>
    </div>
</div>