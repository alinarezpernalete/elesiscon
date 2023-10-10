<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Cotización</title>
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
		Fecha de Cotización: {{ date("d", strtotime($quotationDat[0]->created_at)) }}/{{ date("m", strtotime($quotationDat[0]->created_at)) }}/{{ date("Y", strtotime($quotationDat[0]->created_at)) }}<br>
	</div>
	<div align="left">
		Código de Cotización: {{ $quotation->codeSale }}<br>
		RIF: {{ $quotation->codeCustomer }}<br>
		Nombre del Cliente: {{ $quotation->nameCustomer }}<br>
		Dirección: {{ $quotation->addressCustomer }}<br>
		Teléfonos: {{ $quotation->phoneCustomer }}<br>
		Moneda: Bolívares Soberanos<br>
		Cond. Pago: {{ $quotation->namePayment }}<br>
		Observaciones: {{ $quotation->descriptionSale }}<br>
		Generada por: {{ $quotation->name }}
	</div>

	<br>
	<hr>
	<br>	
	
	<table>
		<caption>Detalles en cotización</caption>
		<thead>
			<tr>
				<th width="100">Código</th>
				<th width="200">Descripción</th>
				<th>Cantidad cot.</th>
				<th>Cantidad pend.</th>
				<th>Precio p/unidad</th>
			</tr>
		</thead>
		<tbody>
			@foreach ($quotationDet as $q)
            <tr>
                <td>{{ $q->codeArticle }}</td>
                <td>{{ $q->nameArticle }}</td>
                <td>{{ $q->amountArticle }}</td>
                <td>{{ $q->pendingAmountArticle }}</td>
                <td>{{ $q->unitPriceArticle }}</td>
            </tr>
            @endforeach
		</tbody>
		<tfoot>
	    	<tr>
	      		<td></td>
	      		<td></td>
	      		<td></td>
	      		<td>Total</td>
	      		<td>{{ $quotationTot[0]->total }}</td>
	    	</tr>
	  	</tfoot>
	</table>
</body>
</html>