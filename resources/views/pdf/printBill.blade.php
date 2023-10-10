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
		Fecha de Pedido: {{ date("d", strtotime($billDat[0]->created_at)) }}/{{ date("m", strtotime($billDat[0]->created_at)) }}/{{ date("Y", strtotime($billDat[0]->created_at)) }}<br>
	</div>
	<div align="left">
		Código de Pedido: {{ $bill->codeSale }}<br>
		RIF: {{ $bill->codeCustomer }}<br>
		Nombre del Cliente: {{ $bill->nameCustomer }}<br>
		Dirección: {{ $bill->addressCustomer }}<br>
		Teléfonos: {{ $bill->phoneCustomer }}<br>
		Moneda: Bolívares Soberanos<br>
		Cond. Pago: {{ $bill->namePayment }}<br>
		Observaciones: {{ $bill->descriptionSale }}<br>
		Generada por: {{ $bill->name }}
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
			@foreach ($billDet as $b)
                <tr>
                    <td>{{ $b->codeArticle }}</td>
                    <td>{{ $b->nameArticle }}</td>
                    <td>{{ $b->amountArticle }}</td>
                    <td>{{ $b->unitPriceArticle }}</td>
                </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>
	      		<td></td>
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $billTot[0]->total }}</td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>