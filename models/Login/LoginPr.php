<?php
namespace app\models\Login;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class LoginPr extends Model
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
			'password' => 'Пароль:'
		];
	}
	public function validatePassword($attribute){
		if(!$this->hasErrors()):
			$dataUser = $this->getPartaker();
			
			if(!$dataUser):
				$this->addError($attribute, 'Неправильно введен ФИО или пароль!');
			endif;
		endif;
	}
	public function getPartaker(){
		return Users::checkDataPartaker($this->surname, $this->name, $this->password);
	}
	public function login(){
		if($this->validate()):
			$user = $this->getPartaker();
			return Yii::$app->user->login($user);
		else:
			return false;
		endif;
	}
}