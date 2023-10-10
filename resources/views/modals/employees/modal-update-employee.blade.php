<div class="modal fade" id="modal-update-employee-{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Editar Empleado: {{ $employee->nameEmployee }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mx-2">
                    <form action="{{ route('employees.update', $employee->id) }}" method="POST">                    
                        @method('POST')
                        @csrf
                        <div class="form-group mx-4">
                            <label for="nameEmployee">Nombre del empleado</label>
                            <input type="text" name="nameEmployee" class="form-control" id="nameEmployee" value="{{$employee->nameEmployee}}">
                        </div>
                        <div class="form-group mx-4">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>-->
        </div>
    </div>
</div>