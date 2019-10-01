<?php
namespace app\models\Email;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class SendEmailPr extends Model
{
	public $email;
	
	public function rules(){
		return [
			[['email'], 'trim'],
			[['email'], 'required'],
			[['email'], 'email'],
			[['email'], 'exist', 'targetClass' => Users::className(), 'filter' => ['AuthKey' => 3], 'message' => 'Введенная почта не состоит в базе данных!']
		];
	}
	public function attributeLabels(){
		return [
			'email' => 'Почта:'
		];
	}
	public function sendEmail(){
		$user = Users::findOne(
			[
				'AuthKey' => 3,
				'Email' => $this->email
			]
		);
		
		if($user):
			$user->generateSecretKey();
			if($user->save()):
				return Yii::$app->mailer->compose('resetPasswordCom', ['user' => $user])
					->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' (отправленно роботом)'])
					->setTo($this->email)
					->setSubject('Сброс пароля для ' . Yii::$app->name)
					->send();
			endif;
		endif;
		
		return false;
	}
}