<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Create\CreateCriterion */
/* @var $form ActiveForm */

/**
* Используемые модули
*/
use app\models\Tables\Formpoints;
?>
<div class="container">
	<div class="row col-sm-8 col-sm-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="panel-title"><h3 class="text-center">Форма создания</h3></div>
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
					
					<?= $form->field($model, 'Name') ?>
					<?= $form->field($model, 'Description')->textArea(["rows" => 6]) ?>
					<?= $form->field($model, 'IdPoint')->dropdownList(Formpoints::find()->select(['Name', 'IdPoint'])->indexBy('IdPoint')->column(), ['prompt' => 'Выберите форму оценивания']) ?>
				
					<div class="form-group">
						<?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'title' => 'Закончить создание']) ?>
						<?= Html::a('Отмена', [''.$url], ['class' => 'btn btn-primary', 'title' => 'Отменить создание']) ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div><!-- operator-createcompetence -->
</div>
