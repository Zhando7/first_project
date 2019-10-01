<?php
namespace app\models\Create;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class CreateExpert extends Model
{
	public 	$authkey,
			$surname,
			$name,
			$patronymic,
			$region,
			$position,
			$password;
	
	public function rules(){
		return [
			[['surname', 'name', 'region', 'password'], 'required'],
			[['surname', 'name', 'patronymic', 'region', 'position', 'password'], 'trim'],
			[['surname', 'name', 'patronymic', 'region', 'position'], 'string'],
			[['password'], 'string', 'min' => 3],
			[['password'], 'validatePassword'],
			[['authkey'], 'default', 'value' => 2],
		];
	}
	public function attributeLabels(){
		return [
			'surname' => 'Фамилия:',
			'name' => 'Имя:',
			'patronymic' => 'Отчество:',
			'region' => 'Район\город:',
			'position' => 'Должность (организация):',
			'password' => 'Контакты:'
		];
	}
	public function validatePassword($attribute){
		if(!$this->hasErrors()):
			if(Users::checkPasswordExp($this->surname, $this->name, $this->patronymic, $this->password)):
				$this->addError($attribute, 'Невозможно создать данного эксперта, так как в базе данных имеются похожие данные.');
			endif;
			if(Users::checkPassword($this->password)):
				$this->addError($attribute, 'Введенный контакт уже занят!');
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
		$model->Field1 = $this->region;
		$model->Field2 = $this->position;
		
		return $model->save()? $model : null;
	}
}