<?php
namespace app\models\Edit;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;

class PersonalData extends Model
{
	public $name;
	public $password;
	
	public function rules(){
		return [
			[['name', 'password'], 'required'],
			[['name', 'password'], 'trim'],
			[['name'], 'string', 'min' => 3],
			[['password'], 'string', 'min' => 3, 'max' => 255],
			[['name'], 'validateName']
		];
	}
	public function attributeLabels(){
		return [
			'name' => 'Имя оператора:',
			'password' => 'Пароль:'
		];
	}
	public function validateName($attribute){
		if(!$this->hasErrors()):
			$user = $this->getUser();
			if($user and ($user->IdUser != Yii::$app->user->identity['IdUser'])):
				$this->addError($attribute, 'Оператор с таким именем уже существует! Введите другое имя.');
			endif;
		endif;
	}
	public function getUser(){
		return Users::findOperator($this->name);
	}
	public function save(){
		$model = Users::getOperator(Yii::$app->user->identity['IdUser']);
		
		$model->Name = $this->name;
		$model->Password = $this->password;
		
		return $model->save()? $model : null;
	}
}