<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Cliente por status</title>
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
		Cliente por status
	</div>
	<div align="left">
		Status: 
		@if ($customer[0]->statusCustomer == 1)
			Activo
		@endif
		@if ($customer[0]->statusCustomer == 0)
			Inactivo
		@endif
	</div>

	<br>
	<table>
		<thead>
			<tr>
				<th>Código</th>
				<th>Nombre</th>
				<th>Dirección</th>
				<th>Teléfono</th>
				<th>Email</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($customer as $e)
                <tr>
                    <td>{{ $e->codeCustomer }}</td>
                    <td>{{ $e->nameCustomer }}</td>
                    <td>{{ $e->addressCustomer }}</td>
                    <td>{{ $e->phoneCustomer }}</td>
                    <td>{{ $e->emailCustomer }}</td>
                </tr>
            @endforeach
		</tbody>
	</table>
</body>
</html>