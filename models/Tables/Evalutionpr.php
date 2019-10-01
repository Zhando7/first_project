<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "evalutionpr".
 *
 * @property string $Id
 * @property string $IdEvalution
 * @property string $IdExp
 * @property string $IdPartaker
 * @property string $IdCompetence
 * @property string $IdCriterion
 * @property double $Evalution
 * @property string $TodayDate
 *
 * @property Crudevalutionpr $idEvalution
 */
class Evalutionpr extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evalutionpr';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEvalution', 'IdExp', 'IdPartaker', 'IdCompetence', 'IdCriterion', 'TodayDate'], 'required'],
            [['IdEvalution', 'IdExp', 'IdPartaker', 'IdCompetence', 'IdCriterion'], 'integer'],
            [['Evalution'], 'number'],
			[['Evalution'], 'trim'],
			[['Evalution'], 'default', 'value' => 0],
            [['TodayDate'], 'safe'],
            [['IdEvalution'], 'exist', 'skipOnError' => true, 'targetClass' => Crudevalutionpr::className(), 'targetAttribute' => ['IdEvalution' => 'IdEvalution']],
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
            'IdExp' => 'Id Exp',
            'IdPartaker' => 'Id Partaker',
            'IdCompetence' => 'Id Competence',
            'IdCriterion' => 'Id Criterion',
            'Evalution' => 'Оценка',
            'TodayDate' => 'Дата начала',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvalution()
    {
        return $this->hasOne(Crudevalutionpr::className(), ['IdEvalution' => 'IdEvalution']);
    }
	
	/**
	* Функция получения значений нужной строки, необходимо для ExpertController
	*/
	public static function getMe($id){
		return static::findOne(
			[
				'IdExp' => Yii::$app->user->identity['IdUser'],
				'IdEvalution' => $id
			]
		);
	}
	/**
	* Функция получения значений нужных строк, необходимо для ExpertController
	*/
	public static function getSelectEva($id){
		return static::findAll(
			[
				'IdExp' => Yii::$app->user->identity['IdUser'],
				'IdEvalution' => $id
			]
		);
	}
	/**
	* Функция получения значений нужных строк, необходимо для ExpertController
	*/
	public static function getPartaker($id){
		return static::find()->where(['IdExp' => Yii::$app->user->identity['IdUser'], 'IdEvalution' => $id])->groupBy('IdPartaker')->all();
	}
	/**
	* Функция получения значений нужных строк, необходимо для ExpertController
	*/
	public static function getAll($id){
		return static::findAll(
			[
				'IdEvalution' => $id
			]
		);
	}
	/**
	* Функция получения значений нужных строк, необходимо для ExpertController
	*/
	public static function getCountPr($id){
		return static::find()->where(['IdEvalution' => $id])->groupBy('IdPartaker')->all();
	}
	// Функция необходимая для удаления оператором участника
	public static function findUser($evalution, $user){
		return static::find()->where(['IdEvalution' => $evalution, 'IdPartaker' => $user])->one();
	}
}
