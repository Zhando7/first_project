<?php
namespace app\models\Edit;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;
use app\models\Tables\Resultspr;

class EditPr extends Model
{
	public 	$surname,
			$name,
			$patronymic,
			$district,
			$school,
			$classchild,
			$language,
			$email,
			$password;
			
	public function rules(){
		return [
			[['surname', 'name', 'classchild', 'district', 'school', 'email', 'password'], 'required'],
			[['surname', 'name', 'patronymic', 'language', 'classchild', 'district', 'school', 'email', 'password'], 'trim'],
			[['surname', 'name', 'patronymic', 'language', 'classchild', 'district', 'school'], 'string'],
			[['email'], 'email'],
			[['password'], 'string', 'min' => 3, 'max' =>255],
			[['surname'], 'validateName'],
			[['email'], 'validateEmail'],
		];
	}
	public function attributeLabels(){
		return [
			'surname' => 'Фамилия:',
			'name' => 'Имя:',
			'patronymic' => 'Отчество:',
			'district' => 'Район\город:',
			'school' => 'Школа:',
			'classchild' => 'Класс:',
			'language' => 'Язык обучения:',
			'email' => 'Почта:',
			'password' => 'Пароль:'
		];
	}
	public function validateName($attribute){
		if(!$this->hasErrors()):
			$user = Users::checkExistPartaker($this->surname, $this->name, $this->patronymic, $this->school);
			
			if(Yii::$app->user->identity['AuthKey'] == 3):
				if($user and ($user->IdUser != Yii::$app->user->identity['IdUser'])):
					$this->addError($attribute, 'Введенное ФИО уже занято!');
				endif;
			else:
				if(Yii::$app->user->identity['AuthKey'] == 1):
					if($user and ($user->IdUser != Yii::$app->request->get('id'))):
						$this->addError($attribute, 'Введенное ФИО уже занято!');
					endif;
				endif;
			endif;
		endif;
	}
	public function validateEmail($attribute){
		if(!$this->hasErrors()):
			$user = Users::checkEmailPr($this->email);
			
			if(Yii::$app->user->identity['AuthKey'] == 3):
				if($user and ($user->IdUser != Yii::$app->user->identity['IdUser'])):
					$this->addError($attribute, 'Введенная почта уже занята!');
				endif;
			else:
				if(Yii::$app->user->identity['AuthKey'] == 1):
					if($user and ($user->IdUser != Yii::$app->request->get('id'))):
						$this->addError($attribute, 'Введенная почта уже занята!');
					endif;
				endif;
			endif;
		endif;
	}
	public function save(){
		$fiopr = $this->surname.' '.$this->name.' '.$this->patronymic;
		
		if(Yii::$app->user->identity['AuthKey'] == 3):
			$model = Users::getPr(Yii::$app->user->identity['IdUser']);
			Resultspr::updateAll(['Fio' => $fiopr], ['like', 'IdPartaker', Yii::$app->user->identity['IdUser']]);
		else:
			if(Yii::$app->user->identity['AuthKey'] == 1):
				$model = Users::getPr(Yii::$app->request->get('id'));
				Resultspr::updateAll(['Fio' => $fiopr], ['like', 'IdPartaker', Yii::$app->request->get('id')]);
			endif;
		endif;
		
		$model->Surname = $this->surname;
		$model->Name = $this->name;
		$model->Patronymic = $this->patronymic;
		$model->Field3 = $this->district;
		$model->Field4 = $this->school;
		$model->Field1 = $this->classchild;
		$model->Field2 = $this->language;
		$model->Email = $this->email;
		$model->Password = $this->password;
		
		return $model->save()? $model : null;
	}
}