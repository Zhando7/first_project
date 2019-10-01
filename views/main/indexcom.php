<?php
use yii\helpers\Html;
use yii\grid\GridView;
// Используемые модели
use app\models\Tables\Partteam;
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
						'attribute' => 'Name',
						'header' => 'Название команды',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'header' => 'Количество участников',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							if($countpm = Partteam::getCountPr($model->IdUser)):
								return $countpm;
							else:
								return '...';
							endif;
						}
					],
					[
						'class' => '\yii\grid\ActionColumn',
						'header' => 'Посмотреть состав',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{select}',
						'buttons' => [
							'select' => function($url, $model){
								return Html::a('<i class="fa fa-eye"></i>', ['/main/indexpartteam/'.$model->IdUser], ['target' => '_blank', 'class' => 'btn btn-default', 'title' => 'Посмотреть состав команды']);
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>