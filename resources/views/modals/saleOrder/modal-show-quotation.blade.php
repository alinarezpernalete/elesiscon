<div class="modal fade bd-example-modal-lg" id="modal-show-quotation" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-left: 0px;">
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
                                    <tbody id="tableQuotation">
                                        @foreach ($saleOrders as $saleOrder)
                                            @if($saleOrder->typeSale == 1)
                                                <tr>
                                                    <th scope="row">{{ $saleOrder->codeSale }}</th>
                                                    <td>{{ $saleOrder->nameCustomer }}</td>
                                                    <td>{{ $saleOrder->namePayment }}</td>
                                                    <td>Pendiente para pedido</td>
                                                    <td>{{ $saleOrder->descriptionSale }}</td>
                                                    <td>{{ $saleOrder->name }}</td>
                                                    <td>{{ $saleOrder->created_at }}</td>
                                                    <td><button type="button" class="btn btn-primary btn-sm selectQuotation">Selec.</button></td>
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