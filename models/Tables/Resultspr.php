<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "resultspr".
 *
 * @property string $Id
 * @property string $IdEvalution
 * @property string $IdPartaker
 * @property double $Result
 * @property string $Fio
 * @property string $ClassChild
 * @property string $Language
 * @property string $District
 * @property string $School
 * @property string $Competence
 * @property string $NameEvalution
 * @property string $TodayDate
 */
class Resultspr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'resultspr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEvalution', 'IdPartaker', 'Result', 'Fio', 'ClassChild', 'District', 'School', 'Competence', 'NameEvalution', 'TodayDate'], 'required'],
            [['IdEvalution', 'IdPartaker'], 'integer'],
            [['Result'], 'number'],
            [['Fio', 'District', 'School', 'Competence', 'NameEvalution'], 'string'],
            [['TodayDate'], 'safe'],
            [['ClassChild', 'Language'], 'string', 'max' => 255],
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
            'IdPartaker' => 'Id Partaker',
            'Result' => 'Result',
            'Fio' => 'Fio',
            'ClassChild' => 'Class Child',
            'Language' => 'Language',
            'District' => 'District',
            'School' => 'School',
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
	// Функция необходимая для удаления оператором участника
	public static function findUser($evalution, $user){
		return static::find()->where(['IdEvalution' => $evalution, 'IdPartaker' => $user])->one();
	}
	// Функций необходимые для вычисления общих итогов
	public static function getTotal($date){
		return static::find()->where(['TodayDate' => $date])->groupBy('IdPartaker')->all();	
	}
	public static function getAllResult($date){
		return static::find()->where(['TodayDate' => $date])->all();
	}
}