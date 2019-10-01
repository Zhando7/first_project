<?php
use yii\widgets\LinkPager;
use yii\data\ActiveDataProvider;
use kartik\export\ExportMenu;
/* @var $i integer */
$i = 1;
?>
<div class="container">
	<div class="row col-sm-12">
		<?php if(Yii::$app->user->identity['AuthKey'] == 1): 
			$gridColumn = ['Fio', 'Result', 'District', 'School', 'ClassChild', 'Language'];
			echo ExportMenu::widget(
				[
					'dataProvider' => new ActiveDataProvider(
						[
							'query' => $query
						]
					),
					'columns' => $gridColumn,
					'filename' => 'Export-Results-Pr',
					'exportConfig' => [
						ExportMenu::FORMAT_HTML => false,
						ExportMenu::FORMAT_CSV => false,
						ExportMenu::FORMAT_TEXT => false,
						ExportMenu::FORMAT_PDF => false,
						ExportMenu::FORMAT_EXCEL_X => false
					],
					'showColumnSelector' => false,
				]
			);
		endif; ?>
		<a href="/main/graphresultpr/<?= $info->IdEvalution; ?>" class="btn btn-primary" title="Посмотреть мониторинг результатов"><i class="fa fa-bar-chart"></i> Мониторинг результатов</a>
		<a href="<?= $url; ?>" class="btn btn-primary" title="Вернуться на предыдущую страницу"><i class="fa fa-reply-all"></i> Вернуться</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="danger text-center">
					<td colspan="7"><h4><?= $info->NameEvalution; ?></h4></td>
				</tr>
				<tr class="text-center">
					<td><strong>№</strong></td>
					<td><strong>ФИО участника</strong></td>
					<td><strong>Кол-во баллов</strong></td>
					<td><strong>Район/город</strong></td>
					<td><strong>Наименование школы</strong></td>
					<td><strong>Класс</strong></td>
					<td><strong>Язык обучения</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<td><?= $i++; ?></td>
					<td><?= $item->Fio; ?></td>
					<td><?= $item->Result; ?></td>
					<td><?= $item->District; ?></td>
					<td><?= $item->School; ?></td>
					<td><?= $item->ClassChild; ?></td>
					<td><?= $item->Language; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	</div>
	<div class="row col-sm-12">
		<?= LinkPager::widget(
			[
				'pagination' => $pages
			]
		); ?>
	</div>
</div>