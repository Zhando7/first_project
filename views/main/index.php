<?php
use yii\bootstrap\Modal;

if(Yii::$app->user->isGuest):
?>
<div class="container">
	<div class="row col-sm-12" style="margin-top:20px;">
		<div class="form-group" align="center">
			<a href="/main/indexpr" class="btn btn-primary btn-lg" style="width:300px;">Участники</a>
		</div>
		<div class="form-group" align="center" style="margin-top:20px;">
			<a href="/main/indexcom" class="btn btn-primary btn-lg" style="width:300px;">Команды</a>
		</div>
		<div class="form-group" align="center" style="margin-top:20px;">
			<a href="/main/indexexp" class="btn btn-primary btn-lg" style="width:300px;">Экспертный совет</a>
		</div>
		<div class="form-group" align="center" style="margin-top:20px;">
			<a href="#modal" data-toggle="modal" data-target="#result" class="btn btn-primary btn-lg" style="width:300px;">Результаты</a>
		</div>
	</div>
</div>
<?php
else:
	// ФОРМА ПРЕДСТАВЛЕНИЯ ОПЕРАТОРА
	if(Yii::$app->user->identity['AuthKey'] == 1): ?>
		<div class="container">
			<div class="row col-sm-3" style="margin-top:20px;">
				<div class="col-sm-3" align="center">
					<a id="text" href="/operator/indexexp" class="btn btn-primary btn-lg" style="width:300px;">Экспертный совет</a>
					<a href="/operator/indexpr" class="btn btn-primary btn-lg" style="margin-top:20px; width:300px">Участники</a>
					<a href="/operator/indexcom" class="btn btn-primary btn-lg" style="margin-top:20px; width:300px">Команды</a>
				</div>
			</div>
			<div class="row col-sm-3 col-sm-offset-1" style="margin-top:20px;">
				<div class="col-sm-3" align="center">
					<a href="/operator/indexcompetence" class="btn btn-success btn-lg" style="width:300px">Компетенции</a>
					<a href="/operator/indexpoints" class="btn btn-success btn-lg" style="margin-top:20px; width:300px">Формы оценивания</a>
					<a href="/operator/indexsecretkey" class="btn btn-success btn-lg" style="margin-top:20px; width:300px">Секретный ключ</a>
				</div>
			</div>
			<div class="row col-sm-3 col-sm-offset-1" style="margin-top:20px;">
				<div class="col-sm-3" align="center">
					<a href="#total" data-toggle="modal" data-target="#allresult" class="btn btn-info btn-lg" style="width:300px">Общие итоги</a>
					<a href="#evalution" data-toggle="modal" data-target="#crudevalution" class="btn btn-info btn-lg" style="margin-top:20px; width:300px">Управление оценивании</a>
					<a href="#results" data-toggle="modal" data-target="#result" class="btn btn-info btn-lg" style="margin-top:20px; width:300px">Результаты</a>
				</div>
			</div>
		</div>
	<?php
	endif;
	// ФОРМА ПРЕДСТАВЛЕНИЯ ЭКСПЕРТА
	if(Yii::$app->user->identity['AuthKey'] == 2): ?>
		<div class="container">
			<div class="row col-sm-12" style="margin-top:20px;">
				<div class="form-group" align="center">
					<a href="/expert/indexexp" class="btn btn-primary btn-lg" style="width:300px;">Экспертный совет</a>
				</div>
				<div class="form-group" align="center" style="margin-top:20px;">
					<a href="#" data-toggle="modal" data-target="#evaforexp" class="btn btn-primary btn-lg" style="width:300px;">Оценивание</a>
				</div>
				<div class="form-group" align="center" style="margin-top:20px;">
					<a href="#" data-toggle="modal" data-target="#result" class="btn btn-primary btn-lg" style="width:300px;">Результаты</a>
				</div>
			</div>
		</div>
	<?php
	endif;
	// ФОРМА ПРЕДСТАВЛЕНИЯ УЧАСТНИКА
	if(Yii::$app->user->identity['AuthKey'] == 3): ?>
		<div class="container">
			<div class="row col-sm-12" style="margin-top:20px;">
				<div class="form-group" align="center">
					<a href="/partaker/indexpr" class="btn btn-primary btn-lg" style="width:300px;">Участники</a>
				</div>
				<div class="form-group" align="center" style="margin-top:20px;">
					<a href="/partaker/indexworks" class="btn btn-primary btn-lg" style="width:300px;">Мои работы</a>
				</div>
				<div class="form-group" align="center" style="margin-top:20px;">
					<a href="/partaker/indexbid" class="btn btn-primary btn-lg" style="width:300px;">Заявки</a>
				</div>
				<div class="form-group" align="center" style="margin-top:20px;">
					<a href="#" data-toggle="modal" data-target="#result" class="btn btn-primary btn-lg" style="width:300px;">Результаты</a>
				</div>
			</div>
		</div>
	<?php
	endif;
	// ФОРМА ПРЕДСТАВЛЕНИЯ КОМАНДЫ
	if(Yii::$app->user->identity['AuthKey'] == 4): ?>
		<div class="container">
			<div class="row col-sm-12" style="margin-top:20px;">
				<div class="form-group" align="center">
					<a href="/commands/indexcom" class="btn btn-primary btn-lg" style="width:300px;">Состав команды</a>
				</div>
				<div class="form-group" align="center" style="margin-top:20px;">
					<a href="/commands/indexworks" class="btn btn-primary btn-lg" style="width:300px;">Загруженные работы</a>
				</div>
				<div class="form-group" align="center" style="margin-top:20px;">
					<a href="/commands/indexbid" class="btn btn-primary btn-lg" style="width:300px;">Заявки</a>
				</div>
				<div class="form-group" align="center" style="margin-top:20px;">
					<a href="#" data-toggle="modal" data-target="#result" class="btn btn-primary btn-lg" style="width:300px;">Результаты</a>
				</div>
			</div>
		</div>
	<?php
	endif;
endif;

Modal::begin(
	[
		'id' => 'result',
		'header' => '<h3 class="text-center">Выберите объект для просмотра результатов</h3>'
	]
);?>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="row" align="center">
			<div class="col-sm-4 col-sm-offset-2">
				<a href="/indexresultspr" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Участники</a>
			</div>
			<div class="col-sm-4">
				<a href="/indexresultscom" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Команды</a>
			</div>
		</div>
	</div>
</div>
<?php
Modal::end();

Modal::begin(
	[
		'id' => 'crudevalution',
		'header' => '<h3 class="text-center">Выберите объект для работы с оцениванием</h3>'
	]
);?>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="row" align="center">
			<div class="col-sm-4 col-sm-offset-2">
				<a href="/operator/indexcrudevapr" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Участник</a>
			</div>
			<div class="col-sm-4">
				<a href="/operator/indexcrudevacom" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Команда</a>
			</div>
		</div>
	</div>
</div>
<?php
Modal::end();

Modal::begin(
	[
		'id' => 'evaforexp',
		'header' => '<h3 class="text-center">Выберите объект оценивания</h3>'
	]
);?>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="row" align="center">
			<div class="col-sm-4 col-sm-offset-2">
				<a href="/expert/indexevapr" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Участник</a>
			</div>
			<div class="col-sm-4">
				<a href="/expert/indexevacom" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Команда</a>
			</div>
		</div>
	</div>
</div>
<?php
Modal::end();

Modal::begin(
	[
		'id' => 'allresult',
		'header' => '<h3 class="text-center">Выберите объект для просмотра результатов</h3>'
	]
);?>
<div class="row">
	<div class="col-sm-10 col-sm-offset-1">
		<div class="row" align="center">
			<div class="col-sm-4 col-sm-offset-2">
				<a href="/operator/allrespr" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Участники</a>
			</div>
			<div class="col-sm-4">
				<a href="/operator/allrescom" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Команды</a>
			</div>
		</div>
	</div>
</div>
<?php
Modal::end();