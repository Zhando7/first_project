<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Login\LoginExp */
/* @var $form ActiveForm */
?>
<div class="container">
	<div class="row col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><h3 class="text-center">Форма авторизации</h3></div>
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
					<?= $form->field($model, 'password') ?>
									
					<div class="form-group">
						<?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'title' => 'Начать авторизацию']) ?>
						<?= Html::a('Отмена', [''.$url], ['class' => 'btn btn-primary', 'title' => 'Отменить авторизацию']) ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div><!-- expert-login -->
</div>