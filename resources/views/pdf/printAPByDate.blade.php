<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>CP por fecha</title>
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
		CP por fecha
	</div>

	<div align="right"> 
		Desde: {{ date("d", strtotime($since)) }}/{{ date("m", strtotime($since)) }}/{{ date("Y", strtotime($since)) }}, Hasta: {{ date("d", strtotime($until)) }}/{{ date("m", strtotime($until)) }}/{{ date("Y", strtotime($until)) }}<br>
	</div>
	
	<br>
	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Proveedor</th>
				<th>Cond. Pago</th>
				<th>Moneda</th>
				<th>Banco</th>
				<th>Monto</th>
				<th>Saldo</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($APs as $s)
                <tr>
                    <td>{{ $s->codePurchase }}</td>
                    <td>{{ $s->codeProvider }} - {{ $s->nameProvider }}</td>
                    <td>{{ $s->namePayment }}</td>
                    <td>{{ $s->codeCurrency }}</td>
                    <td>{{ $s->nameBank }}</td>
                    <td>{{ $s->amountDocument }}</td>
                    <td>{{ $s->amountAP }}</td>
                </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>	
	      		<td></td>
	      		<td></td>
	      		<td></td>
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $APsTot[0]->total }}</td>
	      		<td>{{ $APsTot2[0]->total }}</td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>