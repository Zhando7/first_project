<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "evalutioncom".
 *
 * @property string $Id
 * @property string $IdEvalution
 * @property string $IdExp
 * @property string $IdCommand
 * @property string $IdCompetence
 * @property string $IdCriterion
 * @property double $Evalution
 * @property string $TodayDate
 *
 * @property Crudevalutioncom $idEvalution
 */
class Evalutioncom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'evalutioncom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEvalution', 'IdExp', 'IdCommand', 'IdCompetence', 'IdCriterion', 'TodayDate'], 'required'],
            [['IdEvalution', 'IdExp', 'IdCommand', 'IdCompetence', 'IdCriterion'], 'integer'],
            [['Evalution'], 'number'],
			[['Evalution'], 'trim'],
			[['Evalution'], 'default', 'value' => 0],
            [['TodayDate'], 'safe'],
            [['IdEvalution'], 'exist', 'skipOnError' => true, 'targetClass' => Crudevalutioncom::className(), 'targetAttribute' => ['IdEvalution' => 'IdEvalution']],
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
            'IdCommand' => 'Id Command',
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
        return $this->hasOne(Crudevalutioncom::className(), ['IdEvalution' => 'IdEvalution']);
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
	public static function getCommands($id){
		return static::find()->where(['IdExp' => Yii::$app->user->identity['IdUser'], 'IdEvalution' => $id])->groupBy('IdCommand')->all();
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
	public static function getCountCom($id){
		return static::find()->where(['IdEvalution' => $id])->groupBy('IdCommand')->all();
	}
	// Функция необходимая для удаления оператором команды
	public static function findUser($evalution, $user){
		return static::find()->where(['IdEvalution' => $evalution, 'IdCommand' => $user])->one();
	}
}