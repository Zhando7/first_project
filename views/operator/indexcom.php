<?php
use yii\helpers\Html;
use yii\grid\GridView;
use kartik\export\ExportMenu;

use app\models\Tables\Partteam;
?>
<div class="container">
	<div class="row col-sm-12">
		<div>
			<a href="/operator/createcom" class="btn btn-primary" title="Создать новую команд"><i class="fa fa-plus-circle"></i> Создать команду</a>
			<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
	<?php
		$gridColumn = ['Name', 'Email'];
		echo ExportMenu::widget(
			[
				'dataProvider' => $dataProvider,
				'columns' => $gridColumn,
				'filename' => 'Exported-Commands',
				'exportConfig' => [
					ExportMenu::FORMAT_HTML => false,
					ExportMenu::FORMAT_CSV => false,
					ExportMenu::FORMAT_TEXT => false,
					ExportMenu::FORMAT_PDF => false,
					ExportMenu::FORMAT_EXCEL_X => false
				],
				'columnSelector' => [
					0 => 'Команда',
					1 => 'Почта'
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
						'class' => 'yii\grid\ActionColumn',
						'header' => 'Состав',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{show}',
						'buttons' => [
							'show' => function($url, $model){
								return Html::a('<i class="fa fa-users"></i>', ['/operator/indexpartteam/'.$model->IdUser], ['class' => 'btn btn-default', 'title' => 'Посмотреть состав команды']);
							}
						]
					],
					[
						'attribute' => 'Name',
						'header' => 'Название команды',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Email',
						'header' => 'Почта',
						'headerOptions' => [
							'class' => 'text-center'
						]
					],
					[
						'attribute' => 'Password',
						'header' => 'Пароль',
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
						'header' => 'Файлы',
						'headerOptions' => [
							'class' => 'text-center'
						],
						'template' => '{show}',
						'buttons' => [
							'show' => function($url, $model){
								return Html::a('<i class="fa fa-file-text"></i>', ['/operator/indexworkscom/'.$model->IdUser], ['class' => 'btn btn-default', 'title' => 'Посмотреть файлы команды']);
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
								return Html::a('<i class="fa fa-cog fa-spin"></i>', ['/operator/editcom/'.$model->IdUser], ['class' => 'btn btn-default', 'title' => 'Редактировать']);
							},
							'del' => function($url, $model){
								return Html::a('<i class="fa fa-close"></i>', ['/operator/deletecom/'.$model->IdUser], ['class' => 'btn btn-danger', 'style' => 'margin-left:10px;', 'title' => 'Удалить']);
							}
						]
					]	
				]
			]
		); ?>
	</div>
</div>