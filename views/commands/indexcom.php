<?php
use yii\helpers\Html;
use yii\grid\GridView;

use app\models\Tables\Partteam;
?>
<div class="container">
	<div class="row col-sm-12">
		<a href="/commands/addpr" class="btn btn-primary" title="Добавить нового участника"><i class="fa fa-plus-circle"></i> Добавить участника</a>
		<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<?= GridView::widget(
			[
				'dataProvider' => $dataProvider,
				'layout' => '{items}',
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
							if($result = Partteam::getCountPr($model->IdUser)):
								return $result;
							else:
								return '...';
							endif;
						}
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
									return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/commands/editcom'], ['class' => 'btn btn-default', 'title' => 'Редактировать']);
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
	<div class="row col-sm-12">
		<?= GridView::widget(
			[
				'dataProvider' => $dataProviderTwo,
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
						'attribute' => 'LanguageLearning',
						'header' => 'Язык обучения',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'ClassChild',
						'header' => 'Класс',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'District',
						'header' => 'Район\город',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'School',
						'header' => 'Школа',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'class' => '\yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'text-center col-sm-2'
						],
						'template' => '{edit} {del}',
						'buttons' => [
							'edit' => function($url, $model){
								return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/commands/editchild/'.$model->IdChild], ['class' => 'btn btn-default', 'title' => 'Редактировать']);
							},
							'del' => function($url, $model){
								return Html::a('<i class="fa fa-trash-o"></i>', ['/commands/delchild/'.$model->IdChild], ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;', 'title' => 'Удалить']);
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>