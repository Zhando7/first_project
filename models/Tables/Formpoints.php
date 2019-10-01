<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "formpoints".
 *
 * @property string $IdPoint
 * @property string $Name
 * @property double $Initial
 * @property double $Final
 */
class Formpoints extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'formpoints';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['Name', 'Initial', 'Final'], 'trim'],
            [['Name', 'Initial', 'Final'], 'required'],
            [['Name'], 'string'],
            [['Initial', 'Final'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdPoint' => 'Id Point',
            'Name' => 'Название:',
            'Initial' => 'От:',
            'Final' => 'До:',
        ];
    }
	
	/**
	* Функция получения значений всех артибутов
	*/
	public static function getAll(){
		return static::find()->all();
	}
	
	/**
	* Функция получения значений атрибутов нужной строки
	*/
	public static function getOne($id){
		return static::findOne(
			[
				'IdPoint' => $id
			]
		);
	}
}
