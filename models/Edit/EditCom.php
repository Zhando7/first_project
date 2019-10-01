<?php
namespace app\models\Edit;

use Yii;
use yii\base\Model;
use app\models\Tables\Users;
use app\models\Tables\Partteam;
use app\models\Tables\Resultscom;

class EditCom extends Model
{
	public 	$name,
			$email,
			$password;
			
	public function rules(){
		return [
			[['name', 'email', 'password'], 'required'],
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
			$user = Users::checkName($this->name);
			
			if(Yii::$app->user->identity['AuthKey'] == 4):
				if($user and ($user->IdUser != Yii::$app->user->identity['IdUser'])):
					$this->addError($attribute, 'Введенное название уже занято!');
				endif;
			else:
				if(Yii::$app->user->identity['AuthKey'] == 1):
					if($user and ($user->IdUser != Yii::$app->request->get('id'))):
						$this->addError($attribute, 'Введенное название уже занято!');
					endif;
				endif;
			endif;
		endif;
	}
	public function validateEmail($attribute){
		if(!$this->hasErrors()):
			$user = Users::checkEmailCom($this->email);
			
			if(Yii::$app->user->identity['AuthKey'] == 4):
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
		if(Yii::$app->user->identity['AuthKey'] == 4):
			$model = Users::getCom(Yii::$app->user->identity['IdUser']);
			Partteam::updateAll(['NameCommand' => $this->name], ['like', 'IdUser', Yii::$app->user->identity['IdUser']]);
			Resultscom::updateAll(['NameCommand' => $this->name], ['like', 'IdCommand', Yii::$app->user->identity['IdUser']]);
		else:
			if(Yii::$app->user->identity['AuthKey'] == 1):
				$model = Users::getCom(Yii::$app->request->get('id'));
				Partteam::updateAll(['NameCommand' => $this->name], ['like', 'IdUser', Yii::$app->request->get('id')]);
				Resultscom::updateAll(['NameCommand' => $this->name], ['like', 'IdCommand', Yii::$app->request->get('id')]);
			endif;
		endif;
		
		$model->Name = $this->name;
		$model->Email = $this->email;
		$model->Password = $this->password;
		
		return $model->save()? $model : null;
	}
}