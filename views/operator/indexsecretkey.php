<?php
use app\models\Tables\Users;
?>
<div class="container">
	<div class="row col-sm-12">
		<a href="/operator/editkey/<?= $key; ?>" class="btn btn-primary" title="Создать новый секретный ключ"><i class="fa fa-plus-circle"></i> Создать новый ключ</a>
		<a href="<?= $url; ?>" class="btn btn-primary" title="Вернуться на предыдущую страницу"><i class="fa fa-reply-all"></i> Вернуться</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="text-center">
					<td><strong>Название</strong></td>
					<td><strong>Секретный ключ</strong></td>
					<td><strong>Дата и время последнего изменения</strong></td>
					<td><strong>Оператор</strong></td>
					<td><strong>Действия</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<td><?= $item->Name; ?></td>
					<td><?= $item->Key; ?></td>
					<td><?= Yii::$app->formatter->asDate($item->TodayDateTime, 'dd.MM.Y, H:i:s'); ?></td>
					<?php if($operator = Users::getOperator(Yii::$app->user->identity['IdUser'])): ?>
						<td><?= $operator->Name; ?></td>
					<?php else: ?>
						<td>...</td>
					<?php endif; ?>
					<td><a href="/operator/editkey/<?= $item->IdKey; ?>" class="btn btn-default" title="Редактировать"><i class="fa fa-cog fa-spin"></i></a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
	</div>
</div>