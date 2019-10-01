<?php
use yii\widgets\LinkPager;

/* @var $i string */
$i = 1;
?>
<div class="container">
	<div class="row col-sm-12">
		<div class="form-group">
			<a href="/operator/createpoint" class="btn btn-primary" title="Создать новую форму оценивания"><i class="fa fa-plus-circle"></i> Создать</a>
			<a href="/index" class="btn btn-primary" title="Перейти на главную страницу"><i class="fa fa-home"></i> На главную</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="text-center">
					<td><strong>№</strong></td>
					<td><strong>Форма оценивания</strong></td>
					<td><strong>От</strong></td>
					<td><strong>До</strong></td>
					<td class="col-sm-2" colspan="2"><strong>Действия</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<td><?= $i++; ?></td>
					<td><?= $item->Name; ?></td>
					<td><?= $item->Initial; ?></td>
					<td><?= $item->Final; ?></td>
					<td><a href="/operator/editpoint/<?= $item->IdPoint; ?>" class="btn btn-default" title="Редактировать"><i class="fa fa-cog fa-spin"></i></a></td>
					<td><a href="/operator/delpoint/<?= $item->IdPoint; ?>" class="btn btn-danger" title="Удалить"><i class="fa fa-trash-o"></i></a></td>
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
