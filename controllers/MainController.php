<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\helpers\Url;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;

/**
* Подключаемые модули
*/
use app\models\Email\SendEmailPr;
use app\models\Email\SendEmailCom;
use app\models\Email\ResetPasswordCom;
use app\models\Tables\Partteam;
use app\models\Tables\Resultspr;
use app\models\Tables\Resultscom;
use app\models\Search\SearchExp;
use app\models\Search\SearchPr;
use app\models\Search\SearchCom;
use app\models\Search\SearchResultPr;
use app\models\Search\SearchResultCom;

class MainController extends Controller
{
	/** 
	* Функция представления главной страницы
	*/
	public function actionIndex(){
		Url::remember();
		if(Yii::$app->session->has('value')):
			Yii::$app->session->remove('value');
		endif;
		return $this->render('index');
	}
	/** 
	* Функция представления страницы ошибки
	*/
	public function actions(){
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			]
		];
	}
	/** 
	* Функция необходимая для выхода из учетной записи для авторизованных пользователей
	*/
	public function actionLogout(){
		if(!Yii::$app->user->isGuest):
			Yii::$app->user->logout();
		endif;
		
		return $this->goHome();
	}
	/** 
	* Функция отправки писем на почту для восстановления пароля
	*/
	public function actionSendemailpr()
	{
		if(Yii::$app->user->isGuest):
			$model = new SendEmailPr();
			$url = Url::previous();
			
			if ($model->load(Yii::$app->request->post())) {
				if ($model->validate()) {
						if ($model->sendEmail()) :
							Yii::$app->getSession()->setFlash('warning', 'Проверьте вашу почту.');
							return $this->goHome();
						else:
							Yii::$app->getSession()->setFlash('error', 'Нельзя сбросить пароль.');
						endif;
					return;
				}
			}
			
			return $this->render('sendemailpr', ['model' => $model, 'url' => $url]);
		endif;
		
		return $this->goHome();
	}
	/** 
	* Функция отправки писем на почту для восстановления пароля
	*/
	public function actionSendemailcom()
	{
		if(Yii::$app->user->isGuest):
			$model = new SendEmailCom();
			$url = Url::previous();
			
			if ($model->load(Yii::$app->request->post())) {
				if ($model->validate()) {
						if ($model->sendEmail()):
							Yii::$app->getSession()->setFlash('warning', 'Проверьте вашу почту.');
							return $this->goHome();
						else:
							Yii::$app->getSession()->setFlash('error', 'Нельзя сбросить пароль.');
						endif;
					return;
				}
			}

			return $this->render('sendemailcom', ['model' => $model, 'url' => $url]);
		endif;
		
		return $this->goHome();
	}
	/** 
	* Функция представления страницы для сброса и установки нового пароля в случае если его забыли
	*/
	public function actionResetpasswordcom($key)
	{
		try {
			$model = new ResetPasswordCom($key);
		}
		catch (InvalidParamException $e){
			throw new BadRequestHttpException($e->getMessage());
		}
		if ($model->load(Yii::$app->request->post())) {
			if ($model->validate() and $model->resetPassword()) {
				Yii::$app->getSession()->setFlash('success', 'Пароль изменен.');
				return $this->redirect(['/index']);
			}
		}

		return $this->render('resetpasswordcom', ['model' => $model]);
	}
	/** 
	* Функция представления страницы участников
	*/
	public function actionIndexpr(){
		Url::remember();
		$searchModel = new SearchPr();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		
		return $this->render('indexpr', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
	}
	/** 
	* Функция представления странцы команд
	*/
	public function actionIndexcom(){
		Url::remember();
		$searchModel = new SearchCom();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		
		
		return $this->render('indexcom', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
	}
	/** 
	* Функция представления страницы экспертный совет
	*/
	public function actionIndexexp(){
		Url::remember();
		$searchModel = new SearchExp();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		
		return $this->render('indexexp', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
	}
	/**
	* Функция представления страницы "Результаты оценивания участников"
	*/
	public function actionIndexresultspr()
	{
		Url::remember();
		$searchModel = new SearchResultPr();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		
		return $this->render('indexresultspr', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
	}
	/**
	* Функция представления страницы результатов выбранной оценивании
	*/
	public function actionIndexselectpr($id)
	{
		$url = Url::previous();
		if($info = Resultspr::checkExistResult($id)):
			$query = Resultspr::getResult($id);
			$cloneQuery = clone $query;
			$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 15]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			return $this->render('indexselectpr', ['query' => $query, 'model' => $model, 'pages' => $pages, 'info' => $info, 'url' => $url]);
		endif;
		
		return $this->redirect($url);
	}
	// Функция представления мониторинга результатов по участникам
	public function actionGraphresultpr($id){
		$url = Url::previous();
		if(Resultspr::checkExistResult($id)):
			$graph = (new \yii\db\Query())->select(['Fio as Label', 'Result as Value'])
				->from('resultspr')
				->where(['IdEvalution' => $id])
				->orderby(['Result' => SORT_DESC])
				->limit(20)
				->all();
				
			$graph = json_encode($graph, JSON_UNESCAPED_UNICODE);
			
			return $this->render('graphresultpr', ['graph' => $graph, 'id' => $id]);
		endif;
		return $this->redirect($url);
	}
	/**
	* Функция представления страницы "Результаты оценивания команд"
	*/
	public function actionIndexresultscom()
	{
		Url::remember();
		$searchModel = new SearchResultCom();
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		
		return $this->render('indexresultscom', ['dataProvider' => $dataProvider, 'searchModel' => $searchModel]);
	}
	/**
	* Функция представления страницы результатов выбранной оценивании
	*/
	public function actionIndexselectcom($id)
	{
		$url = Url::previous();
		if($info = Resultscom::checkExistResult($id)):
			$query = Resultscom::getResult($id);
			$cloneQuery = clone $query;
			$pages = new Pagination(['totalCount' => $cloneQuery->count(), 'pageSize' => 15]);
			$model = $query->offset($pages->offset)
				->limit($pages->limit)
				->all();
			
			return $this->render('indexselectcom', ['query' => $query, 'model' => $model, 'pages' => $pages, 'info' => $info, 'url' => $url]);
		endif;
		
		return $this->redirect($url);
	}
	// Функция представления мониторинга результатов по командам
	public function actionGraphresultcom($id){
		$url = Url::previous();
		if(Resultscom::checkExistResult($id)):
			$graph = (new \yii\db\Query())->select(['NameCommand as Label', 'Result as Value'])
				->from('resultscom')
				->where(['IdEvalution' => $id])
				->orderby(['Result' => SORT_DESC])
				->limit(20)
				->all();
				
			$graph = json_encode($graph, JSON_UNESCAPED_UNICODE);
			
			return $this->render('graphresultcom', ['graph' => $graph, 'id' => $id]);
		endif;
		return $this->redirect($url);
	}
	/**
	* Функция представления страницы "участники команды"
	*/
	public function actionIndexpartteam($id){
		$url = Url::previous();
		$model = Partteam::getChilds($id);
		return $this->render('indexpartteam', ['model' => $model, 'url' => $url]);
	}
	
	/**
	* 
	*/
	public function actionHelp(){
		Url::remember();
		return $this->render('help', ['url' => $url]);
	}
}
?>