<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\helpers\Url;
use yii\web\UploadedFile;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
* ��������� ������
*/
use app\models\Login\LoginPr;
use app\models\Signup\SignupPr;
use app\models\Tables\Users;
use app\models\Tables\Userfiles;
use app\models\Tables\Crudevalutionpr;
use app\models\Tables\Bidpr;
use app\models\Search\SearchPr;
use app\models\Search\SearchBidPr;
use app\models\Edit\EditPr;
use app\models\Files\Loadingfiles;

class PartakerController extends Controller
{
	/** 
	* ����� ������������ ���� ���������� ��������
	*/
	public function actionLogin(){
		if(Yii::$app->user->isGuest):
			$url = Url::previous();
			$model = new LoginPr();
			
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
	* ����� ������������ ���� ����������� ��������
	*/
	public function actionSignup(){
		if(Yii::$app->user->isGuest):
			$url = Url::previous();
			$model = new SignupPr();

			if($model->load(Yii::$app->request->post()) and $model->validate()):
				if($user = $model->signup()):
					if(Yii::$app->getUser()->login($user)):
						return $this->goHome();
					endif;
				endif;
			endif;
			
			return $this->render('signup', ['model' => $model, 'url' => $url]);
		endif;
		
		return $this->goHome();
	}
	/** 
	* ����� ������������ ������ ��������
	*/
	public function actionIndexpr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
			Url::remember();
			$searchModel = new SearchPr();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexpr', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��� ���� ���������
	public function actionEditpr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
			$url = Url::previous();
			if($model = Users::getPr(Yii::$app->user->identity['IdUser'])):
				$one = new EditPr();
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editpr', ['one' => $one, 'model' => $model, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	/** 
	* ����� ������������ ������ ��� �����
	*/
	public function actionIndexworks(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
			Url::remember();
			$query = Userfiles::getFiles();
			$cloneQuery = clone $query;
			$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 10]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			return $this->render('indexworks', ['model' => $model, 'pages' => $pages]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ��������� ������ �����
	public function actionAddfile(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
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
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
			$url = Url::previous();
			if($one = Userfiles::getOne($id)):
				return Yii::$app->response->sendFile('uploadedfiles/'.$one->NameFile);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	// ����� ��������� �� ������� ��������� �����
	public function actionDelfile($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
			$url = Url::previous();
			if($one = Userfiles::getOne($id)):
				@unlink('uploadedfiles/'.$one->NameFile);
				$one->delete();
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ �����
	*/
	public function actionIndexbid(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
			Url::remember();
			$searchModel = new SearchBidPr();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexbid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ��������� �� ����������� �������� �����
	public function actionAddbid($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3) and Userfiles::getUser()):
			$limit = Crudevalutionpr::getOne($id);
			if((($limit->Limit != Bidpr::getAllCount($id)) or ($limit->Limit == 0))		// �������� �� �������� �����
				and (!Bidpr::getMyBid($id))): 											// �������� ����������� �� ���� � �� �� �����																								// �������� ����������� ����� ���������
					$model = new Bidpr();
					$model->IdEvalution = $id;
					$model->IdUser = Yii::$app->user->identity['IdUser'];
					$model->save();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	// ����� ��������� �� ������� �����
	public function actionDelbid($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
			$date = Crudevalutionpr::getOne($id);
			if(($date->TodayDate != date('Y-m-d')) and ($one = Bidpr::getOne($id))):
				$one->delete();
			endif;
			return $this->redirect(Url::previous());
		endif;
		return $this->goHome();
	}
	/**
	* ����� ������������ ������ ��� �����
	*/
	public function actionIndexmybid(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 3)):
			Url::remember();
			$dataProvider = new ActiveDataProvider(
				[
					'query' => Bidpr::getAllMyBid(),
					'pagination' => [
						'pageSize' => 10
					]
				]
			);
			
			return $this->render('indexmybid', ['dataProvider' => $dataProvider]);
		endif;
		return $this->goHome();
	}
}
?>