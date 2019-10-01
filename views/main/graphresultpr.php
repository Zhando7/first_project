<script>
FusionCharts.ready(function(){
      var revenueChart = new FusionCharts({
        "type": "column2d",
        "renderAt": "chartContainer",
        "width": "580",
        "height": "480",
        "dataFormat": "json",
        "dataSource": {
          "chart": {
              "caption": "Топ 20 участников",
              "subCaption": "",
              "xAxisName": "Участники",
              "yAxisName": "Баллы",
              "theme": "fint"
           },
          "data": <?= $graph; ?>
        }
    });

    revenueChart.render();
})
</script>
<div class="container">
	<div class="row col-sm-12">
		<a href="/main/indexselectpr/<?= $id; ?>" class="btn btn-primary"><i class="fa fa-reply-all"></i> Вернуться</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><h4 class="text-center">Мониторинг результатов</h4></div>
			</div>
			<div class="panel-body">
				<div class="col-sm-12" id="chartContainer" align="center" style="margin-top:20px;"></div>
			</div>
		</div>
	</div>
</div>