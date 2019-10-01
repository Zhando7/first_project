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
		<div class="form-group">
			<a href="/operator/createevapr" class="btn btn-primary" title="Создать новое оценивание для участников"><i class="fa fa-plus-circle"></i> Создать</a>
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
						],
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
						'attribute' => 'Limit',
						'header' => 'Ограничения',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							if($model->Limit == 0):
								return 'Нет / '.Bidpr::getAllCount($model->IdEvalution);
							else:
								return $model->Limit.' / '.Bidpr::getAllCount($model->IdEvalution);
							endif;
						}
					],
					[
						'attribute' => 'Show',
						'header' => 'Показывать экспертам',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'format' => 'raw',
						'filter' => [
							0 => 'Да',
							1 => 'Нет'
						],
						'value' => function($model){
							if($model->Show == 0):
								return 'Да';
							else:
								return 'Нет';
							endif;
						}
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Заявки',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{show}',
						'buttons' => [
							'show' => function($url, $model){
								return Html::a('<i class="fa fa-eye"></i>', ['/operator/indexevapr/'.$model->IdEvalution], ['class' => 'btn btn-default', 'title' => 'Посмотреть заявки']);
							}
						]
					],
					[
						'class' => '\yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'text-center col-sm-2'
						],
						'template' => '{cog} {del}',
						'buttons' => [
							'cog' => function($url, $model){
								return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/operator/editevapr/'.$model->IdEvalution], ['class' => 'btn btn-default', 'title' => 'Редактировать']);
							},
							'del' => function($url, $model){
								return Html::a('<i class="fa fa-trash-o"></i>', ['/operator/delevapr/'.$model->IdEvalution], ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;', 'title' => 'Удалить']);
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>