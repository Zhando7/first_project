<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\NavBar;
use yii\bootstrap\Nav;
use yii\bootstrap\Modal;
use app\components\AlertWidget;

AppAsset::register($this);

/* var $content string */

$this->beginPage();
?>
<!DOCTYPE html>
<html>
<html lang="<?= Yii::$app->language; ?>">
	<head>
		<?= Html::csrfMetaTags() ?>
		<meta charset="<?= Yii::$app->charset; ?>">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="author" content="Akhmetkarimov Zhandos">
		<?= $this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1']); ?>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js"></script>
		<title><?= Yii::$app->name ?></title>
		<?php $this->head(); ?>
	</head>
	<body>
	<?php $this->beginBody(); ?>
		<div class="wrap">
			<?php NavBar::begin(
				[
					'brandLabel' => 'Система оценивания',
					//'brandUrl' => Yii::$app->homeUrl,
					'options' => [
						'class' => 'navbar navbar-default',
					]
				]
			);?>
			<?php 
			if(Yii::$app->user->isGuest):
				$menuItems[] = [
					'label' => '<span class="glyphicon glyphicon-log-in"></span> Вход',
					'url' => ['#login'],
					'linkOptions' => [
						'data-toggle' => 'modal',
						'data-target' => '#login',
						'style' => 'cursor:pointer;',
						'title' => 'Перейти на страницу авторизации'
					]
				];
				$menuItems[] = [
					'label' => '<i class="fa fa-user-plus"></i> Регистрация',
					'url' => ['#singup'],
					'linkOptions' => [
						'data-toggle' => 'modal',
						'data-target' => '#signup',
						'style' => 'cursor:pointer;',
						'title' => 'Перейти на страницу регистрации'
					]
				];
				$menuItems[] = [
					'label' => 'Справка',
					'url' => ['/main/help']
				];
			else:
				if(Yii::$app->user->identity['AuthKey'] == 1):
					$menuItems[] = [
						'label' => '<i class="fa fa-user-circle"></i> ' . Yii::$app->user->identity['Name'],
						'linkOptions' => [
							'title' => 'Оператор'
						],
						'items' => [
							[
								'label' => 'Изменить личные данные',
								'url' => ['/operator/editpersonaldata'],
								'options' => [
									'class' => 'text-center'
								],
							],
							[
								'label' => 'Справка',
								'url' => ['/main/help'],
								'options' => [
									'class' => 'text-center'
								],
							],
							[
								'label' => 'Выход',
								'url' => ['/main/logout'],
								'options' => [
									'class' => 'text-center'
								],
							],
						]
					];
				endif;
				if(Yii::$app->user->identity['AuthKey'] == 2):
					$menuItems[] = [
						'label' => '<i class="fa fa-user-circle"></i> ' . Yii::$app->user->identity['Surname'] . ' ' .  Yii::$app->user->identity['Name'] . ' ' .  Yii::$app->user->identity['Patronymic'],
						'linkOptions' => [
							'title' => 'Эксперт'
						],
						'items' => [
							[
								'label' => 'Изменить личные данные',
								'url' => '/expert/editexp',
								'options' => [
									'class' => 'text-center'
								]
							],
							[
								'label' => 'Справка',
								'url' => ['/main/help'],
								'options' => [
									'class' => 'text-center'
								],
							],
							[
								'label' => 'Выход',
								'url' => ['/main/logout'],
								'options' => [
									'class' => 'text-center',
								],
							],
						]
					];
				endif;
				if(Yii::$app->user->identity['AuthKey'] == 3):
					$menuItems[] = [
						'label' => '<i class="fa fa-user-circle"></i> ' . Yii::$app->user->identity['Surname'] . ' ' .  Yii::$app->user->identity['Name'] . ' ' .  Yii::$app->user->identity['Patronymic'],
						'linkOptions' => [
							'title' => 'Участник'
						],
						'items' => [
							[
								'label' => 'Изменить личные данные',
								'url' => ['/partaker/editpr'],
								'options' => [
									'class' => 'text-center'
								]
							],
							[
								'label' => 'Мои работы',
								'url' => ['/partaker/indexworks'],
								'options' => [
									'class' => 'text-center'
								]
							],
							[
								'label' => 'Мои заявки',
								'url' => ['/partaker/indexmybid'],
								'options' => [
									'class' => 'text-center'
								]
							],
							[
								'label' => 'Справка',
								'url' => ['/main/help'],
								'options' => [
									'class' => 'text-center'
								],
							],
							[
								'label' => 'Выход',
								'url' => ['/main/logout'],
								'options' => [
									'class' => 'text-center',
								],
							],
						]
					];
				endif;
				if(Yii::$app->user->identity['AuthKey'] == 4):
					$menuItems[] = [
						'label' => '<span class="fa-stack"><i class="fa fa-circle-thin fa-stack-2x"></i><i class="fa fa-users fa-stack-1x"></i></span> ' . Yii::$app->user->identity['Name'],
						'linkOptions' => [
							'title' => 'Команда'
						],
						'items' => [
							[
								'label' => 'Изменить данные команды',
								'url' => ['/commands/editcom'],
								'options' => [
									'class' => 'text-center'
								]
							],
							[
								'label' => 'Состав команды',
								'url' => ['/commands/indexcom'],
								'options' => [
									'class' => 'text-center'
								]
							],
							[
								'label' => 'Загруженные работы',
								'url' => ['/commands/indexworks'],
								'options' => [
									'class' => 'text-center'
								]
							],
							[
								'label' => 'Заявки команды',
								'url' => ['/commands/indexmybid'],
								'options' => [
									'class' => 'text-center'
								]
							],
							[
								'label' => 'Справка',
								'url' => ['/main/help'],
								'options' => [
									'class' => 'text-center'
								],
							],
							[
								'label' => 'Выход',
								'url' => ['/main/logout'],
								'options' => [
									'class' => 'text-center',
								],
							],
						]
					];
				endif;
			endif;
			
			Modal::begin([
				'header' => '<h3 align="center">Выберите объект авторизации</h3>',
				'id' => 'login',
				'size' => 'modal-md'
			]);
			echo '
				<div class="row">
					<div class="col-sm-12" align="center">
						<div class="row">
							<div class="col-sm-5 col-sm-offset-1">
								<a href="/partaker/login" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Участник</a>
							</div>
							<div class="col-sm-5">
								<a href="/expert/login" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Эксперт</a>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" align="center">
						<div class="row">
							<div class="col-sm-5 col-sm-offset-1">
								<a href="/commands/login" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Команда</a>
							</div>
							<div class="col-sm-5">
								<a href="/operator/login" class="btn btn-default btn-lg" style="margin-top:10px; width:120px;">Оператор</a>
							</div>
						</div>
					</div>
				</div>
			';
			Modal::end(); 
			
			Modal::begin([
				'header' => '<h3 align="center">Выберите объект регистрации</h3>',
				'id' => 'signup',
				'size' => 'modal-md'
			]);
			echo '
				<div class="row">
					<div class="col-sm-12" align="center">
						<div class="row">
							<div class="col-sm-4">
								<a href="/partaker/signup" class="btn btn-default btn-lg" style="margin-top:10px; width:115px;">Участник</a>
							</div>
							<div class="col-sm-4">
								<a href="/commands/signup" class="btn btn-default btn-lg" style="margin-top:10px; width:115px;">Команда</a>
							</div>
							<div class="col-sm-4">
								<a href="/expert/signup" class="btn btn-default btn-lg" style="margin-top:10px; width:115px;">Эксперт</a>
							</div>
						</div>
					</div>
				</div>
			';
			Modal::end(); ?>
			
			<?= Nav::widget(
				[
					'options' => [
						'class' => 'navbar-nav navbar-right',
					],
					'encodeLabels' => false,
					'items' => $menuItems,
				]
			); ?>
			<?php NavBar::end(); ?>
			<div class="container">
				<div class="row col-sm-12">
					<?= AlertWidget::widget(); ?>
				</div>
				<div class="row col-sm-12">
					<?= $content; ?>
				</div>
			</div>
		</div>
	<?php $this->endBody(); ?>
	</body>
</html>
<?php
$this->endPage();
?>
