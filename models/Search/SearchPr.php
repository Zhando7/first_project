<?php
namespace app\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tables\Users;

class SearchPr extends Users
{
	public function rules(){
		return [
			[['Surname', 'Name', 'Patronymic', 'Field1', 'Field4'], 'trim'],
			[['Surname', 'Name', 'Patronymic'], 'string'],
			[['Field1', 'Field4'], 'string']
		];
	}
	public function scenarios(){
		return Model::scenarios();
	}
	public function search($params){
		$query = Users::find()->where(['AuthKey' => 3])->orderBy('Surname');
		
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
		$query->andFilterWHere(['like', 'Field1', $this->Field1]);
		$query->andFilterWHere(['like', 'Field4', $this->Field4]);
		
		return $dataProvider;
	}
}