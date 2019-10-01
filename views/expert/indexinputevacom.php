<?php
/* Подключаемые виджеты */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* Используемые модели */
use app\models\Tables\Users;
use app\models\Tables\Competence;
use app\models\Tables\Criterion;
use app\models\Tables\Formpoints;

$form = ActiveForm::begin();
?>
<div class="container">
	<div class="row col-sm-12">
		<button type="submit" class="btn btn-primary" title="Закончить оценивание"><i class="fa fa-check"></i> Закончить оценивание</button>
		<a href="/expert/indexevacom" class="btn btn-primary" title="Вернуться на предыдущую страницу"><i class="fa fa-reply-all"></i> Вернуться</a>
	</div>
	<div class="row col-sm-12" style="margin-top:20px;">
		<?php foreach($commands as $itemcom): ?>
		<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr class="text-center">
					<?php if($namecom = Users::getCom($itemcom->IdCommand)):?>
						<td class="danger" colspan="5">
							<h4>
								<a target="_blank" href="/expert/infocom/<?= $itemcom->IdCommand; ?>" title="Информация об команде"><i class="fa fa-info-circle"></i></a>
								<?= ''.$namecom->Name ?>
							</h4>
						</td>
					<?php else: ?>
						<td class="danger" colspan="5">...</td>
					<?php endif; ?>
				</tr>
				<tr class="text-center">
					<td><strong>Компетенция</strong></td>
					<td><strong>Критерий</strong></td>
					<td><strong>Описание</strong></td>
					<td><strong>Форма оценивания</strong></td>
					<td><strong>Балл</strong></td>
				</tr>
			</thead>
			<tbody>
				<?php foreach($model as $index => $item): ?>
					<?php if($itemcom->IdCommand == $item->IdCommand): ?>
					<tr class="text-center">
						<?php if($competence = Competence::getOne($item->IdCompetence)):?>
							<td><?= $competence->Name; ?></td>
						<?php else: ?>
							<td>...</td>
						<?php endif; ?>
						<?php if(($criterion = Criterion::getOne($item->IdCriterion)) and ($point = Formpoints::getOne($criterion->IdPoint))):?>
							<td><?= $criterion->Name; ?></td>
							<td><?= $criterion->Description; ?></td>
							<td><?= $point->Name;?></td>
						<?php else: ?>
							<td>...</td>
							<td>...</td>
							<td>...</td>
						<?php endif; ?>
						<?php if($point->Final > 1): ?>
							<td class="col-sm-1"><?= $form->field($item, "[$index]Evalution")->textInput(['type' => 'number', 'max' => ''.$point->Final, 'min' => '0', 'step' => '0.1'])->Label(false); ?></td>
						<?php else: ?>
							<td class="col-sm-1"><?= $form->field($item, "[$index]Evalution")->textInput(['type' => 'number', 'max' => ''.$point->Final, 'min' => '0',])->Label(false); ?></td>
						<?php endif; ?>
					</tr>
					<?php endif; ?> 
				<?php endforeach; ?>
			</tbody>
		</table>
		</div>
		<?php endforeach; ?>
	</div>
	<script>
		$(document).ready(function() {
			$(window).scroll(function() {
				// Высота проявления кнопки
				if ($(this).scrollTop() > 100) {
					$('#go-to-top').fadeIn();
				} else {
					$('#go-to-top').fadeOut();
				}
			});
			
			$('#go-to-top').click(function() {
				$('body,html').animate({
					scrollTop: 0
				// Скорость подъема
				}, 250);
				return false;
			});

		});
	</script>
	<div class="row col-sm-12" align="center">
		<a id="go-to-top" href="#" class="btn btn-primary" style="display: none;" title="Незамедлительно вверх">Наверх</a>
	</div>
</div>
<?php
ActiveForm::end();
?>