<div class="modal fade bd-example-modal-lg" id="modal-add-customer" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-left: 0px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Registrar cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row mx-1">
                    <div class="col"> 
                        <input type="text" class="form-control col-md-12 my-1" placeholder="Código cliente" id="codeCustomer">
                    </div>
                    <div class="col"> 
                        <input type="text" class="form-control col-md-12 my-1" placeholder="Nombre del cliente" id="nameCustomer">
                    </div>
                </div>
                <div class="row mx-1">
                    <div class="col"> 
                        <input type="text" class="form-control col-md-12 my-1" placeholder="Dirección del cliente" id="addressCustomer">
                    </div>
                    <div class="col"> 
                        <input type="text" class="form-control col-md-12 my-1" placeholder="Teléfono del cliente" id="phoneCustomer">
                    </div>
                </div>
                <div class="row mx-1">
                    <div class="col"> 
                        <input type="text" class="form-control col-md-12 my-1" placeholder="Email del cliente" id="emailCustomer">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="saveCustomer" class="btn btn-primary">Guardar</button>
                <button class="btn btn-warning" id="cleanCustomer">Limpiar campos</button>
            </div>
        </div>
    </div>
</div>
