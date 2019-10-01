<?php
namespace app\models\Login;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class LoginExp extends Model
{
	public $surname;
	public $name;
	public $password;
	
	public function rules(){
		return [
			[['surname', 'name', 'password'], 'trim'],
			[['surname', 'name', 'password'], 'required'],
			[['surname', 'name'], 'string'],
			[['password'], 'string', 'min' => 3, 'max' => 255],
			[['password'], 'validatePassword']
		];
	}
	public function attributeLabels(){
		return [
			'surname' => 'Фамилия:',
			'name' => 'Имя:',
			'password' => 'Контакты:'
		];
	}
	public function validatePassword($attribute){
		if(!$this->hasErrors()):
			$dataUser = $this->getUser();
			
			if(!$dataUser):
				$this->addError($attribute, 'Неправильно введен ФИО!');
			else:
				$password = $this->getPassword();
				if(!$password):
					$this->addError($attribute, 'Неправильно введен пароль!');
				endif;
			endif;
		endif;
	}
	public function getUser(){
		return Users::findExpert($this->surname, $this->name);
	}
	public function getPassword(){
		return Users::checkPasswordExp($this->surname, $this->name, $this->password);
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