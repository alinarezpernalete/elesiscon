<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Horas por proyecto</title>
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
		Desde: {{ date("d", strtotime($since)) }}/{{ date("m", strtotime($since)) }}/{{ date("Y", strtotime($since)) }}, Hasta: {{ date("d", strtotime($until)) }}/{{ date("m", strtotime($until)) }}/{{ date("Y", strtotime($until)) }}<br>
	</div>

	<br>

	<div align="left">
		Horas por proyecto
	</div>
	<div align="left">
		Proyecto: {{ $hourMgmt[0]->codeProject }} - {{ $hourMgmt[0]->nameProject }}
	</div>

	<br>

	<table>
		<thead>
			<tr>
				<th>Empleado</th>
				<th>Actividad</th>
				<th>Horas</th>
				<th>Fecha</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($hourMgmt as $h)
                <tr>
                    <td>{{ $h->firstNameEmployee }} {{ $h->lastNameEmployee }}</td>
                    <td>{{ $h->codeActivity }} - {{ $h->nameActivity }}</td>
                    <td>{{ $h->hrsHourMgmt }}</td>
                    <td>{{ date("d", strtotime($h->dateHourMgmt)) }}/{{ date("m", strtotime($h->dateHourMgmt)) }}/{{ date("Y", strtotime($h->dateHourMgmt)) }}</td>
                </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>	
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $hourTot[0]->total }}</td>
	      		<td></td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>