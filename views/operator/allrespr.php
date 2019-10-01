<?php 
use yii\widgets\LinkPager;

use app\models\Tables\Resultspr;
?>
<div class="container">
	<div class="row">
		<div class="col-sm-12">
			<a href="/index" class="btn btn-primary"><i class="fa fa-home"></i> На главную</a>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12" style="margin-top:20px;">
			<div class="table-responsive">
				<table class="table table-bordered table-hover">
					<thead>
						<tr class="danger text-center">
							<td><strong>Дата оценивания</strong></td>
							<td><strong>Действия</strong></td>
						</tr>
					</thead>
					<tbody>
						<?php foreach($model as $item): ?>
						<?php if(Resultspr::checkExistResult($item->IdEvalution)): ?>
							<tr class="text-center">
								<td><?= Yii::$app->formatter->asDate($item->TodayDate, 'dd.MM.Y'); ?></td>
								<td><a href="/operator/totalpr/<?= $item->IdEvalution; ?>" class="btn btn-default" title="Посмотреть общий итог"><i class="fa fa-eye"></i></a></td>
							</tr>
						<?php endif; ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?= LinkPager::widget([
				'pagination' => $pages
			]); ?>
		</div>
	</div>
</div>