<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Empleados por departamento</title>
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
		Empleados por departamento
	</div>
	<div align="left">
		Departamento: {{ $employee[0]->codeDepartment }} - {{ $employee[0]->nameDepartment }}
	</div>

	<br>
	<table>
		<thead>
			<tr>
				<th>CI</th>
				<th>Empleado</th>
				<th>Sexo</th>
				<th>Nacimiento</th>
				<th>Cargo</th>
				<th>Tlfs.</th>
				<th>Ingreso</th>
				<th>Dirección</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($employee as $e)
                <tr>
                    <td>{{ $e->codeEmployee }}</td>
                    <td>{{ $e->firstNameEmployee }} {{ $e->lastNameEmployee }}</td>
                    <td>{{ $e->genderEmployee }}</td>
                    <td>{{ $e->birthDateEmployee }}</td>
                    <td>{{ $e->nameJob }}</td>
                    <td>{{ $e->phoneEmployee }}</td>
                    <td>{{ $e->joinDateEmployee }}</td>
                    <td>{{ $e->addressEmployee }}</td>
                </tr>
            @endforeach
		</tbody>
	</table>
</body>
</html>