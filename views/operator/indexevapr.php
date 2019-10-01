<?php
use yii\widgets\LinkPager;
// Используемые модели
use app\models\Tables\Users; 
?>
<div class="container">
	<div class="row col-sm-12">
		<div class="form-group">
			<a href="/operator/addbidpr/<?= $id; ?>" class="btn btn-primary" title="Добавить участнику заявку"><i class="fa fa-plus-circle"></i> Добавить участника</a>
			<a href="/operator/indexcrudevapr" class="btn btn-primary" title="Вернуться на страницу созданных оцениваний"><i class="fa fa-reply-all"></i> Вернуться</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="text-center">
					<td><strong>ФИО участника</strong></td>
					<td><strong>Действия</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<?php $info = Users::getPr($item->IdUser); ?>
					<td><?= $info->Surname.' '.$info->Name.' '.$info->Patronymic; ?></td>
					<td><a href="/operator/deleteevapr/<?= $item->IdUser; ?>" class="btn btn-danger" title="Удалить заявку"><i class="fa fa-close"></i></a></td>
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