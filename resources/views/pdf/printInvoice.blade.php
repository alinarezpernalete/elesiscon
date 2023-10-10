<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Factura</title>
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
		Fecha de Pedido: {{ date("d", strtotime($invoiceDat[0]->created_at)) }}/{{ date("m", strtotime($invoiceDat[0]->created_at)) }}/{{ date("Y", strtotime($invoiceDat[0]->created_at)) }}<br>
	</div>
	<div align="left">
		Código de Pedido: {{ $invoice->codePurchase }}<br>
		RIF: {{ $invoice->codeProvider }}<br>
		Nombre del Cliente: {{ $invoice->nameProvider }}<br>
		Dirección: {{ $invoice->addressProvider }}<br>
		Teléfonos: {{ $invoice->phoneProvider }}<br>
		Moneda: Bolívares Soberanos<br>
		Cond. Pago: {{ $invoice->namePayment }}<br>
		Observaciones: {{ $invoice->descriptionPurchase }}<br>
		Generada por: {{ $invoice->name }}
	</div>

	<br>
	<hr>
	<br>
	<table>
		<caption>Detalles en factura</caption>
		<thead>
			<tr>
				<th width="100">Código</th>
				<th width="200">Descripción</th>
				<th>Cantidad</th>
				<th>Precio p/unidad</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($invoiceDet as $p)
                <tr>
                    <td>{{ $p->codeArticle }}</td>
		            <td>{{ $p->nameArticle }}</td>
		            <td>{{ $p->amountArticle }}</td>
		            <td>{{ $p->unitPriceArticle }}</td>
                </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>	
	      		<td></td>
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $invoiceTot[0]->total }}</td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>