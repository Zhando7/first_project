<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;

use app\models\Tables\Partteam;
?>
<div class="container">
	<div class="row col-sm-12">
		<div>
			<a href="/operator/createchild/<?= Yii::$app->request->get('id'); ?>" class="btn btn-primary" title="Создать нового участника"><i class="fa fa-plus-circle"></i> Создать участника</a>
			<a href="/operator/indexcom" class="btn btn-primary" title="Вернуться на предыдущю страницу"><i class="fa fa-reply-all"></i> Вернуться</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
	<?php
		$gridColumn = ['Surname', 'Name', 'Patronymic', 'LanguageLearning', 'ClassChild', 'District', 'School'];
		echo ExportMenu::widget(
			[
				'dataProvider' => $dataProvider,
				'columns' => $gridColumn,
				'filename' => 'Exported-Partteam',
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
					3 => 'Язык обучения',
					4 => 'Класс',
					5 => 'Район\город',
					6 => 'Школа'
				]
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
								return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/operator/editchild/'.$model->IdChild], ['class' => 'btn btn-default', 'title' => 'Редактировать']);
							},
							'del' => function($url, $model){
								return Html::a('<i class="fa fa-trash-o"></i>', ['/operator/delchild/'.$model->IdChild], ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;', 'title' => 'Удалить']);
							}
						]
					]
				]
			]
		); ?>
	</div>
</div>