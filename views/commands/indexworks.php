<?php
use yii\widgets\LinkPager;
?>
<div class="container">
	<div class="row col-sm-12">
		<div class="alert alert-danger">
			<button type="button" class="close" data-dismiss="alert">x</button>
			<p>Названия файлов должны быть на <strong>латинском языке!</strong></p>
		</div>
	</div>
	<div class="row col-sm-12">
		<a href="/commands/addfile" class="btn btn-primary" title="Начать добавление файлов"><i class="fa fa-file"></i> Добавить файл</a>
		<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
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
					<td><a href="/commands/download/<?= $item->Id; ?>" class="btn btn-default" title="Скачать"><i class="fa fa-download"></i></a></td>
					<td><a href="/commands/delfile/<?= $item->Id; ?>" class="btn btn-danger" title="Удалить"><i class="fa fa-trash-o"></i></a></td>
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