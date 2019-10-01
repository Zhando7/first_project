<?php
// Используемые виджеты
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
// Используемые модели
use app\models\Tables\Competence;
use app\models\Tables\Bidpr;
?>
<div class="container">
	<div class="row col-sm-12">
		<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
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
						'header' => 'Компетенция',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							if($result = Competence::getOne($model->IdCompetence)):
								return $result->Name;
							else:
								return '...';
							endif;
						}
					],
					[
						'attribute' => 'Name',
						'header' => 'Название',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'TodayDate',
						'header' => 'Дата начала',
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
						'header' => 'Ограничения',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							if($model->Limit == 0):
								return 'Нет / '. Bidpr::getAllCount($model->IdEvalution);
							else:
								return $model->Limit . ' / ' . Bidpr::getAllCount($model->IdEvalution);
							endif;
						}
					],
					[
						'class' => '\yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{begin}',
						'buttons' => [
							'begin' => function($url, $model){
								return Html::a('<i class="fa fa-bar-chart"></i>', ['/expert/beginevapr/'.$model->IdEvalution], ['class' => 'btn btn-default', 'title' => 'Оценивать']);
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>