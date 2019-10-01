<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $one app\models\Edit\EditCom */
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
				
					<?= $form->field($one, 'name')->textInput(['value' => $model->Name]) ?>
					<?= $form->field($one, 'email')->textInput(['value' => $model->Email]) ?>
					<?= $form->field($one, 'password')->textInput(['value' => $model->Password]) ?>
				
					<div class="form-group">
						<?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'title' => 'Закончить редактирование']) ?>
						<?= Html::a('Отмена', [''.$url], ['class' => 'btn btn-primary', 'title' => 'Отменить редактирование']); ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div><!-- operator-editcom -->
</div>