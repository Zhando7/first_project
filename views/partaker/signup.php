<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Signup\SignupPr */
/* @var $form ActiveForm */
?>
<div class="container">
	<div class="row col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><h3 class="text-center">Форма регистрации</h3></div>
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

					<?= $form->field($model, 'surname') ?>
					<?= $form->field($model, 'name') ?>
					<?= $form->field($model, 'patronymic')->textInput(['placeholder' => 'Не обязательно']) ?>
					<?= $form->field($model, 'classpr') ?>
					<?= $form->field($model, 'language')->textInput(['placeholder' => 'Не обязательно']) ?>
					<?= $form->field($model, 'district') ?>
					<?= $form->field($model, 'school') ?>
					<?= $form->field($model, 'email') ?>
					<?= $form->field($model, 'password')->passwordInput(); ?>
				
					<div class="form-group">
						<?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'title' => 'Закончить регистрацию']) ?>
						<?= Html::a('Отмена', [''.$url], ['class' => 'btn btn-primary', 'title' => 'Отменить регистрацию']); ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div><!-- partaker-signup -->
</div>