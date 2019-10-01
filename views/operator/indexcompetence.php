<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
?>
<div class="container">
	<div class="row col-sm-12">
		<div>
			<a href="/operator/createcompetence" class="btn btn-primary" title="Создать новую компетенцию"><i class="fa fa-plus-circle"></i> Создать</a>
			<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
	<?php
		$gridColumn = ['Name', 'Description'];
		echo ExportMenu::widget(
			[
				'dataProvider' => $dataProvider,
				'columns' => $gridColumn,
				'filename' => 'Exported-Competence',
				'exportConfig' => [
					ExportMenu::FORMAT_HTML => false,
					ExportMenu::FORMAT_CSV => false,
					ExportMenu::FORMAT_TEXT => false,
					ExportMenu::FORMAT_PDF => false,
					ExportMenu::FORMAT_EXCEL_X => false
				],
				'columnSelector' => [
					0 => 'Компетенция',
					1 => 'Описание'
				]
			]
		);
	?>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
		<?= GridView::widget(
			[
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'layout' => '{items} {pager}',
				'options'=>[
					'class' => 'table-responsive'
				],
				'tableOptions' => [
					'class' => 'table table-hover table-bordered'
				],
				'rowOptions' => [
					'class' => 'text-center'
				],
				'columns' => [
					[
						'class' => 'yii\grid\SerialColumn',
						'header' => '№',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Name',
						'header' => 'Название',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Description',
						'header' => 'Описание',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'text-center col-sm-3',
						],
						'template' => '{show} {cog} {del}',
						'buttons' => [
							'show' => function($url, $model){
								return Html::a('<i class="fa fa-eye"></i>', ['/operator/indexcriterion/'.$model->IdCompetence], ['class' => 'btn btn-default', 'title' => 'Просмотреть критерий']);
							},
							'cog' => function($url, $model){
								return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/operator/editcompetence/'.$model->IdCompetence], ['class' => 'btn btn-default', 'style' => 'margin-left:10px;', 'title' => 'Редактировать']);
							},
							'del' => function($url, $model){
								return Html::a('<i class="fa fa-trash-o"></i>', ['/operator/delcompetence/'.$model->IdCompetence], ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;', 'title' => 'Удалить']);
							}
						]
					],
				]
			]
		); ?>
	</div>
</div>
