<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "bidcom".
 *
 * @property string $IdBid
 * @property string $IdEvalution
 * @property string $IdUser
 *
 * @property Users $idUser
 * @property Crudevalutioncom $idEvalution
 */
class Bidcom extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bidcom';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdEvalution', 'IdUser'], 'required'],
            [['IdEvalution', 'IdUser'], 'integer'],
            [['IdUser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['IdUser' => 'IdUser']],
            [['IdEvalution'], 'exist', 'skipOnError' => true, 'targetClass' => Crudevalutioncom::className(), 'targetAttribute' => ['IdEvalution' => 'IdEvalution']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdBid' => 'Id Bid',
            'IdEvalution' => 'Id Evalution',
            'IdUser' => 'Id User',
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
     * @return \yii\db\ActiveQuery
     */
    public function getIdEvalution()
    {
        return $this->hasOne(Crudevalutioncom::className(), ['IdEvalution' => 'IdEvalution']);
    }
	
	// Функция получения значений атрибутов нужной строки
	public static function getOne($id){
		return static::findOne(
			[
				'IdUser' => Yii::$app->user->identity['IdUser'],
				'IdEvalution' => $id
			]
		);
	}
	// Функция получения количества нужных строк
	public static function getAllCount($id){
		return static::find()->where(['IdEvalution' => $id])->count();
	}
	// Функция получения значений атрибутов нужной строки
	public static function getMyBid($id){
		return static::findOne(
			[
				'IdUser' => Yii::$app->user->identity['IdUser'],
				'IdEvalution' => $id
			]
		);
	}
	// Функция получения значений атрибутов нужных строк
	public static function getAllMyBid(){
		return static::find()->where(['IdUser' => Yii::$app->user->identity['IdUser']]);
	}
	// Функция получения значений атрибутов нужных строк, необходимо для ExpertController
	public static function getSelectBid($id){
		return static::findAll(
			[
				'IdEvalution' => $id
			]
		);
	}
	// Функция получения заявок на выбранное оценивание оператором
	public static function getSelectEva($id){
		return static::find()->where(['IdEvalution' => $id]);
	}
	// Функция необходимая для удаления заявок команд оператором
	public static function getUser($id){
		return static::findOne(
			[
				'IdUser' => $id
			]
		);
	}
	// Функция необходимая для сравнения наличия поданных заявок
	public static function findUser($evalution, $user){
		return static::find()->where(['IdEvalution' => $evalution, 'IdUser' => $user])->one();
	}
}
