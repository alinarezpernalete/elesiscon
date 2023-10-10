<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width-device-width, initial-scale=1.0">
	<title>Grafico</title>
</head>
<body>
	<div id="container"></div>

<script src="../js/highcharts.js"></script>
<script type="text/javascript">
	var datas = <?php echo json_encode ($datas) ?>;
	Highcharts.chart('container', {
		title: { text:  'Reporte por Proyectos' },
		/*subtitle: { text: 'fuete de ejemplo' },*/
		/*xAxis: { categories: ['Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab', 'Dom'] },*/
		yAxis: { title: { text: 'Horas' } },
		legend: { layout: 'vertical', aling: 'right',  verticalAling: 'middle' },
		plotOptions: { series: { alllowPointSelect: true } },
		series: [{ name: 'Ejecución de Proyectos', data: datas }],
		responsive: {
			rules: [{
				condition: { maxwidth: 500 },
				charOptions: { legend: { layout: 'horizontal', aling: 'center', verticalAling: 'bottom' } }
			}]
		}
	});
</script>

</body>
</html>