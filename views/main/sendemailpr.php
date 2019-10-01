<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Email\SendEmailPr */
/* @var $form ActiveForm */
?>
<div class="container">
	<div class="row col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><h3 class="text-center">Форма ввода</h3></div>
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

					<?= $form->field($model, 'email')->textInput(['placeholder' => 'Введите свою почту']); ?>
				
					<div class="form-group">
						<?= Html::submitButton('Отправить', ['class' => 'btn btn-success']); ?>
						<?= Html::button('Отмена', ['onClick' => 'history.back();','class' => 'btn btn-primary']); ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div><!-- main-sendemailpr -->
</div>