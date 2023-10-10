<div class="modal fade bd-example-modal-lg" id="modal-additional-article" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-left: 0px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Información del artículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mx-2">
                    <ul class="nav nav-tabs mx-4 mt-2">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#precios-costos">Precios y Costos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#stocks">Stocks</a>
                        </li>
                    </ul>
                    <!------------------------------------------------------------------------------------>
                    <div id="myTabContent" class="tab-content">
                        <div class="tab-pane fade active show" id="precios-costos">
                            <form action="" method="POST">
                                @method('POST')
                                @csrf
                                <div class="form-group mx-4 mt-4">

                                    <div class="row">
                                        <div class="col">
                                            <label>Costos</label>
                                            <input type="text" name="" class="form-control col-md-12 my-1" id="currentPrice" placeholder="Último" disabled="disabled">
                                        </div>
                                        <div class="col">
                                            <label>Fecha</label>
                                            <input type="date" name="" class="form-control col-md-12 my-1" id="updated_at" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="stocks">
                            <form action="" method="POST">
                                @method('POST')
                                @csrf
                                <div class="form-group mx-4 mt-4">

                                    <div class="row">
                                        <div class="col">
                                            <label>Unidad primaria</label>
                                        </div>
                                        <div class="col"></div>
                                        <div class="col"></div>
                                        <div class="col"></div>
                                    </div>

                                    <div class="row">
                                        <div class="col"> 
                                            <label for="currentStock">Actual</label>
                                            <input type="text" name="" class="form-control col-md-12 my-1" id="currentStock" placeholder="Actual" disabled="disabled">
                                        </div>
                                        <div class="col"> 
                                            <label for="committedStock">Comprometida</label>
                                            <input type="text" name="" class="form-control col-md-12 my-1" id="committedStock" placeholder="Comprom." disabled="disabled">
                                        </div>
                                        <div class="col"> 
                                            <label for="dispatchStock">Despachada</label>
                                            <input type="text" name="" class="form-control col-md-12 my-1" id="dispatchStock" placeholder="Despachada" disabled="disabled">
                                        </div>
                                        <div class="col"> 
                                            <label for="arriveStock">Por llegar</label>
                                            <input type="text" name="" class="form-control col-md-12 my-1" id="arriveStock" placeholder="Por llegar" disabled="disabled">
                                        </div>
                                    </div>
                                </div>
                            </form>
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