<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;
?>
<div class="container">
	<div class="row col-sm-12">
		<div>
			<a href="/operator/createexp" class="btn btn-primary" title="Создать нового эксперта"><i class="fa fa-plus-circle"></i> Создать эксперта</a>
			<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
	<?php
		$gridColumn = ['Surname', 'Name', 'Patronymic', 'Field1', 'Field2', 'Password'];
		echo ExportMenu::widget(
			[
				'dataProvider' => $dataProvider,
				'columns' => $gridColumn,
				'filename' => 'Exported-Experts',
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
					3 => 'Регион',
					4 => 'Должность',
					5 => 'Контакты'
				],
				
			]
		);
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
						'header' => 'Регион',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Field2',
						'header' => 'Должность',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Password',
						'header' => 'Контакты',
						'headerOptions' => [
							'class' => 'text-center'
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
								return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/operator/editexp/'.$model->IdUser], ['class' => 'btn btn-default', 'title' => 'Редактировать']);
							},
							'del' => function($url, $model){
								return Html::a('<i class="fa fa-close"></i>', ['/operator/deleteexp/'.$model->IdUser], ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;', 'title' => 'Удалить']);
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>