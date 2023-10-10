<div class="modal fade" id="modal-add-employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Agregar empleado</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mx-2">
                    <form action="/employees/store" method="POST">
                        @method('POST')
                        @csrf
                        <div class="form-group mx-4">
                            <label>Información del empleado</label>
                            <div class="col">
                                <div class="row">
                                    <input type="text" name="codeEmployee" class="form-control col-md-12 my-1" id="idEmployee" placeholder="ID">
                                </div>
                                <div class="row">
                                    <input type="text" name="nameEmployee" class="form-control col-md-12 my-1" id="nameEmployee" placeholder="Nombre y apellido">
                                </div>
                            </div>
                        </div>
                        <div class="form-group mx-4">
                            <button type="submit" class="btn btn-primary col">Agregar</button>
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