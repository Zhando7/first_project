<?php
use yii\helpers\Html;

echo 'Привет ' . Html::encode($user->Name) . '.<p></p>';
echo Html::a('Для смены пароля перейдите по этой ссылке.', Yii::$app->urlManager->createAbsoluteUrl(['/main/resetpasswordcom', 'key' => $user->SecretKey]));