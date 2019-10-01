<?php
use yii\widgets\LinkPager;
use yii\data\ActiveDataProvider;
use kartik\export\ExportMenu;
// Используемые модели
use app\models\Tables\Partteam;
/* @var $i integer */
$i = 1;
?>
<div class="container">
	<div class="row col-sm-12">
		<?php if(Yii::$app->user->identity['AuthKey'] == 1): ?>
		<?php
			$gridColumn = ['NameCommand', 'Result'];
			echo ExportMenu::widget(
				[
					'dataProvider' => new ActiveDataProvider(
						[
							'query' => $query
						]
					),
					'columns' => $gridColumn,
					'filename' => 'Export-Results-Comands',
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
		?>
		<?php endif; ?>
		<a href="/main/graphresultcom/<?= $info->IdEvalution; ?>" class="btn btn-primary" title="Посмотреть мониторинг результатов"><i class="fa fa-bar-chart"></i> Мониторинг результатов</a>
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
					<td><strong>Название команды</strong></td>
					<td><strong>Кол-во баллов</strong></td>
					<td><strong>Кол-во участников</strong></td>
					<td><strong>Посмотреть состав</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<td><?= $i++; ?></td>
					<td><?= $item->NameCommand; ?></td>
					<td><?= $item->Result; ?></td>
					<?php if($result = Partteam::getCountPr($item->IdCommand)): ?>
						<td><?= $result; ?></td>
					<?php else: ?>
						<td>...</td>
					<?php endif; ?>
					<td><a target="_blank" href="/main/indexpartteam/<?= $item->IdCommand; ?>" class="btn btn-default" title="Посмотреть состав команды"><i class="fa fa-eye"></i> </a></td>
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