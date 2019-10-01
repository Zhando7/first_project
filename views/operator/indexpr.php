<?php
use yii\helpers\Html;
use kartik\export\ExportMenu;
use yii\grid\GridView;
?>
<div class="container">
	<div class="row col-sm-12">
		<div>
			<a href="/operator/createpr" class="btn btn-primary" title="Создать нового участника"><i class="fa fa-plus-circle"></i> Создать участника</a>
			<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
		<?php
			$gridColumns = ['Surname', 'Name', 'Patronymic', 'Field1', 'Field2', 'Field3', 'Field4', 'Email'];
			echo ExportMenu::widget([
				'dataProvider' => $dataProvider,
				'columns' => $gridColumns,
				'filename' => 'Exported-Y4astniki',
				'exportConfig' => [
					ExportMenu::FORMAT_HTML => false,
					ExportMenu::FORMAT_CSV => false,
					ExportMenu::FORMAT_TEXT => false,
					ExportMenu::FORMAT_PDF => false,
					ExportMenu::FORMAT_EXCEL_X => false
				],
				'columnSelector' => [
					0 => 'Фамилия',
					1 => 'Имя',
					2 => 'Отчество',
					3 => 'Класс',
					4 => 'Язык обучения',
					5 => 'Район\город',
					6 => 'Школа',
					7 => 'Почта'
				]
			]);
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
						'header' => 'Файлы',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{show}',
						'buttons' => [
							'show' => function($url, $model){
								return Html::a('<i class="fa fa-file-text"></i>', ['/operator/indexworkspr/'.$model->IdUser], ['class' => 'btn btn-default', 'title' => 'Посмотреть файлы участника']);
							}
						]
					],
					[
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Действия',
						'headerOptions' => [
							'class' => 'col-sm-2 text-center'
						],
						'template' => '{cog} {del}',
						'buttons' => [
							'cog' => function($url, $model){
								return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/operator/editpr/'.$model->IdUser], ['class' => 'btn btn-default', 'title' => 'Редактировать']);
							},
							'del' => function($url, $model){
								return Html::a('<i class="fa fa-close"></i>', ['/operator/deletepr/'.$model->IdUser], ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;', 'title' => 'Удалить']);
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>