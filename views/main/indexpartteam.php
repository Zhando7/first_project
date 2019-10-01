<div class="container">
	<div class="row col-sm-12">
		<button type="button" onClick="window.close();" class="btn btn-primary" title="Вернуться на предыдущую страницу"><i class="fa fa-reply-all"></i> Вернуться</button>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="danger text-center">
					<td colspan="5"><h4>Состав команды</h4></td>
				</tr>
				<tr class="text-center">
					<td><strong>ФИО участника</strong></td>
					<td><strong>Район\город</strong></td>
					<td><strong>Школа</strong></td>
					<td><strong>Класс</strong></td>
					<td><strong>Язык обучения</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<td><?= $item->Surname.' '.$item->Name.' '.$item->Patronymic; ?></td>
					<td><?= $item->District; ?></td>
					<td><?= $item->School; ?></td>
					<td><?= $item->ClassChild; ?></td>
					<td><?= $item->LanguageLearning; ?></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	</div>
</div>