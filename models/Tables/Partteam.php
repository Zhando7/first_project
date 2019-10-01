<?php

namespace app\models\Tables;

use Yii;

/**
 * This is the model class for table "partteam".
 *
 * @property string $IdChild
 * @property string $IdUser
 * @property string $NameCommand
 * @property string $Surname
 * @property string $Name
 * @property string $Patronymic
 * @property string $LanguageLearning
 * @property string $ClassChild
 * @property string $District
 * @property string $School
 *
 * @property Users $idUser
 */
class Partteam extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partteam';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['IdUser', 'NameCommand', 'Surname', 'Name', 'ClassChild', 'District', 'School'], 'required'],
			[['Surname', 'Name', 'Patronymic', 'LanguageLearning', 'ClassChild', 'District', 'School'], 'trim'],
			[['Surname', 'Name', 'Patronymic', 'LanguageLearning', 'ClassChild', 'District', 'School'], 'string'],
            [['IdUser'], 'integer'],
            [['IdUser'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['IdUser' => 'IdUser']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'IdChild' => 'Id Child',
            'IdUser' => 'Id User',
            'NameCommand' => 'Название команды',
            'Surname' => 'Фамилия',
            'Name' => 'Имя',
            'Patronymic' => 'Отчество',
            'LanguageLearning' => 'Язык обучения',
            'ClassChild' => 'Класс',
            'District' => 'Район\город',
            'School' => 'Школа',
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
	* Функция необходимая для CommandsController, возвращает кол-во участников конкретной команды
	*/
	public static function getCountPr($id){
		return static::find()->where(['IdUser' => $id])->count();
	}
	/**
	* Функция сверяющая вводимые данные нового участника с уже существующими, необходимо для предотвращения вторичного создания участника
	*/
	public static function getPartaker($surname, $name, $patronymic, $school){
		return static::findOne(
			[
				'IdUser' => Yii::$app->user->identity['IdUser'],
				'Surname' => $surname,
				'Name' => $name,
				'Patronymic' => $patronymic,
				'School' => $school
			]
		);
	}
	/**
	* Функция сверяющая вводимые данные нового участника с уже существующими, необходимо для предотвращения вторичного создания участника
	*/
	public static function getPrForOp($surname, $name, $patronymic, $school){
		return static::findOne(
			[
				'IdUser' => Yii::$app->request->get('id'),
				'Surname' => $surname,
				'Name' => $name,
				'Patronymic' => $patronymic,
				'School' => $school
			]
		);
	}
	/**
	* Функция сверяющая вводимые данные нового участника с уже существующими, необходимо для предотвращения вторичного создания участника
	*/
	public static function getForEdit($info, $surname, $name, $patronymic, $school){
		return static::findOne(
			[
				'IdUser' => $info,
				'Surname' => $surname,
				'Name' => $name,
				'Patronymic' => $patronymic,
				'School' => $school
			]
		);
	}
	/**
	* Функция поиска участника команды
	*/
	public static function getChild($id){
		return static::findOne(
			[
				'IdChild' => $id
			]
		);
	}
	/**
	* Функция поиска участника команды, необходимо для CommandsController
	*/
	public static function findOneChild(){
		return static::findOne(
			[
				'IdUser' => Yii::$app->user->identity['IdUser']
			]
		);
	}
	/**
	* Функция поиска участников команды, необходимо для ExpertController
	*/
	public static function getChilds($id){
		return static::find()->where(['IdUser' => $id])->orderBy('Surname')->all();
	}
}
