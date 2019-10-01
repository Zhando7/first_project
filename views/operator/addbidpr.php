<?php
// Подключаемые виджеты
use yii\helpers\Html;
use yii\grid\GridView;
// Используемые модели
use app\models\Tables\Bidpr;
?>
<div class="container">
	<div class="row col-sm-12">
		<a href="/operator/indexevapr/<?= $id; ?>" class="btn btn-primary" title="Вернуться на предыдущую страницу"><i class="fa fa-reply-all"></i> Вернуться</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<?= GridView::widget(
			[
				'dataProvider' => $dataProvider,
				'filterModel' => $searchModel,
				'layout' => '{items} {pager}',
				'options' => [
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
						'attribute' => 'Field3',
						'header' => 'Район',
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
						'attribute' => 'Field1',
						'header' => 'Класс',
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
						'template' => '{uni}',
						'buttons' => [
							'uni' => function($url, $model) use ($id){
								if(Bidpr::findUser($id, $model->IdUser)):
									return Html::a('<i class="fa fa-close"></i>', ['/operator/deleteevapr/'.$model->IdUser], ['class' => 'btn btn-danger', 'title' => 'Удалить заявку']);
								else:
									if(($limit > Bidpr::getAllCount($id)) or ($limit == 0)):
										return Html::a('<i class="fa fa-plus"></i>', ['/operator/addpr/'.$model->IdUser], ['class' => 'btn btn-default', 'title' => 'Добавить заявку']);
									else:
										return '...';
									endif;
								endif;
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>