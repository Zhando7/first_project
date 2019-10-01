<?php
namespace app\models\Edit;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class EditExp extends Model
{
	public 	$surname,
			$name,
			$patronymic,
			$region,
			$position,
			$password;
			
	public function rules(){
		return [
			[['surname', 'name', 'region', 'position', 'password'], 'required'],
			[['surname', 'name', 'patronymic', 'region', 'position', 'password'], 'trim'],
			[['surname', 'name', 'patronymic', 'region', 'position'], 'string'],
			[['password'], 'string', 'min' => 3],
			[['region', 'position'], 'string', 'min' => 1],
			[['password'], 'validatePassword'],
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
		];
	}
	public function validatePassword($attribute){
		if(!$this->hasErrors()):
			$user = Users::checkPasswordExp($this->surname, $this->name, $this->patronymic, $this->password);
			$pass = Users::checkPassword($this->password);
			
			if(Yii::$app->user->identity['AuthKey'] == 2):
				if($user and ($user->IdUser != Yii::$app->user->identity['IdUser'])):
					$this->addError($attribute, 'Введенные эксперт уже существует!');
				endif;
				if($pass and ($pass->IdUser != Yii::$app->user->identity['IdUser'])):
					$this->addError($attribute, 'Введенный контакт уже занят!');
				endif;
			else:
				if(Yii::$app->user->identity['AuthKey'] == 1):
					if($user and ($user->IdUser != Yii::$app->request->get('id'))):
						$this->addError($attribute, 'Введенные эксперт уже существует!');
					endif;
					if($pass and ($pass->IdUser != Yii::$app->request->get('id'))):
						$this->addError($attribute, 'Введенный контакт уже занят!');
					endif;
				endif;
			endif;
		endif;
	}
	public function save(){
		if(Yii::$app->user->identity['AuthKey'] == 2):
			$model = Users::getExp(Yii::$app->user->identity['IdUser']);
		else:
			if(Yii::$app->user->identity['AuthKey'] == 1):
				$model = Users::getExp(Yii::$app->request->get('id'));
			endif;
		endif;
		
		$model->Password = $this->password;
		$model->Surname = $this->surname;
		$model->Name = $this->name;
		$model->Patronymic = $this->patronymic;
		$model->Field1 = $this->region;
		$model->Field2 = $this->position;
		
		return $model->save()? $model : null;
	}
}