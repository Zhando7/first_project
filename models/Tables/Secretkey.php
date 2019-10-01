<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "secretkey".
 *
 * @property string $IdKey
 * @property string $Key
 * @property string $IdUser
 * @property string $Name
 * @property string $TodayDateTime
 */
class Secretkey extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'secretkey';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Key', 'IdUser', 'Name', 'TodayDateTime'], 'required'],
            [['IdUser'], 'integer'],
            [['Name'], 'string'],
            [['TodayDateTime'], 'safe'],
            [['Key'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdKey' => 'Id Key',
            'Key' => 'Секретный ключ:',
            'IdUser' => 'Id User',
            'Name' => 'Название:',
            'TodayDateTime' => 'Today Date Time',
        ];
    }
	
	/**
	* Функция необходимая для проверки совпадения секретного ключа введеного экспертом при регистрации
	*/
	public static function checkSecretKey($inputkey){
		return static::findOne(
			[
				'Key' => $inputkey
			]
		);
	}
	/**
	* Функция необходимая для изменения секретного ключа
	*/
	public static function getSecretKey($id){
		return static::findOne(
			[
				'IdKey' => $id
			]
		);
	}
}
