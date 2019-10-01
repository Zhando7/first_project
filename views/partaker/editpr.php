<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $one app\models\Tables\Users */
/* @var $form ActiveForm */
?>
<div class="container">
	<div class="row col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><h3 class="text-center">Форма редактирования</h3></div>
			</div>
			<div class="panel-body">
				<?php $form = ActiveForm::begin(
					[
						'options' => [
							'class' => 'col-sm-10 col-sm-offset-1',
							'style' => 'margin-top:10px; padding:20px;'
						]
					]
				); ?>

					<?= $form->field($one, 'surname')->textInput(['value' => $model->Surname]) ?>
					<?= $form->field($one, 'name')->textInput(['value' => $model->Name]) ?>
					<?= $form->field($one, 'patronymic')->textInput(['value' => $model->Patronymic]) ?>
					<?= $form->field($one, 'classchild')->textInput(['value' => $model->Field1]) ?>
					<?= $form->field($one, 'language')->textInput(['value' => $model->Field2]) ?>
					<?= $form->field($one, 'district')->textInput(['value' => $model->Field3]) ?>
					<?= $form->field($one, 'school')->textInput(['value' => $model->Field4]) ?>
					<?= $form->field($one, 'email')->textInput(['value' => $model->Email]) ?>
					<?= $form->field($one, 'password')->textInput(['value' => $model->Password]) ?>
				
					<div class="form-group">
						<?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'title' => 'Подтвердить изменения']) ?>
						<?= Html::a('Отмена', [''.$url], ['class' => 'btn btn-primary', 'title' => 'Отменить изменения']); ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div><!-- partaker-edit -->
</div>