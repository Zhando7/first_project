<?php
namespace app\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tables\Users;

class SearchExp extends Users
{
	public function rules(){
		return [
			[['Surname', 'Name', 'Patronymic', 'Field1'], 'trim'],
			[['Surname', 'Name', 'Patronymic', 'Field1'], 'string'],
		];
	}
	public function scenarios(){
		return Model::scenarios();
	}
	public function search($params){
		$query = Users::find()->where(['AuthKey' => 2])->orderBy('Surname');
		
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
		$query->andFilterWhere(['like', 'Name', $this->Name]);
		$query->andFilterWhere(['like', 'Patronymic', $this->Patronymic]);
		$query->andFilterWhere(['like', 'Field1', $this->Field1]);
		
		return $dataProvider;
	}
}