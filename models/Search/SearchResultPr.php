<?php
namespace app\models\Search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tables\Resultspr;

class SearchResultPr extends Resultspr
{
	public function rules(){
		return [
			[['Competence', 'NameEvalution'], 'string'],
			[['Competence', 'NameEvalution'], 'trim'],
			[['TodayDate'], 'safe'],
		];
	}
	public function scenarios(){
		return Model::scenarios();
	}
	public function search($params){
		$query = Resultspr::find()->groupBy('IdEvalution')->orderBy(['TodayDate' => SORT_DESC]);
		
		$dataProvider = new ActiveDataProvider(
			[
				'query' => $query,
				'pagination' => [
					'pageSize' => 12
				]
			]
		);
		
		if(!($this->load($params) and $this->validate())):
			return $dataProvider;
		endif;
		
		$query->andFilterWhere(['like', 'Competence', $this->Competence]);
		$query->andFilterWhere(['like', 'NameEvalution', $this->NameEvalution]);
		$query->andFilterWhere(['=', 'TodayDate', $this->TodayDate]);
		
		return $dataProvider;
	}
}