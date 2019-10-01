<?php
use app\models\Tables\Users;
$n = 1;
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<a href="<?= $url; ?>" class="btn btn-primary" title="Вернуться на предыдущую страницу"><i class="fa fa-reply-all"></i> Вернуться</a>
		</div>
	</div>
	<div class="row" style="margin-top: 20px;">
		<div class="col-sm-12">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr class="danger text-center">
							<td><strong>№</strong></td>
							<td><strong>Название команды</strong></td>
							<td><strong>Результат</strong></td>
						</tr>
					</thead>
					<tbody>
					<?php for($i = 0; $i < count($mas); $i++): ?>
					<?php $name = Users::getPr($mas[$i]['id']); ?>
						<tr class="text-center">
							<td><?= $n++; ?></td>
							<td><?= $name->Surname.' '.$name->Name.' '.$name->Patronymic; ?></td>
							<td><?= $mas[$i]['result']; ?></td>
						</tr>
					<?php endfor; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>