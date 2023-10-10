<div class="modal fade bd-example-modal-lg" id="modal-show-ar" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-left: 0px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cuentas por Cobrar</h5>
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
                                            <th scope="col">Tipo de doc.</th>
                                            <th scope="col">Proveedor</th>
                                            <th scope="col">Pago</th>
                                            <th scope="col">Moneda</th>
                                            <th scope="col">Banco</th>
                                            <th scope="col">Monto</th>
                                            <th scope="col">Saldo</th>
                                            <th scope="col">Selec.</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tableARList">
                                        @foreach ($ARs as $AR)
                                            
                                                @if(
                                                    ($AR->amountDocument == $AR->amountAR) || 
                                                (
                                                    ($AR->amountAR > 0) && ($AR->amountAR < $AR->amountDocument)
                                                )

                                                )
                                                <tr>
                                                    <th hidden="hidden">{{ $AR->id }}</th>
                                                    <th hidden="hidden">{{ $AR->codeCurrency }}</th>
                                                    <th hidden="hidden">{{ $AR->codeBank }}</th>
                                                    <th scope="row">{{ $AR->codeSale }}</th>
                                                    <td>{{ $AR->nameARType }}</td>
                                                    <td>{{ $AR->nameCustomer }}</td>
                                                    <td>{{ $AR->namePayment }}</td>
                                                    @if($AR->nameCurrency == 0)
                                                        <td>-</td>
                                                    @else
                                                        <td>{{ $AR->nameCurrency }}</td>
                                                    @endif
                                                    @if($AR->nameBank == 0)
                                                        <td>-</td>
                                                    @else
                                                        <td>{{ $AR->nameBank }}</td>
                                                    @endif
                                                    <td>{{ $AR->amountDocument }}</td>
                                                    <td>{{ $AR->amountAR }}</td>
                                                    <td><button type="button" class="btn btn-primary btn-sm" id="selectAccountReceivable">Selec.</button></td>
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