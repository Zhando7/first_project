<?php
namespace app\models\Create;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class CreatePr extends Model
{
	public	$authkey,
			$surname,
			$name,
			$patronymic,
			$classchild,
			$language,
			$district,
			$school,
			$email,
			$password;
			
	public function rules(){
		return [
			[['authkey'], 'default', 'value' => 3],
			[['authkey', 'surname', 'name', 'classchild', 'district', 'school', 'email', 'password'], 'required'],
			[['surname', 'name', 'patronymic', 'classchild', 'language', 'district', 'school', 'email', 'password'], 'trim'],
			[['surname', 'name', 'patronymic', 'classchild', 'language', 'district', 'school'], 'string'],
			[['email'], 'email'],
			[['password'], 'string', 'min' => 3, 'max' => 255],
			[['surname'], 'validateName'],
			[['email'], 'validateEmail']
		];
	}
	public function attributeLabels(){
		return [
			'surname' => 'Фамилия:',
			'name' => 'Имя:',
			'patronymic' => 'Отчество:',
			'classchild' => 'Класс:',
			'language' => 'Язык обучения:',
			'district' => 'Район\город:',
			'school' => 'Школа:',
			'email' => 'Почта:',
			'password' => 'Пароль:'
		];
	}
	public function validateName($attribute){
		if(!$this->hasErrors()):
			if(Users::checkExistPartaker($this->surname, $this->name, $this->patronymic, $this->school)):
				$this->addError($attribute, 'Невозможно создать данного участника, так как в базе данных имеются похожие данные.');
			endif;
		endif;
	}
	public function validateEmail($attribute){
		if(!$this->hasErrors()):
			if(Users::checkEmailPr($this->email)):
				$this->addError($attribute, 'Данная почта уже занята другим участником!');
			endif;
		endif;
	}
	public function save(){
		$model = new Users();
		$model->AuthKey = $this->authkey;
		$model->Password = $this->password;
		$model->Surname = $this->surname;
		$model->Name = $this->name;
		$model->Patronymic = $this->patronymic;
		$model->Field1 = $this->classchild;
		$model->Field2 = $this->language;
		$model->Field3 = $this->district;
		$model->Field4 = $this->school;
		$model->Email = $this->email;
		
		return $model->save()? $model : null;
	}
}