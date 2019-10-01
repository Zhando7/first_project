<?php
// Используемые виджеты
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
// Используемые модели
use app\models\Tables\Resultscom;
?>
<div class="container">
	<div class="row col-sm-12">
		<div class="form-group">
			<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
		</div>
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
						'attribute' => 'Competence',
						'header' => 'Компетенция',
						'headerOptions' => [
							'class' => 'text-center'
						],
					],
					[
						'attribute' => 'NameEvalution',
						'header' => 'Название',
						'headerOptions' => [
							'class' => 'text-center'
						],
					],
					[
						'attribute' => 'TodayDate',
						'header' => 'Дата оценивания',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'filter' => DatePicker::widget(
							[
								'model' => $searchModel,
								'attribute' => 'TodayDate',
								'language' => 'ru',
								'pluginOptions' => [
									'format' => 'yyyy-mm-dd'
								]
							]
						),
						'value' => function($model){
							return Yii::$app->formatter->asDate($model->TodayDate, 'dd.MM.Y');
						}
					],
					[
						'header' => 'Кол-во команд',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							return Resultscom::getCountEva($model->IdEvalution);
						}
					],
					[
						'class' => '\yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'col-sm-2 text-center'
						],
						'template' => '{show} {del}',
						'buttons' => [
							'show' => function($url, $model){
								return Html::a('<i class="fa fa-eye"></i>', ['/main/indexselectcom/'.$model->IdEvalution], ['class' => 'btn btn-default', 'title' => 'Посмотреть результаты']);
							},
							'del' => function($url, $model){
								if(Yii::$app->user->identity['AuthKey'] == 1):
									return Html::a('<i class="fa fa-trash-o"></i>', ['/operator/deleteresultcom/'.$model->IdEvalution], [
										'class' => 'btn btn-danger', 
										'style' => 'margin-left:10px;', 
										'title' => 'Удалить результаты оценивания'
									]);
								endif;
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>