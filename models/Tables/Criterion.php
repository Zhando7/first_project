<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "criterion".
 *
 * @property integer $IdCriterion
 * @property string $IdCompetence
 * @property string $IdPoint
 * @property string $Name
 * @property string $Description
 *
 * @property Competence $idCompetence
 */
class Criterion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'criterion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['Name'], 'trim'],
            [['IdCompetence', 'IdPoint', 'Name', 'Description'], 'required'],
			[['Name', 'Description'], 'string', 'min' => 3],
            [['IdCompetence', 'IdPoint'], 'integer'],
            [['IdCompetence'], 'exist', 'skipOnError' => true, 'targetClass' => Competence::className(), 'targetAttribute' => ['IdCompetence' => 'IdCompetence']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCriterion' => 'Id Criterion',
            'IdCompetence' => 'Id Competence',
            'IdPoint' => 'Форма оценивания:',
            'Name' => 'Название:',
            'Description' => 'Описание:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdCompetence()
    {
        return $this->hasOne(Competence::className(), ['IdCompetence' => 'IdCompetence']);
    }
	
	/**
	* Функция получения значений атрибутов нужной строки
	*/
	public static function getOne($id){
		return static::findOne(
			[
				'IdCriterion' => $id
			]
		);
	}
	/**
	* Функция получения значений атрибутов нужных строк
	*/
	public static function getCompetence($id){
		return static::findAll(
			[
				'IdCompetence' => $id
			]
		);
	}
}
