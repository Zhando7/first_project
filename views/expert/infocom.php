<div class="container">
	<div class="row col-sm-12">
		<button type="button" onClick="window.close();" class="btn btn-primary" title="Вернуться на страницу оценивания"><i class="fa fa-reply-all"></i> Вернуться</button>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="info text-center">
					<td colspan="7"><h4>Работы участников данной команды</h4></td>
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
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="danger text-center">
					<td colspan="7"><h4>Информация об участниках команды "<?= $namecommand->Name; ?>"</h4></td>
				</tr>
				<tr class="text-center">
					<td><strong>Фамилия</strong></td>
					<td><strong>Имя</strong></td>
					<td><strong>Отчество</strong></td>
					<td><strong>Язык обучения</strong></td>
					<td><strong>Класс</strong></td>
					<td><strong>Район\город</strong></td>
					<td><strong>Школа</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($child as $itempr): ?>
				<tr class="text-center">
					<td><?= $itempr->Surname; ?></td>
					<td><?= $itempr->Name; ?></td>
					<td><?= $itempr->Patronymic; ?></td>
					<td><?= $itempr->LanguageLearning; ?></td>
					<td><?= $itempr->ClassChild; ?></td>
					<td><?= $itempr->District; ?></td>
					<td><?= $itempr->School; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	</div>
</div>