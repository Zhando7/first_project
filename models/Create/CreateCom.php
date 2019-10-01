<?php
namespace app\models\Create;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class CreateCom extends Model
{
	public 	$authkey,
			$name,
			$email,
			$password;
			
	public function rules(){
		return [
			[['authkey'], 'default', 'value' => 4],
			[['authkey', 'name', 'email', 'password'], 'required'],
			[['name', 'email', 'password'], 'trim'],
			[['name'], 'string'],
			[['password'], 'string', 'min' => 3, 'max' => 255],
			[['email'], 'email'],
			[['name'], 'validateName'],
			[['email'], 'validateEmail'],
		];
	}
	public function attributeLabels(){
		return [
			'name' => 'Название команды:',
			'email' => 'Почта:',
			'password' => 'Пароль:',
		];
	}
	public function validateName($attribute){
		if(!$this->hasErrors()):
			if(Users::checkName($this->name)):
				$this->addError($attribute, 'Команда с таким названием уже существует! Введите другой.');
			endif;
		endif;
	}
	public function validateEmail($attribute){
		if(!$this->hasErrors()):
			if(Users::checkEmailCom($this->email)):
				$this->addError($attribute, 'Введенная почта занята другой командой. Введите другой.');
			endif;
		endif;
	}
	public function save(){
		$model = new Users();
		$model->AuthKey = $this->authkey;
		$model->Name = $this->name;
		$model->Email = $this->email;
		$model->Password = $this->password;
		
		return $model->save()? $model : null;
	}
}