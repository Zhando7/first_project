<?php
// Подключаемые виджеты
use yii\widgets\LinkPager;
// Подключаемые модели
use app\models\Tables\Formpoints;
/* @var $i string */
$i = 1;
?>
<div class="container">
	<div class="row col-sm-12">
		<div class="form-group">
			<a href="/operator/createcriterion/<?= $id; ?>" class="btn btn-primary" title="Создать новый критерий"><i class="fa fa-plus-circle"></i> Создать</a>
			<a href="/operator/indexcompetence" class="btn btn-primary" title="Вернуться на предыдущую страницу"><i class="fa fa-reply-all"></i> Вернуться</a>
		</div>
	</div>
	<div class="row col-sm-12" style="margin-top:10px;">
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="text-center">
					<td><strong>№</strong></td>
					<td><strong>Название</strong></td>
					<td><strong>Описание</strong></td>
					<td><strong>Форма оценивания</strong></td>
					<td colspan="2"><strong>Действия</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $item): ?>
				<tr class="text-center">
					<td><?= $i++; ?></td>
					<td><?= $item->Name; ?></td>
					<td><?= $item->Description; ?></td>
					<?php if($itemtwo = Formpoints::find()->where(['IdPoint' => $item->IdPoint])->one()): ?>
						<td><?= $itemtwo->Name; ?></td>
					<?php else: ?>
						<td>Null</td>
					<?php endif; ?>
					<td><a href="/operator/editcriterion/<?= $item->IdCriterion; ?>" class="btn btn-default" title="Редактировать"><i class="fa fa-cog fa-spin"></i></a></td>
					<td><a href="/operator/delcriterion/<?= $item->IdCriterion; ?>" class="btn btn-danger" title="Удалить"><i class="fa fa-trash-o"></i></a></td>
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