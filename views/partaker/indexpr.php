<?php
use yii\helpers\Html;
use yii\grid\GridView;
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
						'attribute' => 'Surname',
						'header' => 'Фамилия',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Name',
						'header' => 'Имя',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Patronymic',
						'header' => 'Отчество',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Field1',
						'header' => 'Класс',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Field2',
						'header' => 'Язык обучения',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Field3',
						'header' => 'Район\город',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Field4',
						'header' => 'Школа',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{cog}',
						'buttons' => [
							'cog' => function($url, $model){
								if(Yii::$app->user->identity['IdUser'] == $model->IdUser):
									return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/partaker/editpr'], ['class' => 'btn btn-default', 'title' => 'Редактировать']);
								else:
									return '...';
								endif;
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>