<div class="container">
	<div class="row col-sm-12">
		<button type="button" onClick="window.close();" class="btn btn-primary" title="Вернуться на страницу оценивания"><i class="fa fa-reply-all"></i> Вернуться</button>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="danger text-center">
					<td colspan="4"><h4>Информация об участнике "<?= $model->Surname.' '.$model->Name.' '.$model->Patronymic ?>"</h4></td>
				</tr>
				<tr class="text-center">
					<td><strong>Район\город</strong></td>
					<td><strong>Наименование школы</strong></td>
					<td><strong>Класс</strong></td>
					<td><strong>Язык обучения</strong></td>
				</tr>
			</thead>
			<tbody>
				<tr class="text-center">
					<td><?= $model->Field3; ?></td>
					<td><?= $model->Field4; ?></td>
					<td><?= $model->Field1; ?></td>
					<td><?= $model->Field2; ?></td>
				</tr>
			</tbody>
		</table>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="info text-center">
					<td colspan="2"><h4>Работы данного участника</h4></td>
				</tr>
				<tr class="text-center">
					<td><strong>Название файла</strong></td>
					<td><strong>Действия</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($files as $itemfs): ?>
				<tr class="text-center">
					<td><?= $itemfs->NameFile; ?></td>
					<td><a href="/expert/download/<?= $itemfs->Id; ?>" class="btn btn-default btn-sm" title="Скачать работу"><i class="fa fa-download "></i></a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	</div>
</div>