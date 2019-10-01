<?php
namespace app\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tables\Users;

class SearchCom extends Users
{
	public function rules(){
		return [
			[['Name'], 'trim'],
			[['Name'], 'string']
		];
	}
	public function scenarios(){
		return Model::scenarios();
	}
	public function search($params){
		$query = Users::find()->where(['AuthKey' => 4])->orderBy(['IdUser' => SORT_DESC]);
		
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
		
		$query->andFilterWhere(['like', 'Name', $this->Name]);
		
		return $dataProvider;
	}
}