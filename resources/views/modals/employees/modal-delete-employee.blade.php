<div class="modal fade" id="modal-delete-employee-{{$employee->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Eliminar Empleado: {{ $employee->nameEmployee }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mx-2">
                    <form action="{{ route('employees.delete', $employee->id) }}" method="POST">
                        @method('DELETE')
                        @csrf
                        <div class="form-group mb-1 mx-4">
                            <div class="col">
                                <div class="row">
                                    <button class="btn btn-danger col-md-5 mx-auto mt-1">Eliminar</button>
                                    <button type="button" class="btn btn-secondary col-md-5 mx-auto mt-1" data-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
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