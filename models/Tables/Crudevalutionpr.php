<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "crudevalutionpr".
 *
 * @property string $IdEvalution
 * @property string $IdCompetence
 * @property string $Name
 * @property string $TodayDate
 * @property string $Limit
 * @property integer $Show
 *
 * @property Bidpr[] $bidprs
 * @property Evalutionpr[] $evalutionprs
 */
class Crudevalutionpr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'crudevalutionpr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdCompetence', 'Name', 'TodayDate', 'Show'], 'required'],
			[['Limit'], 'default', 'value' => 0 ],
            [['IdCompetence', 'Limit', 'Show'], 'integer'],
            [['Name'], 'string'],
            [['TodayDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdEvalution' => 'Id Evalution',
            'IdCompetence' => 'Компетенция:',
            'Name' => 'Название:',
            'TodayDate' => 'Дата начала:',
            'Limit' => 'Ограничения:',
            'Show' => 'Показывать экспертам:',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBidprs()
    {
        return $this->hasMany(Bidpr::className(), ['IdEvalution' => 'IdEvalution']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEvalutionprs()
    {
        return $this->hasMany(Evalutionpr::className(), ['IdEvalution' => 'IdEvalution']);
    }
	
	// Функция получения значений атрибутов нужной строки
	public static function getOne($id){
		return static::findOne(
			[
				'IdEvalution' => $id
			]
		);
	}
	// Функция организаций списка общих итогов по датам
	public static function getResult(){
		return static::find()->groupBy('TodayDate');	
	}
}
