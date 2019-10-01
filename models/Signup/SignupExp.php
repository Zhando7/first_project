<?php
namespace app\models\Signup;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;
use app\models\Tables\Secretkey;

class SignupExp extends Model
{
	public $authkey;
	public $surname;
	public $name;
	public $patronymic;
	public $region;
	public $position;
	public $password;
	public $inputkey;
	
	public function rules(){
		return [
			[['surname', 'name', 'patronymic', 'password', 'region', 'position'], 'trim'],
			[['authkey'], 'default', 'value' => 2],
			[['surname', 'name', 'password', 'region', 'position', 'inputkey'], 'required'],
			[['surname', 'name', 'patronymic', 'region', 'position', 'inputkey'], 'string'],
			[['password'], 'string', 'min' => 3, 'max' => 255 ],
			[['password'], 'validatePassword'],
			[['inputkey'], 'validateSecretkey']
		];
	}
	public function attributeLabels(){
		return [
			'surname' => 'Фамилия:',
			'name' => 'Имя:',
			'patronymic' => 'Отчество:',
			'region' => 'Район\город:',
			'position' => 'Должность (организация):',
			'password' => 'Контакты:',
			'inputkey' => 'Секретный ключ:'
		];
	}
	public function validatePassword($attribute){
		if(!$this->hasErrors()):
			$dataUser = $this->getExpert();
			
			if($dataUser):
				$this->addError($attribute, 'Введенный контакт уже занят!');
			endif;
		endif;
	}
	public function validateSecretkey($attribute){
		if(!$this->hasErrors()):
			if(!Secretkey::checkSecretKey($this->inputkey)):
				$this->addError($attribute, 'Неправильно введен секретный ключ!');
			endif;
		endif;
	}
	public function getExpert(){
		return Users::checkPassword($this->password);
	}
	public function signup(){
		$model = new Users();
		
		$model->AuthKey = $this->authkey;
		$model->Password = $this->password;
		$model->Surname = $this->surname;
		$model->Name = $this->name;
		$model->Patronymic = $this->patronymic;
		$model->Field1 = $this->region;
		$model->Field2 = $this->position;
		
		return $model->save()? $model : null;
	}
}