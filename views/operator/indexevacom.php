<?php
use yii\widgets\LinkPager;
// Используемые модели
use app\models\Tables\Users; 
?>
<div class="container">
	<div class="row col-sm-12">
		<div class="form-group">
			<a href="/operator/addbidcom/<?= $id; ?>" class="btn btn-primary" title="Добавить команде заявку"><i class="fa fa-plus-circle"></i> Добавить команду</a>
			<a href="/operator/indexcrudevacom" class="btn btn-primary" title="Вернуться на страницу созданных оцениваний"><i class="fa fa-reply-all"></i> Вернуться</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="text-center">
					<td><strong>Название команды</strong></td>
					<td><strong>Действия</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<?php $info = Users::getCom($item->IdUser); ?>
					<td><?= $info->Name; ?></td>
					<td><a href="/operator/deleteevacom/<?= $item->IdUser; ?>" class="btn btn-danger" title="Удалить заявку"><i class="fa fa-close"></i></a></td>
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