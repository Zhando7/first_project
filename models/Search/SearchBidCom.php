<?php
namespace app\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tables\Crudevalutioncom;

class SearchBidCom extends Crudevalutioncom
{
	public function rules(){
		return [
			[['Name'], 'trim'],
			[['Name', 'Show'], 'string'],
			[['TodayDate'], 'safe'],
		];
	}
	public function scenarios(){
		return Model::scenarios();
	}
	public function search($params){
		$query = Crudevalutioncom::find()->where(['>', 'TodayDate', date('Y-m-d')])->orderBy(['TodayDate' => SORT_DESC]);
		
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
		$query->andFilterWhere(['like', 'Show', $this->Show]);
		$query->andFilterWhere(['=', 'TodayDate', $this->TodayDate]);
		
		return $dataProvider;
	}
}