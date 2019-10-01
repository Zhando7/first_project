<?php
namespace app\models\Login;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class LoginCom extends Model
{
	public $name;
	public $password;
	public $reCaptcha;
	
	public function rules(){
		return [
			[['name', 'password'], 'trim'],
			[['name', 'password'], 'required'],
			[['name'], 'string'],
			[['password'], 'string', 'min' => 3, 'max' => 255],
			[['password'], 'validatePassword']
		];
	}
	public function attributeLabels(){
		return [
			'name' => 'Название команды:',
			'password' => 'Пароль:'
		];
	}
	public function validatePassword($attribute){
		if(!$this->hasErrors()):
			$dataUser = $this->getCommand();
			
			if(!$dataUser):
				$this->addError($attribute, 'Неправильно введен название команды или пароль!');
			endif;
		endif;
	}
	public function getCommand(){
		return Users::checkCommand($this->name, $this->password);
	}
	public function login(){
		if($this->validate()):
			$user = $this->getCommand();
			return Yii::$app->user->login($user);
		else:
			return false;
		endif;
	}
}