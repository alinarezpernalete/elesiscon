<div class="modal fade bd-example-modal-lg" id="modal-show-ap" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="padding-left: 0px;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cuentas por Pagar</h5>
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
                                    <tbody id="tableAPList">
                                        @foreach ($APs as $AP)
                                            
                                                @if(
                                                    ($AP->amountDocument == $AP->amountAP) || 
                                                (
                                                    ($AP->amountAP > 0) && ($AP->amountAP < $AP->amountDocument)
                                                )

                                                )
                                                <tr>
                                                    <th hidden="hidden">{{ $AP->id }}</th>
                                                    <th hidden="hidden">{{ $AP->codeCurrency }}</th>
                                                    <th hidden="hidden">{{ $AP->codeBank }}</th>
                                                    <th scope="row">{{ $AP->codePurchase }}</th>
                                                    <td>{{ $AP->nameAPType }}</td>
                                                    <td>{{ $AP->nameProvider }}</td>
                                                    <td>{{ $AP->namePayment }}</td>
                                                    @if($AP->nameCurrency == 0)
                                                        <td>-</td>
                                                    @else
                                                        <td>{{ $AP->nameCurrency }}</td>
                                                    @endif
                                                    @if($AP->nameBank == 0)
                                                        <td>-</td>
                                                    @else
                                                        <td>{{ $AP->nameBank }}</td>
                                                    @endif
                                                    <td>{{ $AP->amountDocument }}</td>
                                                    <td>{{ $AP->amountAP }}</td>
                                                    <td><button type="button" class="btn btn-primary btn-sm" id="selectAccountPayable">Selec.</button></td>
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