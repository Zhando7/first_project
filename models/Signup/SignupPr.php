<?php
namespace app\models\Signup;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class SignupPr extends Model
{
	public $authkey;
	public $password;
	public $surname;
	public $name;
	public $patronymic;
	public $classpr;
	public $language;
	public $district;
	public $school;
	public $email;
	
	public function rules(){
		return [
			[['surname', 'name', 'patronymic', 'classpr', 'language', 'district', 'school', 'password', 'email'], 'trim'],
			[['authkey'], 'default', 'value' => 3],
			[['surname', 'name', 'classpr', 'district', 'school', 'password', 'email'], 'required'],
			[['surname', 'name', 'patronymic', 'classpr', 'language', 'district', 'school'], 'string'],
			[['password'], 'string', 'min' => 3, 'max' => 255],
			[['email'], 'email'],
			[['email'], 'unique', 'targetClass' => Users::className(), 'message' => 'Эта почта уже занята! Введите другой...'],
			[['surname'], 'validateUser']
		];
	}
	public function attributeLabels(){
		return [
			'surname' => 'Фамилия:',
			'name' => 'Имя:',
			'patronymic' => 'Отчество:',
			'classpr' => 'Класс:',
			'language' => 'Язык обучения:',
			'district' => 'Район\город:',
			'school' => 'Наименование школы:',
			'email' => 'Почта:',
			'password' => 'Пароль:'
		];
	}
	public function validateUser($attribute){
		if(!$this->hasErrors()):
			$dataUser = $this->getPartaker();
			
			if($dataUser):
				$this->addError($attribute, 'Введенный участник уже состоит в базе данных!');
			endif;
		endif;
	}
	public function getPartaker(){
		return Users::checkExistPartaker($this->surname, $this->name, $this->patronymic, $this->school);
	}
	public function signup(){
		$model = new Users();
		
		$model->AuthKey = $this->authkey;
		$model->Password = $this->password;
		$model->Surname = $this->surname;
		$model->Name = $this->name;
		$model->Patronymic = $this->patronymic;
		$model->Field1 = $this->classpr;
		$model->Field2 = $this->language;
		$model->Field3 = $this->district;
		$model->Field4 = $this->school;
		$model->Email = $this->email;
		
		return $model->save()? $model : null;
	}
}