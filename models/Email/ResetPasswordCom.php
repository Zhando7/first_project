<?php
namespace app\models\Email;

use Yii;
use yii\base\Model;
use yii\base\InvalidParamException;
use app\models\Tables\Users;

class ResetPasswordCom extends Model
{
	public $password;
	private $user;
	
	public function rules(){
		return [
			[['password'], 'trim'],
			[['password'], 'required'],
			[['password'], 'string', 'min' => 3]
		];
	}
	public function attributeLabels(){
		return [
			'password' => 'Пароль:'
		];
	}
	public function __construct($key, $config = []){
		if(empty($key) or !is_string($key)):
			throw new InvalidParamException('Ключ не может быть пустым.');
		else:
			$this->user = Users::findBySecretKey($key);
			
			if(!$this->user):
				throw new InvalidParamException('Не верный ключ.');
			endif;
			
			parent::__construct($config);
		endif;
	}
	public function resetPassword(){
		$data = $this->user;
		$data->Password = $this->password;
		$data->removeSecretKey();
		return $data->save();
	}
}