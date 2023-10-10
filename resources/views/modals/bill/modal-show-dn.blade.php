<div class="modal fade bd-example-modal-lg" id="modal-show-dn" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-left: 0px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Detalle</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="mx-2">
                    <div class="row">
                        <div class="col">
                            <div class="table-responsive table-hover">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">Código</th>
                                            <th scope="col">Proveedor</th>
                                            <th scope="col">Pago</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Descripción</th>
                                            <th scope="col">Generada</th>
                                            <th scope="col">Fecha</th>
                                            <th scope="col">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableDN">
                                        @foreach ($bills as $bill)
                                                    @if($bill->typeSale == 3)
                                                        <tr>
                                                            <th scope="row">{{ $bill->codeSale }}</th>
                                                            <td>{{ $bill->nameCustomer }}</td>
                                                            <td>{{ $bill->namePayment }}</td>
                                                            <td>Pendiente para factura</td>
                                                            <td>{{ $bill->descriptionSale }}</td>
                                                            <td>{{ $bill->name }}</td>
                                                            <td>{{ $bill->created_at }}</td>
                                                            <td><button type="button" class="btn btn-primary btn-sm selectDN">Selec.</button></td>
                                                        </tr>
                                                    @endif
                                                @endforeach
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