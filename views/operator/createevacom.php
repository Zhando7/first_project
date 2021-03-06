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
					
					<?= $form->field($model, 'IdCompetence')->dropdownList(Competence::find()->select(['Name', 'IdCompetence'])->indexBy('IdCompetence')->column(), ['prompt' => 'Выберите компетенцию']); ?>
					<?= $form->field($model, 'Name') ?>
					<?= $form->field($model, 'TodayDate')->textInput(['type' => 'date']) ?>
					<?= $form->field($model, 'Limit')->textInput(['placeholder' => 'При отсутствии ограничении оставляйте поле пустым']) ?>
					<?= $form->field($model, 'Show')->dropdownList(['0' => 'Да', '1' => 'Нет'])  ?>
					
					<div class="form-group">
						<?= Html::submitButton('Подтвердить', ['class' => 'btn btn-success', 'title' => 'Закончить создание']) ?>
						<?= Html::a('Отмена', [''.$url], ['class' => 'btn btn-primary', 'title' => 'Отменить создание']) ?>
					</div>
				<?php ActiveForm::end(); ?>
			</div>
		</div>
	</div><!-- operator-createcompetence -->
</div>