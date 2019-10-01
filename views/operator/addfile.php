<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="container">
	<div class="row col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><h3 class="text-center">Форма загрузки файлов</h3></div>
			</div>
			<div class="panel-body">
				<?php $form = ActiveForm::begin(
					[
						
						'options' => [
							'enctype' => 'multipart/form-data',
							'class' => 'col-sm-10 col-sm-offset-1',
							'style' => 'margin-top:10px; padding:20px;'
						]
					]
				); ?>
					
					<?= $form->field($model, 'files[]')->fileInput(['multiple' => true])->label(false); ?>
					
				<div class="form-group" style="margin-top:40px;">
					<?= Html::submitButton('Подтвердить загрузку', ['class' => 'btn btn-success', 'title' => 'Загрузить выбранные файлы']); ?>
					<?= Html::a('Отмена', [''.$url], ['class' => 'btn btn-primary', 'title' => 'Отменить загрузку файлов']); ?>
				</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div>
</div>