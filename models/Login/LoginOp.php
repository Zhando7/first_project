<?php
namespace app\models\Login;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class LoginOp extends Model
{
	public $name;
	public $password;
	public $reCaptcha;
	
	public function rules(){
		return [
			[['name', 'password'], 'trim'],
			[['name', 'password'], 'required'],
			[['name'], 'string', 'min' => 3, 'max' => 255],
			[['password'], 'validatePassword'],
		];
	}
	public function attributeLabels(){
		return [
			'name' => 'Имя оператора:',
			'password' => 'Пароль:'
		];
	}
	public function validatePassword($attribute){
		if(!$this->hasErrors()):
			$dataUser = $this->getUser();
			
			if(!$dataUser):
				$this->addError($attribute, 'Введенный оператор не состоит в базе данных!');
			else:
				$password = $this->getPassword();
				if(!$password):
					$this->addError($attribute, 'Неправильно введен пароль!');
				endif;
			endif;
		endif;
	}
	public function getUser(){
		return Users::findOperator($this->name);
	}
	public function getPassword(){
		return Users::checkPasswordOp($this->name, $this->password);
	}
	public function login(){
		if($this->validate()):
			$user = $this->getUser();
			return Yii::$app->user->login($user);
		else:
			return false;
		endif;
	}
}