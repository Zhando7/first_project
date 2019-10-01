<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
* Используемые модули
*/
use app\models\Tables\Competence;
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
					
					<?= $form->field($one, 'IdCompetence')->dropdownList(Competence::find()->select(['Name', 'IdCompetence'])->indexBy('IdCompetence')->column(), ['prompt' => 'Выберите компетенцию']); ?>
					<?= $form->field($one, 'Name') ?>
					<?= $form->field($one, 'TodayDate')->textInput(['type' => 'date']) ?>
					<?= $form->field($one, 'Limit')->textInput(['placeholder' => 'При отсутствии ограничении оставляйте поле пустым']) ?>
					<?= $form->field($one, 'Show')->dropdownList(['0' => 'Да', '1' => 'Нет'])  ?>
					
					<div class="form-group">
						<?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'title' => 'Закончить редактирование']) ?>
						<?= Html::a('Отмена', [''.$url], ['class' => 'btn btn-primary', 'title' => 'Отменить редактирование']) ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div><!-- operator-createcompetence -->
</div>