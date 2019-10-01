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
use app\models\Tables\Users;
use app\models\Tables\Partteam;
use app\models\Tables\Crudevalutioncom;
use app\models\Tables\Bidcom;
use app\models\Tables\Userfiles;
use app\models\Login\LoginCom;
use app\models\Signup\SignupCom;
use app\models\Create\CreatePartteam;
use app\models\Edit\EditCom;
use app\models\Edit\EditPartteam;
use app\models\Search\SearchPartteam;
use app\models\Search\SearchBidCom;
use app\models\Files\Loadingfiles;

class CommandsController extends Controller
{
	/**	
	* ����� ������������ ���� �� ���������� ������
	*/
	public function actionLogin(){
		if(Yii::$app->user->isGuest):
			$url = Url::previous();
			$model = new LoginCom();
			
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
	* ����� ������������ ���� �� ����������� ������
	*/
	public function actionSignup(){
		if(Yii::$app->user->isGuest):
			$url = Url::previous();
			$model = new SignupCom();
			
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
	* ����� ������������ ������ �������
	*/
	public function actionIndexcom(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
			Url::remember();
			$dataProvider = new ActiveDataProvider(
				[
					'query' => Users::find()->where(['IdUser' => Yii::$app->user->identity['IdUser']]),
				]
			);
			$searchModel = new SearchPartteam();
			$dataProviderTwo = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexcom', ['dataProvider' => $dataProvider, 'dataProviderTwo' => $dataProviderTwo, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��� ���� ������
	public function actionEditcom(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
			$url = Url::previous();
			if($model = Users::getCom(Yii::$app->user->identity['IdUser'])):
				$one = new EditCom();
				if($one->load(Yii::$app->request->post())):
					if($one->validate() and $one->save()):
						return $this->redirect($url);
					endif;
				endif;
				return $this->render('editcom', ['one' => $one, 'model' => $model, 'url' => $url]);
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ��������� �������� � �������
	public function actionAddpr(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
			$url = Url::previous();
			$model = new CreatePartteam();
			if($model->load(Yii::$app->request->post())):
				if($model->validate() and $model->save()):
					return $this->redirect($url);
				endif;
			endif;
			return $this->render('addpr', ['model' => $model, 'url' => $url]);
		endif;
		return $this->goHome();
	}
	// ����� ������������ ���� �� ������������� ��� ���� �������� ������
	public function actionEditchild($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
			$url = Url::previous();
			if(($model = Partteam::getChild($id)) and ($model->IdUser == Yii::$app->user->identity['IdUser'])):
				$one = new EditPartteam();
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
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
			$url = Url::previous();
			if(($one = Partteam::getChild($id)) and ($one->IdUser == Yii::$app->user->identity['IdUser'])):
				$one->delete();
			endif;
			return $this->redirect($url);
		endif;
		return $this->goHome();
	}
	/** 
	* ����� ������������ ������ ��� �����
	*/
	public function actionIndexworks(){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
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
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
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
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
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
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
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
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
			Url::remember();
			$searchModel = new SearchBidCom();
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			
			return $this->render('indexbid', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
		endif;
		return $this->goHome();
	}
	// ����� ��������� �� ����������� �������� �����
	public function actionAddbid($id){
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4) and Userfiles::getUser()):
			$limit = Crudevalutioncom::getOne($id);
			if((($limit->Limit != Bidcom::getAllCount($id)) or ($limit->Limit == 0))	// �������� �� �������� �����
				and (!Bidcom::getMyBid($id))): 											// �������� ����������� �� ���� � �� �� �����																								// �������� ����������� ����� ���������
					$model = new Bidcom();
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
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
			$date = Crudevalutioncom::getOne($id);
			if(($date->TodayDate != date('Y-m-d')) and ($one = Bidcom::getOne($id))):
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
		if(!Yii::$app->user->isGuest and (Yii::$app->user->identity['AuthKey'] == 4)):
			Url::remember();
			$dataProvider = new ActiveDataProvider(
				[
					'query' => Bidcom::getAllMyBid(),
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