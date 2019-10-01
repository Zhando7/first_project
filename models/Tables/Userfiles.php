<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "userfiles".
 *
 * @property integer $Id
 * @property string $IdUser
 * @property string $NameFile
 * @property string $TodayDate
 *
 * @property Users $idUser
 */
class Userfiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'userfiles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdUser', 'NameFile', 'TodayDate'], 'required'],
            [['IdUser'], 'integer'],
            [['NameFile'], 'string'],
            [['TodayDate'], 'safe'],
            [['IdUser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['IdUser' => 'IdUser']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdUser' => 'Id User',
            'NameFile' => 'Имя файла:',
            'TodayDate' => 'Дата:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdUser()
    {
        return $this->hasOne(Users::className(), ['IdUser' => 'IdUser']);
    }
	
	/**
	* Функция поиска файла
	*/
	public static function getOne($id){
		return static::findOne(
			[
				'Id' => $id,
				'IdUser' => Yii::$app->user->identity['IdUser']
			]
		);
	}
	/**
	* Функция поиска файлов конкретного пользователя
	*/
	public static function getFiles(){
		return static::find()->where(['IdUser' => Yii::$app->user->identity['IdUser']]);
	}
	/**
	* Функция поиска конкретного пользователя
	*/
	public static function getUser(){
		return static::find()->where(['IdUser' => Yii::$app->user->identity['IdUser']])->one();
	}
	/**
	* Функция поиска конкретного пользователя, необходимо для ExpertController
	*/
	public static function getFilesUser($id){
		return static::findAll(
			[
				'IdUser' => $id
			]
		);
	}
	/**
	* Функция поиска файлов пользователя, необходимо для OperatorController
	*/
	public static function getFilesNeedUser($id){
		return static::find()->where(['IdUser' => $id]);
	}
	/**
	* Функция поиска конкретного файла, необходимо для ExpertController
	*/
	public static function getFile($id){
		return static::findOne(
			[
				'Id' => $id
			]
		);
	}
}
