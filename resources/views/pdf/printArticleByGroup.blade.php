<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Artículos por grupo</title>
    <style type="text/css">
        body { font-family: Times New Roman }
        table { font-family: Times New Roman; width: 100%; border: 1px solid #000; }
        td {
            text-align: left; vertical-align: top; border: 1px #000; border-collapse: collapse; padding: 0.3em; caption-side: bottom;
            font-size: xx-small;
        }
        caption {
           padding: 0.5em; align-content: center; font-size: large;
        }
        th { background: #eee; border: 1px solid #000; border-collapse: collapse; padding: 0.3em; caption-side: bottom; font-size: xx-small}
        tfoot { background: #eee; font-weight: bold;}
    </style>
</head>
<body>
    <img width="120px" src="../public/images/eleinca_logo.jpg">
    
    <br>

    <div align="left">
        Artículos por grupo
    </div>
    <br>

	<table>
		<thead>
			<tr>
				<th>Cod.</th>
				<th>Descrip.</th>
				<th>Modelo</th>
				<th>Ref.</th>
                <th>Peso</th>
                <th>Locación</th>
                <th>Línea</th>
                <th>Sublínea</th>
                <th>Grupo</th>
                <th>Orígen</th>
                <th>Tipo</th>
                <th>Proveedor</th>
                <th>Status</th>
                <th>Registro</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($groups as $s)
                <tr>
                    <td>{{ $s->codeArticle }}</td>
                    <td>{{ $s->nameArticle }}</td>
                    <td>{{ $s->modelArticle }}</td>
                    <td>{{ $s->referenceArticle }}</td>
                    <td>{{ $s->weightArticle }}</td>
                    <td>{{ $s->locationArticle }}</td>
                    <td>{{ $s->nameLine }}</td>
                    <td>{{ $s->nameSubline }}</td>
                    <td>{{ $s->nameGroup }}</td>
                    <td>{{ $s->nameOrigin }}</td>
                    <td>{{ $s->nameType }}</td>
                    <td>{{ $s->nameProvider }}</td>
                    @if($s->statusArticle == 1)
                    	<td>Act.</td>
                    @endif
                    @if($s->statusArticle == 0)
                    	<td>Inact.</td>
                    @endif
                    <td>
                        {{ date("d", strtotime($s->created_at)) }}/{{ date("m", strtotime($s->created_at)) }}/{{ date("Y", strtotime($s->created_at)) }} {{ date("H", strtotime($s->created_at)) }}:{{ date("i", strtotime($s->created_at)) }}:{{ date("s", strtotime($s->created_at)) }}
                    </td>
                </tr>
            @endforeach
		</tbody>
	</table>
</body>
</html>