<?php
// Используемые виджеты
use yii\helpers\Html;
use yii\grid\GridView;
// Используемые модели
use app\models\Tables\Crudevalutioncom;
?>
<div class="container">
	<div class="row col-sm-12">
		<a href="/commands/indexbid" class="btn btn-primary" title="Перейти на страницу заявок"><i class="fa fa-paperclip"></i> Заявки</a>
		<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<?= GridView::widget(
			[
				'dataProvider' => $dataProvider,
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
						'class' => '\yii\grid\SerialColumn',
						'header' => '№',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'header' => 'Название заявки',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							if($result = Crudevalutioncom::getOne($model->IdEvalution)):
								return $result->Name;
							else:
								return '...';
							endif;
						}
					],
					[
						'header' => 'Дата начала',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							if($result = Crudevalutioncom::getOne($model->IdEvalution)):
								return Yii::$app->formatter->asDate($result->TodayDate, 'dd.MM.Y');
							else:
								return '...';
							endif;
						}
					],
					[
						'class' => '\yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{del}',
						'buttons' => [
							'del' => function($url, $model){
								$one = Crudevalutioncom::getOne($model->IdEvalution);
								if($one->TodayDate == date('Y-m-d')):
									return Html::a('<i class="fa fa-spinner fa-pulse"></i>', ['#'], ['class' => 'btn btn-primary disabled']);
								else:
									return Html::a('<i class="fa fa-close"></i>', ['/commands/delbid/'.$model->IdEvalution], ['class' => 'btn btn-danger', 'title' => 'Отменить завку']);
								endif;
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>