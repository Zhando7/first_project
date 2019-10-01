<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "competence".
 *
 * @property string $IdCompetence
 * @property string $Name
 * @property string $Description
 *
 * @property Criterion[] $criterions
 * @property Crudevalution[] $crudevalutions
 */
class Competence extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'competence';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['Name'], 'trim'],
            [['Name', 'Description'], 'required'],
            [['Name', 'Description'], 'string', 'min' => 3],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdCompetence' => 'Id Competence',
            'Name' => 'Название:',
            'Description' => 'Описание:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCriterions()
    {
        return $this->hasMany(Criterion::className(), ['IdCompetence' => 'IdCompetence']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCrudevalutions()
    {
        return $this->hasMany(Crudevalution::className(), ['IdCompetence' => 'IdCompetence']);
    }
	
	/**
	* Функция получения значений атрибутов нужной строки
	*/
	public static function getOne($id){
		return static::findOne(
			[
				'IdCompetence' => $id
			]
		);
	}
}
