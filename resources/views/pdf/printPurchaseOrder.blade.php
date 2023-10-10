<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Orden de compra</title>
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
		Fecha de Pedido: {{ date("d", strtotime($purchaseDat[0]->created_at)) }}/{{ date("m", strtotime($purchaseDat[0]->created_at)) }}/{{ date("Y", strtotime($purchaseDat[0]->created_at)) }}<br>
	</div>
	<div align="left">
		Código de Pedido: {{ $purchaseOrder->codePurchase }}<br>
		RIF: {{ $purchaseOrder->codeProvider }}<br>
		Nombre del Cliente: {{ $purchaseOrder->nameProvider }}<br>
		Dirección: {{ $purchaseOrder->addressProvider }}<br>
		Teléfonos: {{ $purchaseOrder->phoneProvider }}<br>
		Moneda: Bolívares Soberanos<br>
		Cond. Pago: {{ $purchaseOrder->namePayment }}<br>
		Observaciones: {{ $purchaseOrder->descriptionPurchase }}<br>
		Generada por: {{ $purchaseOrder->name }}
	</div>

	<br>
	<hr>
	<br>

	<table>
		<caption>Detalles en O/C</caption>
		<thead>
			<tr>
				<th width="100">Código</th>
				<th width="200">Descripción</th>
				<th>Cantidad comp.</th>
				<th>Cantidad pend.</th>
				<th>Precio p/unidad</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($purchaseDet as $p)
                <tr>
                    <td>{{ $p->codeArticle }}</td>
		            <td>{{ $p->nameArticle }}</td>
		            <td>{{ $p->amountArticle }}</td>
		            <td>{{ $p->pendingAmountArticle }}</td>
		            <td>{{ $p->unitPriceArticle }}</td>
                </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>
	      		<td></td>
	      		<td></td>
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $purchaseTot[0]->total }}</td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>