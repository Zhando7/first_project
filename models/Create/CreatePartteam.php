<?php
namespace app\models\Create;

use Yii;
use yii\base\Model;

use app\models\Tables\Partteam;
use app\models\Tables\Users;

class CreatePartteam extends Model
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
			'school' => 'Наименование школы:'
		];
	}
	public function validatePartteam($attribute){
		if(!$this->hasErrors()):
			if(Yii::$app->user->identity['AuthKey'] == 4):
				$user = Partteam::getPartaker($this->surname, $this->name, $this->patronymic, $this->school);
				
				if($user and ($user->IdUser == Yii::$app->user->identity['IdUser'])):
					$this->addError($attribute, 'Введенный участник уже состоит в вашей команде!');
				endif;
			else:
				if(Yii::$app->user->identity['AuthKey'] == 1):
					$user = Partteam::getPrForOp($this->surname, $this->name, $this->patronymic, $this->school);
					
					if($user and ($user->IdUser == Yii::$app->request->get('id'))):
						$this->addError($attribute, 'Введенный участник уже состоит этой команде!');
					endif;
				endif;
			endif;
		endif;
	}
	public function save(){
		$model = new Partteam();
		
		if(Yii::$app->user->identity['AuthKey'] == 4):
			$model->IdUser = Yii::$app->user->identity['IdUser'];
			$model->NameCommand = Yii::$app->user->identity['Name'];
		else:
			if(Yii::$app->user->identity['AuthKey'] == 1):
				$com = Users::getCom(Yii::$app->request->get('id'));
				$model->IdUser = $com->IdUser;
				$model->NameCommand = $com->Name;
			endif;
		endif;
		
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