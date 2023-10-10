<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Notas de entrega por fecha</title>
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
		Notas de entrega por fecha
	</div>

	<div align="right"> 
		Notas de entrega desde: {{ date("d", strtotime($since)) }}/{{ date("m", strtotime($since)) }}/{{ date("Y", strtotime($since)) }}, hasta: {{ date("d", strtotime($until)) }}/{{ date("m", strtotime($until)) }}/{{ date("Y", strtotime($until)) }}<br>
	</div>
	
	<br>

	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Cliente</th>
				<th>Cond. de pago</th>
				<th>Descripción</th>
				<th>Monto</th>
				<th>Fecha</th>
				<th>Usuario</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($delNotes as $q)
            <tr>
                <td>{{ $q->codeSale }}</td>
                <td>{{ $q->codeCustomer }} - {{ $q->nameCustomer }}</td>
                <td>{{ $q->namePayment }}</td>
                <td>{{ $q->descriptionSale }}</td>
                <td>{{ $q->unitpricearticle }}</td>
                <td>
                	{{ date("d", strtotime($q->delNoteDateSale)) }}/{{ date("m", strtotime($q->delNoteDateSale)) }}/{{ date("Y", strtotime($q->delNoteDateSale)) }} {{ date("H", strtotime($q->delNoteDateSale)) }}:{{ date("i", strtotime($q->delNoteDateSale)) }}:{{ date("s", strtotime($q->delNoteDateSale)) }}
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
	      		<td>{{ $delNotesTotal[0]->total }}</td>
	      		<td></td>
	      		<td></td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>