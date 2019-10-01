<?php
use yii\widgets\LinkPager;
?>
<div class="container">
	<div class="row col-sm-12">
		<a href="/operator/addfile/<?= Yii::$app->request->get('id'); ?>" class="btn btn-primary" title="Начать добавление файлов"><i class="fa fa-file"></i> Добавить файл</a>
		<a href="/operator/indexcom" class="btn btn-primary" title="Перейти на страницу участники"><i class="fa fa-reply-all"></i> Вернуться</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="text-center">
					<td><strong>Название файла</strong></td>
					<td><strong>Дата загрузки</strong></td>
					<td colspan="2"><strong>Действия</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<td><?= $item->NameFile; ?></td>
					<td><?= Yii::$app->formatter->asDate($item->TodayDate, 'dd.MM.Y'); ?></td>
					<td><a href="/operator/download/<?= $item->Id; ?>" class="btn btn-default" title="Скачать"><i class="fa fa-download"></i></a></td>
					<td><a href="/operator/delfile/<?= $item->Id; ?>" class="btn btn-danger" title="Удалить"><i class="fa fa-trash-o"></i></a></td>
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