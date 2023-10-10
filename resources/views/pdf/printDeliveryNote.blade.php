<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Nota de entrega</title>
	<style type="text/css">
		body { font-family: Times New Roman }
		table { font-family: Times New Roman; width: 100%; border: 1px solid #000; }
		td {
		    text-align: left; vertical-align: top; border: 1px #000; border-collapse: collapse; padding: 0.3em; caption-side: bottom;
		    font-size: small;
		}
		caption {
		   padding: 0.5em; align-content: center; font-size: large;
		}
		th { background: #eee; border: 1px solid #000; border-collapse: collapse; padding: 0.3em; caption-side: bottom; }
		tfoot { background: #eee; font-weight: bold;}
	</style>
</head>
<body>
	<img width="120px" src="../public/images/eleinca_logo.jpg">
	<div align="right"> 
		Fecha de Pedido: {{ date("d", strtotime($deliveryDat[0]->created_at)) }}/{{ date("m", strtotime($deliveryDat[0]->created_at)) }}/{{ date("Y", strtotime($deliveryDat[0]->created_at)) }}<br>
	</div>
	<div align="left">
		Código de Pedido: {{ $deliveryNote->codeSale }}<br>
		RIF: {{ $deliveryNote->codeCustomer }}<br>
		Nombre del Cliente: {{ $deliveryNote->nameCustomer }}<br>
		Dirección: {{ $deliveryNote->addressCustomer }}<br>
		Teléfonos: {{ $deliveryNote->phoneCustomer }}<br>
		Moneda: Bolívares Soberanos<br>
		Cond. Pago: {{ $deliveryNote->namePayment }}<br>
		Observaciones: {{ $deliveryNote->descriptionSale }}<br>
		Generada por: {{ $deliveryNote->name }}
	</div>

	<br>
	<hr>
	<br>	

	<table>
		<caption>Detalles en nota de entrega</caption>
		<thead>
			<tr>
				<th width="100">Código</th>
				<th width="200">Descripción</th>
				<th>Cantidad</th>
				<th>Cantidad pend.</th>
				<th>Precio p/unidad</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($deliveryDet as $d)
                <tr>
                    <td>{{ $d->codeArticle }}</td>
                    <td>{{ $d->nameArticle }}</td>
                    <td>{{ $d->amountArticle }}</td>
                    <td>{{ $d->pendingAmountArticle }}</td>
                    <td>{{ $d->unitPriceArticle }}</td>
                </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>
	      		<td></td>
	      		<td></td>
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $deliveryNoteTot[0]->total }}</td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>