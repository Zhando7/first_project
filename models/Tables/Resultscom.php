<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "resultscom".
 *
 * @property string $Id
 * @property string $IdEvalution
 * @property string $IdCommand
 * @property double $Result
 * @property string $NameCommand
 * @property string $Competence
 * @property string $NameEvalution
 * @property string $TodayDate
 */
class Resultscom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultscom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEvalution', 'IdCommand', 'Result', 'NameCommand', 'Competence', 'NameEvalution', 'TodayDate'], 'required'],
            [['IdEvalution', 'IdCommand'], 'integer'],
            [['Result'], 'number'],
            [['NameCommand', 'Competence', 'NameEvalution'], 'string'],
            [['TodayDate'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'ID',
            'IdEvalution' => 'Id Evalution',
            'IdCommand' => 'Id Command',
            'Result' => 'Result',
            'NameCommand' => 'Name Command',
            'Competence' => 'Competence',
            'NameEvalution' => 'Name Evalution',
            'TodayDate' => 'Today Date',
        ];
    }
	
	/**
	* Функция возвращающая количество участников конкретного оценивания
	*/
	public static function getCountEva($id){
		return static::find()->where(['IdEvalution' => $id])->count();
	}
	/**
	* Функция возвращающая результаты по выбранной оценивании
	*/
	public static function getResult($id){
		return static::find()->where(['IdEvalution' => $id])->orderBy(['Result' => SORT_DESC]);
	}
	/**
	* Функция необходимая для проверки существования выбранного оценивания для просмотра его результатов
	*/
	public static function checkExistResult($id){
		return static::findOne(
			[
				'IdEvalution' => $id
			]
		);
	}
	// Функция необходимая для удаления оператором команды
	public static function findUser($evalution, $user){
		return static::find()->where(['IdEvalution' => $evalution, 'IdCommand' => $user])->one();
	}
	// Функций необходимые для вычисления общих итогов
	public static function getTotal($date){
		return static::find()->where(['TodayDate' => $date])->groupBy('IdCommand')->all();	
	}
	public static function getAllResult($date){
		return static::find()->where(['TodayDate' => $date])->all();
	}
}
