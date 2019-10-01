<?php
// Используемые виджеты
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\date\DatePicker;
// Используемые модели
use app\models\Tables\Userfiles;
use app\models\Tables\Competence;
use app\models\Tables\Bidpr;
// @var $check boolean
?>
<div class="container">
	<?php if(!Userfiles::getUser()): ?>
	<div class="row col-sm-12">
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert"><i class="fa fa-close" title="Закрыть оповещение"></i></button>
			<strong>Загрузите</strong> свой работы для подачи заявок на оценивания!
		</div>
	</div>
	<?php endif; ?>
	<div class="row col-sm-12">
		<a href="/partaker/indexmybid" class="btn btn-primary" title="Посмотреть мой заявки"><i class="fa fa-paperclip"></i> Мои заявки</a>
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
						'attribute' => 'IdCompetence',
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
						'header' => 'Название оценивания',
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
						'attribute' => 'Limit',
						'header' => 'Ограничения',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							if($model->Limit == 0):
								return 'Нет';
							else:
								return $model->Limit;
							endif;
						}
					],
					[
						'header' => 'Подано заявок',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'value' => function($model){
							return Bidpr::getAllCount($model->IdEvalution);
						}
					],
					[
						'class' => '\yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{universal}',
						'buttons' => [
							'universal' => function($url, $model){
								if(Userfiles::getUser()):
									if(Bidpr::getMyBid($model->IdEvalution)):
										return Html::a('<i class="fa fa-close"></i>', ['/partaker/delbid/'.$model->IdEvalution], ['class' => 'btn btn-danger', 'title' => 'Отменить заявку']);
									else:
										if(($model->Limit == 0) or ($model->Limit > Bidpr::getAllCount($model->IdEvalution))):
											return Html::a('<i class="fa fa-plus"></i>', ['/partaker/addbid/'.$model->IdEvalution], ['class' => 'btn btn-default', 'title' => 'Добавить заявку']);
										else:
											return '';
										endif;
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