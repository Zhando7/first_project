<?php
namespace app\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tables\Partteam;

class SearchPartteam extends Partteam
{
	public function rules(){
		return [
			[['Surname', 'Name', 'Patronymic', 'ClassChild', 'School'], 'trim'],
			[['Surname', 'Name', 'Patronymic', 'ClassChild', 'School'], 'string'],
		];
	}
	public function scenarios(){
		return Model::scenarios();
	}
	public function search($params){
		if(Yii::$app->user->identity['AuthKey'] == 4):
			$query = Partteam::find()->where(['IdUser' => Yii::$app->user->identity['IdUser']]);
		else:
			if(Yii::$app->user->identity['AuthKey'] == 1):
				$query = Partteam::find()->where(['IdUser' => Yii::$app->request->get('id')]);
			endif;
		endif;
		
		
		$dataProvider = new ActiveDataProvider(
			[
				'query' => $query,
				'pagination' => [
					'pageSize' => 10
				]
			]
		);
		
		if(!($this->load($params) and $this->validate())):
			return $dataProvider;
		endif;
		
		$query->andFilterWhere(['like', 'Surname', $this->Surname]);
		$query->andFilterWHere(['like', 'Name', $this->Name]);
		$query->andFilterWHere(['like', 'Patronymic', $this->Patronymic]);
		$query->andFilterWHere(['like', 'ClassChild', $this->ClassChild]);
		$query->andFilterWHere(['like', 'School', $this->School]);
		
		return $dataProvider;
	}
}