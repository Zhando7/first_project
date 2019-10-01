<?php
namespace app\models\Signup;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class SignupCom extends Model
{
	public $authkey;
	public $name;
	public $email;
	public $password;
	
	public function rules(){
		return [
			[['name', 'email', 'password'], 'trim'],
			[['authkey'], 'default', 'value' => 4],
			[['name', 'email', 'password'], 'required'],
			[['name'], 'string', 'min' => 3],
			[['password'], 'string', 'min' => 3, 'max' => 255],
			[['email'], 'email'],
			[['email'], 'unique', 'targetClass' => Users::className(), 'message' => 'Эта почта уже занята! Введите другой...'],
			[['name'], 'validateName']
		];
	}
	public function attributeLabels(){
		return [
			'name' => 'Название команды:',
			'email' => 'Почта:',
			'password' => 'Пароль:'
		];
	}
	public function validateName($attribute){
		if(!$this->hasErrors()):
			$command = $this->getNamesCom();
			
			if($command):
				$this->addError($attribute, 'Введенное название команды уже занято!');
			endif;
		endif;
	}
	public function getNamesCom(){
		return Users::checkName($this->name);
	}
	public function signup(){
		$model = new Users();
		
		$model->AuthKey = $this->authkey;
		$model->Name = $this->name;
		$model->Email = $this->email;
		$model->Password = $this->password;
		
		return $model->save()? $model : null;
	}
}