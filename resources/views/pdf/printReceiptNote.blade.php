<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Nota de recepción</title>
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
		Fecha de Pedido: {{ date("d", strtotime($receiptDat[0]->created_at)) }}/{{ date("m", strtotime($receiptDat[0]->created_at)) }}/{{ date("Y", strtotime($receiptDat[0]->created_at)) }}<br>
	</div>
	<div align="left">
		Código de Pedido: {{ $receiptNote->codePurchase }}<br>
		RIF: {{ $receiptNote->codeProvider }}<br>
		Nombre del Cliente: {{ $receiptNote->nameProvider }}<br>
		Dirección: {{ $receiptNote->addressProvider }}<br>
		Teléfonos: {{ $receiptNote->phoneProvider }}<br>
		Moneda: Bolívares Soberanos<br>
		Cond. Pago: {{ $receiptNote->namePayment }}<br>
		Observaciones: {{ $receiptNote->descriptionPurchase }}<br>
		Generada por: {{ $receiptNote->name }}
	</div>

	<br>
	<hr>
	<br>	

	<table>
		<caption>Detalles en nota de recepción</caption>
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
			@foreach ($receiptDet as $p)
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
	      		<td>{{ $receiptTot[0]->total }}</td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>