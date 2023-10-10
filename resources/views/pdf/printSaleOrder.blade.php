<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Pedido</title>
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
		Fecha de Pedido: {{ date("d", strtotime($saleDat[0]->created_at)) }}/{{ date("m", strtotime($saleDat[0]->created_at)) }}/{{ date("Y", strtotime($saleDat[0]->created_at)) }}<br>
	</div>
	<div align="left">
		Código de Pedido: {{ $saleOrder->codeSale }}<br>
		RIF: {{ $saleOrder->codeCustomer }}<br>
		Nombre del Cliente: {{ $saleOrder->nameCustomer }}<br>
		Dirección: {{ $saleOrder->addressCustomer }}<br>
		Teléfonos: {{ $saleOrder->phoneCustomer }}<br>
		Moneda: Bolívares Soberanos<br>
		Cond. Pago: {{ $saleOrder->namePayment }}<br>
		Observaciones: {{ $saleOrder->descriptionSale }}<br>
		Generada por: {{ $saleOrder->name }}
	</div>

	<br>
	<hr>
	<br>	
	
	<table>
		<caption>Detalles en pedido</caption>
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
			@foreach ($saleDet as $s)
                <tr>
                    <td>{{ $s->codeArticle }}</td>
                    <td>{{ $s->nameArticle }}</td>
                    <td>{{ $s->amountArticle }}</td>
                    <td>{{ $s->pendingAmountArticle }}</td>
                    <td>{{ $s->unitPriceArticle }}</td>
                </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>
	      		<td></td>
	      		<td></td>
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $saleTot[0]->total }}</td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>