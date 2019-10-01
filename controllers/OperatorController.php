<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\web\Session;

/**
* ��������� ������
*/
use app\models\Login\LoginOp;
use app\models\Tables\Users;
use app\models\Tables\Partteam;
use app\models\Tables\Crudevalutionpr;
use app\models\Tables\Crudevalutioncom;
use app\models\Tables\Bidpr;
use app\models\Tables\Bidcom;
use app\models\Tables\Evalutionpr;
use app\models\Tables\Evalutioncom;
use app\models\Tables\Competence;
use app\models\Tables\Criterion;
use app\models\Tables\Formpoints;
use app\models\Tables\Secretkey;
use app\models\Tables\Resultspr;
use app\models\Tables\Resultscom;
use app\models\Tables\Userfiles;
use app\models\Search\SearchExp;
use app\models\Search\SearchPr;
use app\models\Search\SearchCom;
use app\models\Search\SearchPartteam;
use app\models\Search\SearchCompetence;
use app\models\Search\SearchCrudEvaPr;
use app\models\Search\SearchCrudEvaCom;
use app\models\Create\CreateExpert;
use app\models\Create\CreatePr;
use app\models\Create\CreateCom;
use app\models\Create\CreatePartteam;
use app\models\Edit\PersonalData;
use app\models\Edit\EditExp;
use app\models\Edit\EditPr;
use app\models\Edit\EditCom;
use app\models\Edit\EditPartteam;
use app\models\Files\Loadingfiles;

class OperatorController extends Controller
{
	/** 
	* ����� ������������ ���� ���������� ���������
	*/
	public function actionLogin(){
		if(Yii::$app->user->isGuest):
			$url = Url::previous();
			$model = new LoginOp();
			
			if($model->load(Yii::$app->request->post())):
				if($model->login()):
					return $this->goHome();
				endif;
			endif;
			return $this->render('login', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "���������"
	*/
	public function actionIndexcompetence(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchCompetence();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexcompetence', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������� ����� ����������
	public function actionCreatecompetence(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new Competence();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createcompetence', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� �������� ����������
	public function actionEditcompetence($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($model = Competence::getOne($id)):
				if($model->load(Yii::$app->request->post())):
					if($model->validate() and $model->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editcompetence', ['model' => $model, 'url' => $url]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ������� �������� ����������
	public function actionDelcompetence($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($model = Competence::getOne($id)):
				$model->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "��������" �� �������� ����������
	*/
	public function actionIndexcriterion($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$query = Criterion::find()->where(['IdCompetence' => $id]);
			$cloneQuery = clone $query;
			$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 10]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			return $this->render('indexcriterion', ['model' => $model, 'pages' => $pages, 'id' => $id]);
		endif;
	}
	// ����� ������������ ���� �� ������� ������ �������
	public function actionCreatecriterion($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new Criterion();
			if($model->load(Yii::$app->request->post()) and ($model->IdCompetence = $id)):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createcriterion', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��������� �������
	public function actionEditcriterion($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($model = Criterion::getOne($id)):
				if($model->load(Yii::$app->request->post())):
					if($model->validate() and $model->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editcriterion', ['model' => $model, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	// ����� ������� �������� �������
	public function actionDelcriterion($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($model = Criterion::getOne($id)):
				$model->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "����� ��������"
	*/
	public function actionIndexpoints(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$query = Formpoints::find();
			$cloneQuery = clone $query;
			$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 10]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			return $this->render('indexpoints', ['model' => $model, 'pages' => $pages]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������� ����� ���� ��������
	public function actionCreatepoint(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new Formpoints();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createpoint', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� �������� ���� ��������
	public function actionEditpoint($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($model = Formpoints::getOne($id)):
				if($model->load(Yii::$app->request->post())):
					if($model->validate() and $model->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editpoint', ['model' => $model, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	// ����� ������� �������� ���� ��������
	public function actionDelpoint($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($model = Formpoints::getOne($id)):
				$model->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "������ � ����������" �� ���������
	*/
	public function actionIndexcrudevapr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchCrudEvaPr();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexcrudevapr', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������� ��� ���������
	public function actionCreateevapr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new Crudevalutionpr();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createevapr', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��������� ��������
	public function actionEditevapr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($one = Crudevalutionpr::getOne($id)):
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editevapr', ['one' => $one, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	// ����� ������� ��������� ��������
	public function actionDelevapr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($one = Crudevalutionpr::getOne($id)):
				$one->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "������ � ����������" �� �������
	*/
	public function actionIndexcrudevacom(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchCrudEvaCom();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexcrudevacom', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������� ��� ���������
	public function actionCreateevacom(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new Crudevalutioncom();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createevacom', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��������� ��������
	public function actionEditevacom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($one = Crudevalutioncom::getOne($id)):
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editevacom', ['one' => $one, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	// ����� ������� ��������� ��������
	public function actionDelevacom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($one = Crudevalutioncom::getOne($id)):
				$one->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "�������� ��"
	*/
	public function actionIndexsecretkey(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = Secretkey::find()->all();
			if($model):
				foreach($model as $items):
					$key = $items->IdKey;
				endforeach;
			endif;
			
			return $this->render('indexsecretkey', ['model' => $model, 'key' => $key, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������� ������ ���������� ���
	public function actionEditkey($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($one = Secretkey::getSecretKey($id)):
				ini_set('date.timezone', 'Asia/Almaty');
				if($one->load(Yii::$app->request->post()) 
					and ($one->IdUser = Yii::$app->user->identity['IdUser']) 
					and ($one->TodayDateTime = date('Y-m-d H:i:s'))):
					if($one->validate() and $one->save()):
						return $this->redirect('/operator/indexsecretkey');
					endif;
				endif;
				
				return $this->render('editkey', ['one' => $one]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ���� "�������� ��� ����"
	*/
	public function actionEditpersonaldata(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($model = Users::getOperator(Yii::$app->user->identity['IdUser'])):
				$one = new PersonalData();
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editpersonaldata', ['one' => $one, 'model' => $model, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������� ��������� ��������� �������� ���������
	*/ 
	public function actionDeleteresultpr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if(Resultspr::checkExistResult($id)):
				Resultspr::deleteAll(['IdEvalution' => $id]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������� ��������� ��������� �������� ������
	*/ 
	public function actionDeleteresultcom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if(Resultscom::checkExistResult($id)):
				Resultscom::deleteAll(['IdEvalution' => $id]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "��������� �����"
	*/
	public function actionIndexexp(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchExp();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexexp', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������� ������ ��������
	public function actionCreateexp(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new CreateExpert();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createexp', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��������� ��������
	public function actionEditexp($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($model = Users::getExp($id)):
				$one = new EditExp();
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editexp', ['one' => $one, 'model' => $model, 'url' => $url]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ������� ��������� ��������
	public function actionDeleteexp($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($one = Users::getExp($id)):
				$one->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "��������"
	*/
	public function actionIndexpr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchPr();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexpr', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������� ������ ��������
	public function actionCreatepr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new CreatePr();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createpr', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��������� ��������
	public function actionEditpr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($model = Users::getPr($id)):
				$one = new EditPr();
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
			endif;
			return $this->render('editpr', ['one' => $one, 'model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������� ��������� ��������
	public function actionDeletepr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($files = Userfiles::getFilesUser($id)):
				foreach($files as $item):
					@unlink('uploadedfiles/'.$item->NameFile);
				endforeach;
			endif;
			if($one = Users::getPr($id)):
				$one->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ������������ ������ "����� ���������"
	public function actionIndexworkspr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if(Users::getPr($id)):
				Url::remember();
				$query = Userfiles::getFilesNeedUser($id);
				$cloneQuery = clone $query;
				$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 10]);
				$model = $query->offset($pages->offset)
					->limit($pages->limit)
					->all();
					
				return $this->render('indexworkspr', ['model' => $model, 'pages' => $pages]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "������"
	*/
	public function actionIndexcom(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchCom();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexcom', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������� ����� ������
	public function actionCreatecom(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new CreateCom();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createcom', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� �������� ������
	public function actionEditcom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($model = Users::getCom($id)):
				$one = new EditCom();
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
			endif;
			return $this->render('editcom', ['one' => $one, 'model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������� �������� ������
	public function actionDeletecom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($files = Userfiles::getFilesUser($id)):
				foreach($files as $item):
					@unlink('uploadedfiles/'.$item->NameFile);
				endforeach;
			endif;
			if($one = Users::getCom($id)):
				$one->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ������������ ������ "����� ���������"
	public function actionIndexworkscom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if(Users::getCom($id)):
				Url::remember();
				$query = Userfiles::getFilesNeedUser($id);
				$cloneQuery = clone $query;
				$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 10]);
				$model = $query->offset($pages->offset)
					->limit($pages->limit)
					->all();
					
				return $this->render('indexworkscom', ['model' => $model, 'pages' => $pages]);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ������������ ������ "������ ������"
	public function actionIndexpartteam($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchPartteam();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			return $this->render('indexpartteam', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ��������� �������� � �������
	public function actionCreatechild(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new CreatePartteam();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('createchild', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��� ���� �������� ������
	public function actionEditchild($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($model = Partteam::getChild($id)):
				$one = new EditPartteam;
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editchild', ['one' => $one, 'model' => $model, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	// ����� ������� �������� ������
	public function actionDelchild($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			if($one = Partteam::getChild($id)):
				$one->delete();
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	
	/**
	* ����� ������������ ���� �� ��������� ������ �����
	*/
	public function actionAddfile(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$url = Url::previous();
			$model = new Loadingfiles();
			
			if($model->load(Yii::$app->request->post())):
				$model->files = UploadedFile::getInstances($model, 'files');
				if($model->upload()):
					return $this->redirect($url);
				endif;
			endif;
			
			return $this->render('addfile', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ��������� �� �������� ������ ������
	public function actionDownload($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($one = Userfiles::getFile($id)):
				return Yii::$app->response->sendFile('uploadedfiles/'.$one->NameFile);
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ��������� �� ������� ��������� �����
	public function actionDelfile($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if($one = Userfiles::getFile($id)):
				@unlink('uploadedfiles/'.$one->NameFile);
				$one->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "���������� ����� �� �������� ��������� ���������"
	*/
	public function actionIndexevapr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$query = Bidpr::getSelectEva($id);
			$cloneQuery = clone $query;
			$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 10]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			if(!Yii::$app->session->has('value') or (Yii::$app->session->get('id') != Yii::$app->session->get('value'))):
				$session = new Session;
				$session->open();
				$session->set('value', $id);
			endif;
			
			return $this->render('indexevapr', ['model' => $model, 'pages' => $pages, 'id' => $id]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ������ "������� ����� �� ��������� ���������"
	public function actionAddbidpr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchPr();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			$limit = Crudevalutionpr::getOne($id);
			
			return $this->render('addbidpr', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'limit' => $limit, 'id' => $id]);
		endif;
		return $this->goHome();
	}
	// ����� ��������� ����� �� ��������� ���������
	public function actionAddpr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$model = new BidPr();
			$model->IdEvalution = Yii::$app->session->get('value');
			$model->IdUser = $id;
			$model->save();
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ������� ����� ����� ���������
	public function actionDeleteevapr($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if(!Yii::$app->session->has('value')):
				if($one = Bidpr::findUser(Yii::$app->session->get('id'), $id)):
					$one->delete();
				endif;
				if(Evalutionpr::findUser(Yii::$app->session->get('id'), $id)):
					Evalutionpr::deleteAll(['IdEvalution' => Yii::$app->session->get('id'), 'IdPartaker' => $id]);
				endif;
				if($result = Resultspr::findUser(Yii::$app->session->get('id'), $id)):
					$result->delete();
				endif;
			else:
				if($one = Bidpr::findUser(Yii::$app->session->get('value'), $id)):
					$one->delete();
				endif;
				if(Evalutionpr::findUser(Yii::$app->session->get('value'), $id)):
					Evalutionpr::deleteAll(['IdEvalution' => Yii::$app->session->get('value'), 'IdPartaker' => $id]);
				endif;
				if($result = Resultspr::findUser(Yii::$app->session->get('value'), $id)):
					$result->delete();
				endif;
			endif;
			
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ "���������� ����� �� �������� ��������� ������"
	*/
	public function actionIndexevacom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$query = Bidcom::getSelectEva($id);
			$cloneQuery = clone $query;
			$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 10]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			if(!Yii::$app->session->has('value') or (Yii::$app->session->get('id') != Yii::$app->session->get('value'))):
				$session = new Session;
				$session->open();
				$session->set('value', $id);
			endif;
			
			return $this->render('indexevacom', ['model' => $model, 'pages' => $pages, 'id' => $id]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ������ "������� ����� �� ��������� ������"
	public function actionAddbidcom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$searchModel = new SearchCom();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			$limit = Crudevalutioncom::getOne($id);
			
			return $this->render('addbidcom', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel, 'limit' => $limit, 'id' => $id]);
		endif;
		return $this->goHome();
	}
	// ����� ��������� ����� �� ��������� ������
	public function actionAddcom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			$model = new Bidcom();
			$model->IdEvalution = Yii::$app->session->get('value');
			$model->IdUser = $id;
			$model->save();
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ������� ����� ����� ������
	public function actionDeleteevacom($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			if(!Yii::$app->session->has('value')):
				if($one = Bidcom::findUser(Yii::$app->session->get('id'), $id)):
					$one->delete();
				endif;
				if(Evalutioncom::findUser(Yii::$app->session->get('id'), $id)):
					Evalutioncom::deleteAll(['IdEvalution' => Yii::$app->session->get('id'), 'IdCommand' => $id]);
				endif;
				if($result = Resultscom::findUser(Yii::$app->session->get('id'), $id)):
					$result->delete();
				endif;
			else:
				if($one = Bidcom::findUser(Yii::$app->session->get('value'), $id)):
					$one->delete();
				endif;
				if(Evalutioncom::findUser(Yii::$app->session->get('value'), $id)):
					Evalutioncom::deleteAll(['IdEvalution' => Yii::$app->session->get('value'), 'IdCommand' => $id]);
				endif;
				if($result = Resultscom::findUser(Yii::$app->session->get('value'), $id)):
					$result->delete();
				endif;
			endif;
			
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* Функция представления страницы "Общий итог по командным оцениваниям"
	*/
	public function actionAllrescom(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$query = Crudevalutioncom::getResult();
			$countQuery = clone $query;
			$pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			return $this->render('allrescom', ['model' => $model, 'pages' => $pages]);
		endif;
		return $this->goHome();
	}
	// Функция представления страницы "Выбранный общий итог по коммандной оцениваний"
	public function actionTotalcom($id){
		if(!Yii::$app->user->isGuest and ( Yii::$app->user->identity['AuthKey'] == 1 )):
			$url = Url::previous();
			$info = Crudevalutioncom::getOne($id);
			$partaker = Resultscom::getTotal($info->TodayDate);
			$allresult = Resultscom::getAllResult($info->TodayDate);
			$sum = 0;
			foreach($partaker as $item):
				foreach($allresult as $item_two):
					if($item->IdCommand == $item_two->IdCommand):
						$sum += $item_two->Result;
					endif;
				endforeach;
				$mas[] = ['result' => $sum, 'id' => $item->IdCommand];
				$sum = 0;
			endforeach;
			array_multisort($mas, SORT_DESC);
			
			return $this->render('totalcom', ['mas' => $mas, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	/**
	* Функция представления страницы "Общий итог по оцениваниям участников"
	*/
	public function actionAllrespr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 1)):
			Url::remember();
			$query = Crudevalutionpr::getResult();
			$countQuery = clone $query;
			$pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			return $this->render('allrespr', ['model' => $model, 'pages' => $pages]);
		endif;
		return $this->goHome();
	}
	// Функция представления страницы "Выбранный общий итог по оцениванию участников"
	public function actionTotalpr($id){
		if(!Yii::$app->user->isGuest and ( Yii::$app->user->identity['AuthKey'] == 1 )):
			$url = Url::previous();
			$info = Crudevalutionpr::getOne($id);
			$partaker = Resultspr::getTotal($info->TodayDate);
			$allresult = Resultspr::getAllResult($info->TodayDate);
			$sum = 0;
			foreach($partaker as $item):
				foreach($allresult as $item_two):
					if($item->IdPartaker == $item_two->IdPartaker):
						$sum += $item_two->Result;
					endif;
				endforeach;
				$mas[] = ['result' => $sum, 'id' => $item->IdPartaker];
				$sum = 0;
			endforeach;
			array_multisort($mas, SORT_DESC);
			
			return $this->render('totalpr', ['mas' => $mas, 'url' => $url]);
		endif;
		return $this->goHome();
	}
}