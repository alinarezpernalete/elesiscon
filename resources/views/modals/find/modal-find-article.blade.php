<div class="modal fade bd-example-modal-lg" id="modal-find-article" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-left: 0px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Información de artículos</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mx-2">
                    <div class="row">
                        <div class="col">
                            <input type="text" class="form-control mb-3" placeholder="Ingrese nombre del artículo" aria-describedby="basic-addon2" name="search" type="search" id="searchFast">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Tipo</th>
                                            <th scope="col">Descrip.</th>
                                            <th scope="col">Modelo</th>
                                            <th scope="col">Ref.</th>
                                            <th scope="col">Peso</th>
                                            <th scope="col">Ubicación</th>
                                            <th scope="col">Línea</th>
                                            <th scope="col">Sublínea</th>
                                            <th scope="col">Grupo</th>
                                            <th scope="col">Procedencia</th>
                                            <th scope="col">Proveedor</th>
                                            <th scope="col">Registro</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableFast">

                                    </tbody>
                                </table>
                            </div>
                        </div>
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