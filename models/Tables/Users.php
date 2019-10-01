<?php

namespace app\models\Tables;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property string $IdUser
 * @property integer $AuthKey
 * @property string $Password
 * @property string $Surname
 * @property string $Name
 * @property string $Patronymic
 * @property string $Field1
 * @property string $Field2
 * @property string $Field3
 * @property string $Field4
 * $property string $Email
 * $property string $SecretKey
 *
 * @property Bid[] $bs
 * @property Compexp[] $compexps
 * @property Partteam[] $partteams
 * @property Userfiles[] $userfiles
 */
class Users extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['Surname', 'Name', 'Patronymic', 'Field1', 'Field2', 'Field3', 'Field4', 'Email', 'Password'], 'trim'],
            [['Password', 'Name'], 'required'],
			[['AuthKey'], 'integer'],
            [['Surname', 'Name', 'Patronymic', 'Field1', 'Field2', 'Field3', 'Field4', 'Email', 'SecretKey'], 'string'],
            [['Password'], 'string', 'min' => 3, 'max' => 255],
			[['Email'], 'email'],
			//[['Email'], 'unique'],
			[['SecretKey'], 'unique']
        ];
    }
	
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdUser' => 'Id User',
            'AuthKey' => 'Auth Key',
            'Password' => 'Password',
            'Surname' => 'Surname',
            'Name' => 'Name',
            'Patronymic' => 'Patronymic',
            'Field1' => 'Field1',
            'Field2' => 'Field2',
            'Field3' => 'Field3',
            'Field4' => 'Field4',
			'Email' => 'Email',
			'SecretKey' => 'Secret key'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBs()
    {
        return $this->hasMany(Bid::className(), ['IdUser' => 'IdUser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompexps()
    {
        return $this->hasMany(Compexp::className(), ['IdUser' => 'IdUser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPartteams()
    {
        return $this->hasMany(Partteam::className(), ['IdUser' => 'IdUser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserfiles()
    {
        return $this->hasMany(Userfiles::className(), ['IdUser' => 'IdUser']);
    }
	
	/**
	* Функций ниже необходимы для идентификаций пользователя 
	*/
	 public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        //return static::findOne(['access_token' => $token]);
    }

    public function getId()
    {
        return $this->IdUser;
    }

    public function getAuthKey()
    {
        //return $this->authKey;
    }

    public function validateAuthKey($authKey)
    {
        //return $this->authKey === $authKey;
    }
	
	/**
	* Хелперы необходимые для восстановления пароля
	*/
	public function generateSecretKey(){
		$this->SecretKey = Yii::$app->security->generateRandomString().'_'.time();
	}
	public function removeSecretKey(){
		$this->SecretKey = null;
	}
	/**
	* Функция проверки ключа на его существование и активности его длительности
	*/
	public static function isSecretKeyExpire($key){
		if(empty($key)):
			return false;
		else:
			$expire = Yii::$app->params['secretKeyExpire'];
			$parts = explode('_', $key);
			$timestamp = (int) end($parts);
			return $timestamp + $expire >= time();
		endif;
	}
	/**
	* Функция поиска по секретному ключу
	*/
	public static function findBySecretKey($key){
		if(!static::isSecretKeyExpire($key)):
			return false;
		else:
			return static::findOne(
				[
					'SecretKey' => $key
				]
			);
		endif;
	}
	
	/**
	* Функция поиска оператора
	*/
	public static function findOperator($name){
		return static::findOne(
			[
				'AuthKey' => 1,
				'Name' => $name
			]
		);
	}
	/**
	* Функция проверки совпадения пароля оператора
	*/
	public static function checkPasswordOp($name, $password){
		return static::findOne(
			[
				'AuthKey' => 1,
				'Name' => $name,
				'Password' => $password
			]
		);
	}
	/**
	* Функция поиска эксперта
	*/
	public static function findExpert($surname, $name){
		return static::findOne(
			[
				'AuthKey' => 2,
				'Surname' => $surname,
				'Name' => $name
			]
		);
	}
	/**
	* Функция проверки совпадения пароля эксперта
	*/
	public static function checkPasswordExp($surname, $name, $password){
		return static::findOne(
			[
				'AuthKey' => 2,
				'Surname' => $surname,
				'Name' => $name,
				'Password' => $password
			]
		);
	}
	/**
	* Функция проверки существования введеного контакта экспертом при регистратции
	*/
	public static function checkPassword($password){
		return static::findOne(
			[
				'AuthKey' => 2,
				'Password' => $password
			]
		);
	}
	/**
	* Функция проверки существования введеного участника при регистратции
	*/
	public static function checkExistPartaker($surname, $name, $patronymic, $school){
		return static::findOne(
			[
				'AuthKey' => 3,
				'Surname' => $surname,
				'Name' => $name,
				'Patronymic' => $patronymic,
				'Field4' => $school
			]
		);
	}
	/**
	* Функция проверки совпадения введеных данных для авторизации участника
	*/
	public static function checkDataPartaker($surname, $name, $password){
		return static::findOne(
			[
				'AuthKey' => 3,
				'Surname' => $surname,
				'Name' => $name,
				'Password' => $password
			]
		);
	}
	/**
	* Функция проверки существования введеной почты для корректного редактирования данных участника
	*/
	public static function checkEmailPr($email){
		return static::findOne(
			[
				'AuthKey' => 3,
				'Email' => $email
			]
		);
	}
	/**
	* Функция проверки совпадения названия команды при регистратции
	*/
	public static function checkName($name){
		return static::findOne(
			[
				'AuthKey' => 4,
				'Name' => $name
			]
		);
	}
	/**
	* Функция проверки существования введеной почты для корректного редактирования данных команды
	*/
	public static function checkEmailCom($email){
		return static::findOne(
			[
				'AuthKey' => 4,
				'Email' => $email
			]
		);
	}
	/**
	* Функция проверки совпадения введеных данных для авторизации команды
	*/
	public static function checkCommand($name, $password){
		return static::findOne(
			[
				'AuthKey' => 4,
				'Name' => $name,
				'Password' => $password
			]
		);
	}
	/**
	* Функция поиска и получения данных об операторе
	*/
	public static function getOperator($id){
		return static::findOne(
			[
				'AuthKey' => 1,
				'IdUser' => $id
			]
		);
	}
	/**
	* Функция поиска и получения данных об эксперте
	*/
	public static function getExp($id){
		return static::findOne(
			[
				'AuthKey' => 2,
				'IdUser' => $id
			]
		);
	}
	/**
	* Функция поиска и получения данных об участнике
	*/
	public static function getPr($id){
		return static::findOne(
			[
				'AuthKey' => 3,
				'IdUser' => $id
			]
		);
	}
	/**
	* Функция поиска и получения данных о команде
	*/
	public static function getCom($id){
		return static::findOne(
			[
				'AuthKey' => 4,
				'IdUser' => $id
			]
		);
	}
}
