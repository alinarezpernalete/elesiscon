<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Órdenes de compra canceladas</title>
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
	
	<div align="left">
		Órdenes de compra canceladas
	</div>

	<div align="right"> 
		Órdenes de compra desde: {{ date("d", strtotime($since)) }}/{{ date("m", strtotime($since)) }}/{{ date("Y", strtotime($since)) }}, hasta: {{ date("d", strtotime($until)) }}/{{ date("m", strtotime($until)) }}/{{ date("Y", strtotime($until)) }}<br>
	</div>
	
	<br>

	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Proveedor</th>
				<th>Cond. de pago</th>
				<th>Descripción</th>
				<th>Monto</th>
				<th>Fecha</th>
				<th>Usuario</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($POs as $q)
            <tr>
                <td>{{ $q->codePurchase }}</td>
                <td>{{ $q->codeProvider }} - {{ $q->nameProvider }}</td>
                <td>{{ $q->namePayment }}</td>
                <td>{{ $q->descriptionPurchase }}</td>
                <td>{{ $q->unitpricearticle }}</td>
                <td>
                	{{ date("d", strtotime($q->PODatePurchase)) }}/{{ date("m", strtotime($q->PODatePurchase)) }}/{{ date("Y", strtotime($q->PODatePurchase)) }} {{ date("H", strtotime($q->PODatePurchase)) }}:{{ date("i", strtotime($q->PODatePurchase)) }}:{{ date("s", strtotime($q->PODatePurchase)) }}
                </td>
                <td>{{ $q->name }}</td>
            </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>	
	      		<td></td>
	      		<td></td>
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $POsTotal[0]->total }}</td>
	      		<td></td>
	      		<td></td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>