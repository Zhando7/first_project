<?php
namespace app\models\Edit;

use Yii;
use yii\base\Model;

use app\models\Tables\Partteam;

class EditPartteam extends Model
{
	public $surname;
	public $name;
	public $patronymic;
	public $language;
	public $classchild;
	public $district;
	public $school;
	
	public function rules(){
		return [
			[['surname', 'name', 'classchild', 'district', 'school'], 'required'],
			[['surname', 'name', 'patronymic', 'language', 'classchild', 'district', 'school'], 'trim'],
			[['surname', 'name', 'patronymic', 'language', 'classchild', 'district', 'school'], 'string'],
			[['surname'], 'validatePartteam']
		];
	}
	public function attributeLabels(){
		return [
			'surname' => 'Фамилия:',
			'name' => 'Имя:',
			'patronymic' => 'Отчество:',
			'language' => 'Язык обучения:',
			'classchild' => 'Класс:',
			'district' => 'Район\город:',
			'school' => 'Школа:'
		];
	}
	public function validatePartteam($attribute){
		if(!$this->hasErrors()):
			$info = Partteam::getChild(Yii::$app->request->get('id'));
			
			if(Yii::$app->user->identity['AuthKey'] == 4):
				$user = Partteam::getPartaker($this->surname, $this->name, $this->patronymic, $this->school);
			else:
				if(Yii::$app->user->identity['AuthKey'] == 1):
					$user = Partteam::getForEdit($info->IdUser, $this->surname, $this->name, $this->patronymic, $this->school);
				endif;
			endif;
			
			if($user and ($user->IdChild != $info->IdChild)):
				$this->addError($attribute, 'Введенный участник уже состоит этой команде!');
			endif;
		endif;
	}
	public function save(){
		$model = Partteam::getChild(Yii::$app->request->get('id'));
		
		$model->Surname = $this->surname;
		$model->Name = $this->name;
		$model->Patronymic = $this->patronymic;
		$model->LanguageLearning = $this->language;
		$model->ClassChild = $this->classchild;
		$model->District = $this->district;
		$model->School = $this->school;
		
		return $model->save()? $model : null;
	}
}