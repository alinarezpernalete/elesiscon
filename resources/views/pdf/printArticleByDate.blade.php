<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Movimientos de artículos por fecha</title>
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
        Movimientos de artículos por fecha
    </div>
    <br>

	<table>
		<thead>
			<tr>
				<th>Tipo</th>
				<th>Código</th>
                <th>Descripción</th>
				<th>Cantidad</th>
				<th>Precio p/unidad</th>
                <th>Fecha</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($sale_det as $s)
                <tr>
                    <td>Venta</td>
                    <td>{{ $s->codeArticle }}</td>
                    <td>{{ $s->nameArticle }}</td>
                    <td>{{ $s->amountArticle }}</td>
                    <td>{{ $s->unitPriceArticle }}</td>
                    <td>
                        {{ date("d", strtotime($s->created_at)) }}/{{ date("m", strtotime($s->created_at)) }}/{{ date("Y", strtotime($s->created_at)) }} {{ date("H", strtotime($s->created_at)) }}:{{ date("i", strtotime($s->created_at)) }}:{{ date("s", strtotime($s->created_at)) }}
                    </td>
                </tr>
            @endforeach
            @foreach ($purchase_det as $p)
                <tr>
                	<td>Compra</td>
                    <td>{{ $p->codeArticle }}</td>
                    <td>{{ $p->nameArticle }}</td>
                    <td>{{ $p->amountArticle }}</td>
                    <td>{{ $p->unitPriceArticle }}</td>
                    <td>
                        {{ date("d", strtotime($p->created_at)) }}/{{ date("m", strtotime($p->created_at)) }}/{{ date("Y", strtotime($p->created_at)) }} {{ date("H", strtotime($p->created_at)) }}:{{ date("i", strtotime($p->created_at)) }}:{{ date("s", strtotime($p->created_at)) }}
                    </td>
                </tr>
            @endforeach
		</tbody>
	</table>
</body>
</html>